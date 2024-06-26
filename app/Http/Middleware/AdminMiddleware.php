<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // admin role == 1
        // user role == 0
        // manager role == 2

        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/login')->with('message', 'Access denied because you are not an Admin');
        }
        return $next($request);
    }
}