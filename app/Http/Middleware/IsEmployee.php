<?php
  
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsEmployee
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role_id != 2) {
                return redirect()->route('admin.dashboard');  // Redirect to admin dashboard if not an employee
            }
        } else {
            return redirect()->route('login');  // Redirect to login page if not authenticated
        }

        return $next($request);
    }
}