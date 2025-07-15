<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $cart = Cart::with('service')->where('user_id', Auth::id())->get();
        return view('cart.index', compact('cart'));
    }
    
    public function add(Request $request, $id)
    {
        $user = Auth::user();

        $existing = Cart::where('user_id', $user->id)->where('service_id', $id)->first();

        if ($existing) {
            $existing->quantity += 1;
            $existing->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'service_id' => $id,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.show')->with('success', 'Service added to your cart.');
    }

    public function clear()
    {
        $user = Auth::user();

        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('cart.show')->with('success', 'Cart cleared.');
    }

    public function updateState(Request $request, $id)
    {
        $request->validate([
            'state' => 'required|string',
        ]);

        $cartItem = Cart::findOrFail($id);
        $cartItem->state = $request->input('state');
        $cartItem->save();

        return redirect()->route('cart.show')->with('success', 'Status updated successfully.');
    }

    public function remove($id)
    {
        $user = Auth::user();

        $cartItem = Cart::where('user_id', $user->id)->where('id', $id)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.show')->with('success', 'Item removed from your cart.');
    }
    public function accept(Request $request, $id)
    {
        $cart = Cart::with('service')->findOrFail($id);

        $request->validate([
            'price' => ['required', 'numeric', 'min:' . $cart->service->min_price, 'max:' . $cart->service->max_price],
        ]);

        $cart->price = $request->price;
        $cart->state = Cart::STATE_IN_PROGRESS;
        $cart->save();

        return redirect()->back()->with('success', 'Request accepted with price updated.');
    }

    public function reject($id)
    {
        $cart = Cart::findOrFail($id);

        $cart->state = Cart::STATE_CANCELLED;
        $cart->save();

        return redirect()->back()->with('success', 'Request has been rejected.');
    }
}