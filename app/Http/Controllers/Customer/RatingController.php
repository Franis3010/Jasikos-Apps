<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Order, Rating};

class RatingController extends Controller
{
     public function store(Request $request, Order $order)
{
    // Hanya pemilik
    if ($order->customer_id !== Auth::user()->customer->id) abort(403);

    // Hitung: semua item sudah completed?
    $allItemsCompleted = $order->items()
        ->where('item_status', '!=', 'completed')
        ->count() === 0;


    $canRate = $allItemsCompleted &&
        ($order->payment_status === 'paid' || $order->shipping_status === 'delivered');

    if (! $canRate) {
        return back()->with(
            'error',
            'The order is not complete. Rating cannot be given yet.'
        );
    }

    // Cek sudah pernah rating belum
    if ($order->rating) {
        return back()->with('info','You have already rated this order.');
    }

    $data = $request->validate([
        'stars'  => ['required','integer','min:1','max:5'],
        'review' => ['nullable','string','max:1000'],
    ]);

    Rating::create([
        'order_id'    => $order->id,
        'customer_id' => $order->customer_id,
        'designer_id' => $order->designer_id,
        'stars'       => $data['stars'],
        'review'      => $data['review'] ?? null,
    ]);

    return back()->with('success','Thank you! Rating successfully submitted.');
}

}
