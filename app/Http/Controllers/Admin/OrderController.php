<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order, PaymentProof, OrderStatusLog};
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
     public function index(Request $request)
    {
        $status = $request->get('status');
        $pay    = $request->get('pay');

        $orders = Order::with(['customer.user','designer.user'])
            ->when($status, fn($q)=>$q->where('status',$status))
            ->when($pay, fn($q)=>$q->where('payment_status',$pay))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders','status','pay'));
    }
       public function show(Order $order)
    {
        $order->load(['items.design','customer.user','designer.user','paymentProofs'=>fn($q)=>$q->latest()]);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // Admin boleh override status & payment
        $data = $request->validate([
            'status' => ['nullable', Rule::in(['awaiting_payment','processing','delivered','completed','cancelled','declined'])],
            'payment_status' => ['nullable', Rule::in(['unpaid','submitted','paid','rejected'])],
            'proof_id' => ['nullable','integer','exists:payment_proofs,id'],
            'note' => ['nullable','string','max:500'],
        ]);

        if (!empty($data['proof_id'])) {
            $proof = PaymentProof::where('order_id',$order->id)->findOrFail($data['proof_id']);
            // terima bukti → set paid
            $proof->update(['status'=>'accepted','reviewed_by'=>auth()->id(),'reviewed_at'=>now()]);
            PaymentProof::where('order_id',$order->id)->where('id','<>',$proof->id)->where('status','submitted')
              ->update(['status'=>'rejected','reviewed_by'=>auth()->id(),'reviewed_at'=>now()]);
            $data['payment_status'] = 'paid';
            $data['status'] = $data['status'] ?? 'processing';
        }

        $fromStatus = $order->status;
        $order->update(array_filter([
            'status' => $data['status'] ?? null,
            'payment_status' => $data['payment_status'] ?? null,
        ], fn($v)=>!is_null($v)));

        if (($data['status'] ?? null) && $fromStatus !== $data['status']) {
            OrderStatusLog::create([
                'order_id'    => $order->id,
                'from_status' => $fromStatus,
                'to_status'   => $data['status'],
                'changed_by'  => auth()->id(),
                'note'        => $data['note'] ?? 'Admin update',
            ]);
        }

        return back()->with('success','Order updated.');
    }

}
