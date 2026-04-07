<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsEmployee
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role_id != 2) {
            // Redirect non-employee users to admin dashboard
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}