<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Design, Order, PaymentProof};

class DashboardController extends Controller
{
    public function index()
    {
        $counts = [
            'users' => [
                'total' => User::count(),
                'admin' => User::where('role', 'admin')->count(),
                'designer' => User::where('role', 'designer')->count(),
                'customer' => User::where('role', 'customer')->count(),
            ],
            'designs' => [
                'total' => Design::count(),
                'published' => Design::where('status', 'published')->count(),
                'draft' => Design::where('status', 'draft')->count(),
            ],
            'orders' => [
                'total' => Order::count(),
                'awaiting'  => Order::where('status','awaiting_payment')->count(),
                'processing'=> Order::where('status','processing')->count(),
                'completed' => Order::where('status','completed')->count(),
            ],
            'payments' => [
                'submitted' => PaymentProof::where('status', 'submitted')->count(),
            ]
        ];

        $latestOrders = Order::with(['customer.user', 'designer.user'])
            ->latest()->take(7)->get();

            return view('admin.dashboard', compact('counts', 'latestOrders'));
    }
}
