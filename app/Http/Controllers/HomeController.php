<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Check if the logged-in user is an admin
        if (Auth::user()->role == 'admin') {
            return redirect()->route('admin.home');
        }

        // Regular homepage for non-admin users
        $services = Service::all();
        return view('home', compact('services'));
    }
}