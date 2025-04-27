<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function add($serviceId)
    {
        return redirect()->back()->with('success', 'Added to wishlist!');
    }
}