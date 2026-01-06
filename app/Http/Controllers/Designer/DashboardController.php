<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Design;

class DashboardController extends Controller
{
     public function index()
    {
        $designer = Auth::user()->designer;

        $stats = [
            'designs'   => Design::where('designer_id', $designer->id)->count(),
            'published' => Design::where('designer_id', $designer->id)->where('status','published')->count(),
        ];

        return view('designer.dashboard', compact('designer','stats'));
    }
}
