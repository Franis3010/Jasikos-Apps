<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class CartController extends Controller
{
    // Display the cart
    public function show()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // Add service to the cart
    public function add(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $service->id,
                'name' => $service->name,
                'quantity' => 1,
                'price' => $service->price,
                'image' => $service->image,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.show');
    }

    // Remove service from the cart
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.show');
    }

    // Clear the entire cart
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.show');
    }
}