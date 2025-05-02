<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function add($serviceId)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to add to wishlist.');
        }

        $user->wishlist()->attach($serviceId);

        return redirect()->route('wishlist.index')->with('success', 'Service added to your wishlist!');
    }

    public function remove($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to remove from wishlist.');
        }

        $user->wishlist()->detach($id);

        return back()->with('success', 'Service removed from your wishlist.');
    }

    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())->with('service')->get();
        return view('wishlist.index', compact('wishlists'));
    }
}