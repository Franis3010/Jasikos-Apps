<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\{Order, PaymentProof, OrderDeliverable, OrderItem, OrderStatusLog};
use App\Models\CustomRequest;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['designer.user'])
            ->where('customer_id', Auth::user()->customer->id)
            ->latest()
            ->paginate(12);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->ensureOwner($order);
        $order->load(['items.design','designer','items.deliverables','paymentProofs']);
        return view('customer.orders.show', compact('order'));
    }

   public function uploadProof(Request $request, Order $order)
{
    $this->ensureOwner($order);

    // ⛔ Tambahan: jangan boleh upload kalau order sudah cancelled atau sudah paid
    if ($order->status === 'cancelled' || $order->payment_status === 'paid') {
        return back()->with('error', 'Payment proof cannot be uploaded for this order.');
    }

    $data = $request->validate([
        'image'      => ['required','image','max:4096'],
        'amount'     => ['nullable','integer','min:0'],
        'payer_name' => ['nullable','string','max:100'],
    ]);

    $path = $request->file('image')->store("payment_proofs/{$order->id}", 'public');

    PaymentProof::create([
        'order_id'    => $order->id,
        'uploader_id' => Auth::id(),
        'image_path'  => $path,
        'amount'      => $data['amount'] ?? null,
        'payer_name'  => $data['payer_name'] ?? null,
        'status'      => 'submitted',
    ]);

    $order->update(['payment_status' => 'submitted']);

    return back()->with('success', 'Payment proof uploaded. Awaiting designer confirmation.');
}


    public function downloadDeliverable(OrderDeliverable $deliverable)
{
    $order = $deliverable->orderItem->order;

    // 1) Kepemilikan
    if ($order->customer_id !== auth()->user()->customer->id) abort(403);

    // 2) Visibility rules sinkron dgn Blade:
    //    - paid: order harus paid
    //    - delivered: item sudah delivered/completed
    //    - completed: order completed
    $item = $deliverable->orderItem;
    $visible =
        ($deliverable->visible_after === 'paid'      && $order->payment_status === 'paid')
     || ($deliverable->visible_after === 'delivered' && in_array($item->item_status, ['delivered','completed']))
     || ($deliverable->visible_after === 'completed' && $order->status === 'completed');

    if (!$visible) {
        return back()->with('warning', 'Deliverable not available yet.');
    }

    // 3) Expiry
    if ($deliverable->expires_at && now()->greaterThan($deliverable->expires_at)) {
        return back()->with('warning', 'The file has expired.');
    }

    // 4) Download limit
    if (!is_null($deliverable->download_limit) && $deliverable->download_limit <= 0) {
        return back()->with('warning', 'Download limit reached.');
    }

    // 5) File exist?
    if (!Storage::disk('public')->exists($deliverable->file_path)) {
        return back()->with('error', 'File not found.');
    }

    // 6) Kurangi limit kalau ada
    if (!is_null($deliverable->download_limit)) {
        $deliverable->decrement('download_limit');
    }

    return Storage::disk('public')->download($deliverable->file_path);
}

    private function ensureOwner(Order $order): void
    {
        if ($order->customer_id !== Auth::user()->customer->id) abort(403);
    }

    public function acceptItem(OrderItem $item)
{
    $order = $item->order;

    // pastikan pemilik
    if ($order->customer_id !== Auth::user()->customer->id) abort(403);

    if (! in_array($item->item_status, ['delivered','revised'])) {
        return back()->with('warning','Item is not ready to be approved.');
    }

    // tandai item selesai
    $item->update([
        'item_status' => 'completed',
        // 'accepted_at' => now(),
    ]);

    // jika semua item sudah completed → order completed
   $allCompleted = $order->items()->where('item_status','!=','completed')->count() === 0;

if ($allCompleted) {
    $from = $order->status;

    // kalau sudah paid (kasus bayar dulu) langsung completed
    // kalau belum, tunggu pembayaran dulu
    $newStatus = $order->payment_status === 'paid'
        ? 'completed'
        : 'awaiting_payment';

    $order->update([
        'status'       => $newStatus,
        'delivered_at' => now(),
    ]);

    OrderStatusLog::create([
        'order_id'    => $order->id,
        'from_status' => $from,
        'to_status'   => $newStatus,
        'changed_by'  => Auth::id(),
        'note'        => $newStatus === 'completed'
            ? 'Order completed: all items accepted and payment confirmed'
            : 'All items accepted by customer, awaiting payment'
    ]);
}


    // sinkron ke CustomRequest (bila order dari CR)
    if ($cr = $this->crFromOrder($order)) {
        $cr->update(['status' => $allCompleted ? 'completed' : 'in_progress']);
    }

    if ($allCompleted && isset($cr) && $cr) {
        return redirect()->route('customer.custom-requests.index')
            ->with('success','Item accepted. Custom Request marked as completed.');
    }

    return back()->with('success','Item accepted. Thank you!');
}


public function requestRevision(Request $request, OrderItem $item)
{
    $order = $item->order;

    // pastikan pemilik
    if ($order->customer_id !== Auth::user()->customer->id) abort(403);

    // ⛔ JANGAN paksa harus paid (hapus guard lama)
    // if ($order->payment_status !== 'paid') return back()->with('warning','Payment has not been confirmed.');

    $data = $request->validate([
        'note' => ['required','string','max:1000'],
    ]);

    if (! in_array($item->item_status, ['delivered','revised'])) {
        return back()->with('warning','Item is not at a stage that can be revised.');
    }

    // cek & update limit revisi pada CR (jika terkait)
    if ($cr = $this->crFromOrder($order)) {
        if ($cr->revisions_used >= $cr->revisions_allowed) {
            return back()->with('warning','Revision limit has been reached.');
        }
        $cr->increment('revisions_used');
        if ($cr->status !== 'in_progress') {
            $cr->update(['status' => 'in_progress']);
        }
    }

    // tandai item revised
    $item->update(['item_status' => 'revised']);

    // pastikan order kembali ke processing + catat log
    $from = $order->status;
    if ($order->status !== 'processing') {
        $order->update(['status' => 'processing']);
    }

    OrderStatusLog::create([
        'order_id'    => $order->id,
        'from_status' => $from,
        'to_status'   => 'processing',
        'changed_by'  => Auth::id(),
        'note'        => 'Customer requested a revision: '.$data['note'],
    ]);

    // simpan catatan revisi ke comments supaya terlihat di Designer
    $item->comments()->create([
        'user_id' => Auth::id(),
        'message' => $data['note'],
    ]);

    return back()->with('success','Revision request sent to the designer.');
}



    private function crFromOrder(Order $order): ?CustomRequest
    {
        if (!$order->note || !str_starts_with($order->note, 'CR: ')) return null;
        $code = trim(str_replace('CR: ', '', $order->note));
        return CustomRequest::where('code', $code)->first();
    }

    public function confirmDelivered(Order $order)
    {
        $this->ensureOwner($order);
        if ($order->shipping_method !== 'ship') return back();

        $order->update([
          'shipping_status' => 'delivered',
          'delivered_at' => now(),
        ]);

        // boleh otomatis set order completed kalau semua item sdh completed
        return back()->with('success','Package confirmed as received.');
    }

  public function cancel(Request $request, Order $order)
{
    // pastikan pemilik
    if ($order->customer_id !== auth()->user()->customer->id) abort(403);

    // validasi alasan
    $data = $request->validate([
        'cancel_reason' => ['required', 'string', 'max:1000'],
    ]);

    // opsi: kalau mau tetap pakai rule cancellable, biarkan baris ini
    if (!$order->isCancellable()) {
        return back()->with('error', 'Order cannot be cancelled at this stage.');
    }

    // update status pembatalan
    $order->status        = 'cancelled';
    $order->cancel_reason = $data['cancel_reason'];
    $order->canceled_at   = now();
    $order->canceled_by   = auth()->id();
    $order->save();

    // log (opsional)
    \Log::info('ORDER CANCELLED', [
        'order_id'        => $order->id,
        'status'          => $order->status,
        'payment_status'  => $order->payment_status,
        'work_started_at' => $order->work_started_at,
        'canceled_at'     => $order->canceled_at,
    ]);
     if ($order->note && preg_match('/^CR:\s*([A-Z0-9\-]+)/i', $order->note, $m)) {
        $code = trim($m[1]);
        \App\Models\CustomRequest::where('code',$code)
            ->update(['status' => 'cancelled']);
    }

    return redirect()->route('customer.orders.index')
        ->with('success', 'Order successfully cancelled.');
}



}
