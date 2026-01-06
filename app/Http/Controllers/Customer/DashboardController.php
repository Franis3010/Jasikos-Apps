<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        // Stats orders
        $base = Order::where('customer_id', $customer->id);
        $stats = [
            'total'            => (clone $base)->count(),
            'awaiting_payment' => (clone $base)->where('status','awaiting_payment')->count(),
            'processing'       => (clone $base)->whereIn('status',['processing','delivered'])->count(),
            'completed'        => (clone $base)->where('status','completed')->count(),
            'payment_submitted'=> (clone $base)->where('payment_status','submitted')->count(),
        ];

        // Keranjang count
        $cart = $customer->cart()->withCount('items')->first();
        $cartCount = $cart->items_count ?? 0;

        // Orders terbaru
        $latestOrders = (clone $base)->with('designer.user')->latest()->take(5)->get();

        // Orders yang perlu aksi bayar (pending/submitted)
        $payables = (clone $base)
            ->with('designer.user')
            ->whereIn('status', ['awaiting_payment'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Profil customer sederhana (buat alert kelengkapan)
        $profileIncomplete = !$customer->address || !$customer->city || !$customer->province;

        return view('customer.dashboard', compact(
            'stats','cartCount','latestOrders','payables','profileIncomplete'
        ));
    }
}
