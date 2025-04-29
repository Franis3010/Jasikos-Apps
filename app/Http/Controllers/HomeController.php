<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::all();

        if (Auth::check()) {
            return view('home_user', compact('services'));
        } else {
            return view('home', compact('services'));
        }
    }

    public function search(Request $request)
    {
        $query = Service::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $services = $query->get();

        if (Auth::check()) {
            return view('home_user', compact('services'));
        } else {
            return view('home', compact('services'));
        }
    }

    

    public function viewLogin()
    {
        $services = Service::all();
        return view('home', compact('services'))->with('showLogin', true);
    }
}