<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is an admin
        if (Auth::check() && Auth::user()->isAdmin()) {
            return $next($request);
        }

        // Redirect to home page if not an admin
        return redirect('/home')->with('error', 'Unauthorized access.');
    }
}
