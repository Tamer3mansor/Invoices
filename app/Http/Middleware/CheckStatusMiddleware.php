<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStatusMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Allow users to access the login page without being checked
        if ($request->is('login')) {
            return $next($request);
        }

        // Check if the user is logged in
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Check if the user's status is 'مفعل'
        if (Auth::user()->Status !== 'مفعل') {
            // dd(Auth::user()->Status);
            Auth::logout(); // Log out the user
            $request->session()->invalidate(); // Invalidate session
            $request->session()->regenerateToken(); // Regenerate CSRF token

            return redirect('/inactive')->with('error', 'حسابك غير مفعل.');
        }

        return $next($request);
    }
}
