<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if (Auth::check()) {
    //         // If user is authenticated, redirect based on role
    //         $user = Auth::user();

    //         if ($user->isSuperAdmin() || $user->isAdmin()) {
    //             return redirect('/admin/settings');
    //         } else {
    //             return redirect('/');
    //         }
    //     }

    //     return $next($request);
    // }


    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // If user is not verified, log them out and redirect to user login
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('user.login')
                    ->with('error', 'Please verify your email first.');
            }

            // Authenticated and verified users
            if ($user->isSuperAdmin() || $user->isAdmin()) {
                return redirect('/admin/settings');
            } else {
                return redirect('/user/dashboard'); // <-- user dashboard
            }
        }

        return $next($request);
    }
}
