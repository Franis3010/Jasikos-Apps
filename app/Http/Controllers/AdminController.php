<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Eager load service and user for each cart entry
        $cartedServices = Cart::with(['user', 'service'])->get();

        return view('adminhomepage', compact('cartedServices'));
    }
}