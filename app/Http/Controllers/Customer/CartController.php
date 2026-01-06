<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Cart, CartItem, Design};

class CartController extends Controller
{
      public function index()
    {
        $customer = Auth::user()->customer;
        $cart = $customer->cart()->with(['items.design.designer.user'])->first();
        if (!$cart) {
            $cart = $customer->cart()->create();
        }
        

        $subtotal = $cart->items->sum(fn($it) => $it->price_snapshot * $it->qty);

        return view('customer.cart.index', compact('cart','subtotal'));
    }
     public function store(Design $design)
    {
        $customer = Auth::user()->customer;
        $cart = $customer->cart()->firstOrCreate();

        $item = $cart->items()->where('design_id', $design->id)->first();

        if ($item) {
            $item->increment('qty');
        } else {
            $cart->items()->create([
                'design_id' => $design->id,
                'designer_id' => $design->designer_id,
                'price_snapshot' => $design->price,
                'qty' => 1,
            ]);
        }

        return back()->with('success', 'Added to cart.');
    }

    public function destroy(CartItem $item)
    {
        // keamanan: hanya pemilik yang boleh
        if ($item->cart->customer_id !== Auth::user()->customer->id) abort(403);

        $item->delete();
        return back()->with('success', 'Item removed from cart.');
    }
}
