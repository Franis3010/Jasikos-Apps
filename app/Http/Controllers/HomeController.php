<?php

namespace App\Http\Controllers;

use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::all();
        return view('home', compact('services'));
    }

    public function viewLogin()
    {
        $services = Service::all();
        return view('home', compact('services'))->with('showLogin', true);
    }
}