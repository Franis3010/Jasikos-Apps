<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\{Order, OrderItem, PaymentProof, OrderStatusLog, OrderDeliverable, Comment};

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $designerId = Auth::user()->designer->id;

        $orders = Order::with(['customer.user'])
            ->where('designer_id', $designerId)
            ->latest()
            ->paginate(12);

        return view('designer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->ensureOwner($order);

        $order->load([
            'items.design',
            'customer.user',
            'items.deliverables',
            'items.comments.user',
            'paymentProofs' => fn($q) => $q->latest()
        ]);

        return view('designer.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $this->ensureOwner($order);

        // Change order status (without 'completed')
        if ($request->filled('status')) {
            $status = $request->validate([
                'status' => ['required', Rule::in(['awaiting_payment','processing','delivered','cancelled','declined'])]
            ])['status'];

            $from = $order->status;
            $order->update(['status' => $status]);
            $this->logStatus($order, $from, $status, 'Updated by designer');

            return back()->with('success','Order status updated.');
        }

        // Change item status (without 'completed' — completed must come from customer)
        if ($request->filled('item_id') && $request->filled('item_status')) {
            $data = $request->validate([
                'item_id'     => ['required','integer','exists:order_items,id'],
                'item_status' => ['required', Rule::in(['processing','delivered','revised','cancelled'])],
            ]);

            $item = OrderItem::findOrFail($data['item_id']);
            if ($item->designer_id !== Auth::user()->designer->id || $item->order_id !== $order->id) abort(403);

            // If target is 'delivered', also set delivered_at
            if ($data['item_status'] === 'delivered') {
                $item->update([
                    'item_status'  => 'delivered',
                    'delivered_at' => now(),
                ]);
            } else {
                $item->update(['item_status' => $data['item_status']]);
            }

            return back()->with('success','Item status updated.');
        }

        return back()->with('success','No changes.');
    }

    // Confirm payment (accept proof)
  // Confirm payment (accept proof)
public function confirmPayment(Request $request, Order $order)
{
    $this->ensureOwner($order);

    $request->validate([
        'proof_id' => ['nullable','integer','exists:payment_proofs,id'],
        'note'     => ['nullable','string','max:500'],
    ]);

    // Mark selected proof as accepted (if any)
    if ($request->filled('proof_id')) {
        $proof = PaymentProof::where('order_id', $order->id)
            ->where('id', $request->proof_id)
            ->firstOrFail();

        $proof->update([
            'status'      => 'accepted',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        // (optional) reject other proofs that are still submitted
        PaymentProof::where('order_id',$order->id)
            ->where('id','<>',$proof->id)
            ->where('status','submitted')
            ->update([
                'status'      => 'rejected',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
    }

    $fromStatus = $order->status;

    // cek apakah semua item sudah completed
    $allCompleted = $order->items()
        ->where('item_status', '!=', 'completed')
        ->count() === 0;

    // tentukan status baru
    $toStatus = $fromStatus;

    // kalau semua item sudah selesai → completed
    if ($allCompleted) {
        $toStatus = 'completed';

        // kalau mau, isi delivered_at kalau masih null
        if (is_null($order->delivered_at)) {
            $order->delivered_at = now();
        }
    }
    // kalau masih pakai flow lama (status masih awaiting_payment)
    // bisa diarahkan ke processing
    elseif ($fromStatus === 'awaiting_payment') {
        $toStatus = 'processing';
    }

    // update payment
    $order->payment_status = 'paid';
    $order->paid_at        = now();
    $order->status         = $toStatus;
    $order->save();

    // catat log status
    $this->logStatus(
        $order,
        $fromStatus,
        $toStatus,
        $request->note ?? 'Payment confirmed by designer'
    );

    // sinkron status CustomRequest kalau ada
    if ($order->note && str_starts_with($order->note, 'CR: ')) {
        $code = trim(str_replace('CR: ','', $order->note));
        \App\Models\CustomRequest::where('code',$code)
            ->update(['status' => $allCompleted ? 'completed' : 'in_progress']);
    }

    return back()->with(
        'success',
        $allCompleted
            ? 'Payment confirmed. Order marked as completed.'
            : 'Payment confirmed. Order is still in progress.'
    );
}


    // Upload deliverable (output file)
    public function uploadDeliverable(Request $request, OrderItem $orderItem)
    {
        if ($orderItem->designer_id !== Auth::user()->designer->id) abort(403);

        $data = $request->validate([
            'file'           => ['required','file','max:10240'], // 10MB
            'visible_after'  => ['nullable', Rule::in(['paid','delivered','completed'])],
            'download_limit' => ['nullable','integer','min:1'],
            'expires_at'     => ['nullable','date'],
        ]);

        $path = $request->file('file')->store(
            "deliverables/order_{$orderItem->order_id}/item_{$orderItem->id}",
            'public'
        );

        OrderDeliverable::create([
            'order_item_id'  => $orderItem->id,
            'file_path'      => $path,
            'visible_after'  => $data['visible_after'] ?? 'delivered',
            'download_limit' => $data['download_limit'] ?? null,
            'expires_at'     => $data['expires_at'] ?? null,
        ]);

        // If previously processing/revised, change to delivered + set delivered_at
        if (in_array($orderItem->item_status, ['processing','revised'])) {
            $orderItem->update([
                'item_status'  => 'delivered',
                'delivered_at' => now(),
            ]);
        }

        // (optional) automatic comment log
        // Comment::create([
        //     'commentable_type' => OrderItem::class,
        //     'commentable_id'   => $orderItem->id,
        //     'user_id'          => Auth::id(),
        //     'message'          => 'Upload deliverable: '.basename($path),
        // ]);

        return back()->with('success','Deliverable file uploaded.');
    }

    public function commentItem(Request $request, OrderItem $item)
    {
        if ($item->designer_id !== Auth::user()->designer->id) abort(403);

        $data = $request->validate([
            'message' => ['required','string','max:1000'],
        ]);

        Comment::create([
            'commentable_type' => OrderItem::class,
            'commentable_id'   => $item->id,
            'user_id'          => Auth::id(),
            'message'          => $data['message'],
        ]);

        return back()->with('success','Comment sent.');
    }

    public function markRevised(Request $request, OrderItem $item)
    {
        if ($item->designer_id !== Auth::user()->designer->id) abort(403);

        $data = $request->validate([
            'note' => ['required','string','max:1000'],
        ]);

        $item->update(['item_status' => 'revised']);

        // ensure order returns to processing + log
        $order = $item->order;
        $from  = $order->status;
        if ($order->status !== 'processing') {
            $order->update(['status' => 'processing']);
            OrderStatusLog::create([
                'order_id'    => $order->id,
                'from_status' => $from,
                'to_status'   => 'processing',
                'changed_by'  => Auth::id(),
                'note'        => 'Designer marked revised: '.$data['note'],
            ]);
        }

        Comment::create([
            'commentable_type' => OrderItem::class,
            'commentable_id'   => $item->id,
            'user_id'          => Auth::id(),
            'message'          => $data['note'],
        ]);

        return back()->with('success','Item marked revised and comment sent.');
    }

    private function ensureOwner(Order $order): void
    {
        if ($order->designer_id !== Auth::user()->designer->id) abort(403);
    }

    private function logStatus(Order $order, ?string $from, string $to, ?string $note=null): void
    {
        OrderStatusLog::create([
            'order_id'    => $order->id,
            'from_status' => $from,
            'to_status'   => $to,
            'changed_by'  => Auth::id(),
            'note'        => $note,
        ]);
    }

 public function updateShipping(Request $request, Order $order)
{
    $this->ensureOwner($order);

    if ($order->shipping_method !== 'ship') {
        abort(404);
    }

    // STEP 1: sebelum paid -> set shipping fee
    if ($order->payment_status !== 'paid') {
        $data = $request->validate([
            'shipping_fee' => ['required','integer','min:0'],
        ]);

        $order->update([
            'shipping_fee' => $data['shipping_fee'],
        ]);

        return back()->with('success', 'Shipping fee saved. Customer can pay the updated total.');
    }

    // STEP 2: sesudah paid -> isi kurir & resi
    $data = $request->validate([
        'shipping_courier'     => ['required','string','max:100'],
        'shipping_tracking_no' => ['required','string','max:100'],
    ]);

    $order->update($data);

    return back()->with('success', 'Courier and tracking number saved.');
}


public function markShipped(Order $order)
{
    $this->ensureOwner($order);
    if ($order->shipping_method !== 'ship') return back();

    if ($order->payment_status !== 'paid') {
        return back()->with('warning','Order belum dibayar.');
    }
    if (!$order->shipping_courier || !$order->shipping_tracking_no) {
        return back()->with('warning','Isi courier & tracking dulu.');
    }

    $order->update([
        'shipping_status' => 'shipped',
        'shipped_at'      => now(),
        'status'          => 'delivered',
    ]);

    return back()->with('success','Order marked as shipped.');
}

}


