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

    public function remove($id)
    {
        $user = Auth::user();

        $cartItem = Cart::where('user_id', $user->id)->where('id', $id)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.show')->with('success', 'Item removed from your cart.');
    }
}