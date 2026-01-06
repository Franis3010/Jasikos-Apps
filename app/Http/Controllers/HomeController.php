<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Design, Category};

class HomeController extends Controller
{
    public function index()
    {
        $latest = Design::with(['categories','designer.user'])
            ->where('status','published')
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('home', compact('latest','categories'));
    }
}
