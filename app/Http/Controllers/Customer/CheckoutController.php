<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\{Order, OrderItem};

class CheckoutController extends Controller
{
      public function store(Request $request)
    {
        $customer = Auth::user()->customer;
        $cart = $customer->cart()->with(['items.design.designer'])->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->with('success', 'Keranjang kosong.');
        }

        // Validasi shipping
        $data = $request->validate([
            'shipping_method'   => ['required','in:digital,ship'],
            'ship_name'         => ['required_if:shipping_method,ship','nullable','string','max:100'],
            'ship_phone'        => ['required_if:shipping_method,ship','nullable','string','max:30'],
            'ship_address'      => ['required_if:shipping_method,ship','nullable','string','max:255'],
            'ship_city'         => ['nullable','string','max:100'],
            'ship_province'     => ['nullable','string','max:100'],
            'ship_postal_code'  => ['nullable','string','max:10'],
            // 'shipping_fee'      => ['nullable','integer','min:0'],
        ]);

        // Group by designer (multi order)
        $grouped = $cart->items->groupBy('designer_id');
        $groupCount = $grouped->count();

        // Ongkir yang diisi customer dianggap estimasi total → dibagi rata per order
        $shippingFeeTotal = (int)($data['shipping_fee'] ?? 0);
        $perOrderFee = $groupCount > 0 ? intdiv($shippingFeeTotal, $groupCount) : 0;
        $sisa = $groupCount > 0 ? ($shippingFeeTotal - ($perOrderFee * $groupCount)) : 0;

        $firstOrder = true;

        foreach ($grouped as $designerId => $items) {
            $designer = $items->first()->design->designer;

            $subtotal = $items->sum(fn($it) => $it->price_snapshot * $it->qty);
            $fee = 0;

            // bagi ongkir
            $shipping_fee = $perOrderFee + ($firstOrder ? $sisa : 0);
            $firstOrder = false;

            $order = Order::create([
                'code' => 'JAS-'.now()->format('Ym').'-'.strtoupper(Str::random(5)),
                'customer_id' => $customer->id,
                'designer_id' => $designerId,
                'status' => 'awaiting_payment',
                'payment_status' => 'unpaid',

                // snapshot tujuan bayar
                'pay_bank_name' => $designer->bank_name,
                'pay_bank_account_no' => $designer->bank_account_no,
                'pay_qris_image' => $designer->qris_image,

                // shipping
                'shipping_method'  => $data['shipping_method'],
                'shipping_status'  => $data['shipping_method']==='ship' ? 'pending' : null,
                'ship_name'        => $data['ship_name'] ?? null,
                'ship_phone'       => $data['ship_phone'] ?? null,
                'ship_address'     => $data['ship_address'] ?? null,
                'ship_city'        => $data['ship_city'] ?? null,
                'ship_province'    => $data['ship_province'] ?? null,
                'ship_postal_code' => $data['ship_postal_code'] ?? null,
                'shipping_fee'     => $data['shipping_method']==='ship' ? $shipping_fee : 0,

                // total
                'subtotal' => $subtotal,
                'fee'      => $fee,
                'total'    => $subtotal + $fee + ($data['shipping_method']==='ship' ? $shipping_fee : 0),
            ]);

            foreach ($items as $it) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'design_id' => $it->design_id,
                    'designer_id' => $designerId,
                    'title_snapshot' => $it->design->title,
                    'price_snapshot' => $it->price_snapshot,
                    'qty' => $it->qty,
                    'item_status' => 'processing',
                ]);
            }
        }

        // clear cart
        $cart->items()->delete();

        return redirect()->route('customer.orders.index')->with('success', 'Order created. Proceed to payment..');
    }
}
