<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user is an admin
        if (Auth::check() && Auth::user()->role == 'admin') {
            // Redirect admins to the admin homepage
            return redirect()->route('admin.home');
        }

        // Continue to the next middleware/request handler
        return $next($request);
    }
}