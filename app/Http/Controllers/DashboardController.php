<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
        public function index()
    {
        $role = auth()->user()->role;
        return match ($role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'designer' => redirect()->route('designer.dashboard'),
            default    => redirect()->route('customer.dashboard'),
        };
    }

}
