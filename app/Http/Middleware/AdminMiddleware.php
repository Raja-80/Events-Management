<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('AdminMiddleware is working');

        // Check if the user is authenticated and has an 'admin' role
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect('/')->with('error', 'Access Denied. You do not have admin privileges.');
        }

        // Optionally handle the case where the user is not authenticated
        if (!Auth::check()) {
            return redirect('login')->with('error', 'You must be logged in to access this page.');
        }

        return $next($request);
    }
}
