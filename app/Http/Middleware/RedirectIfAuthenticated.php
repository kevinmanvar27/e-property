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
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // If user is authenticated, redirect based on role
            $user = Auth::user();
            
            if ($user->isSuperAdmin() || $user->isAdmin()) {
                return redirect('/admin/settings');
            } else {
                return redirect('/');
            }
        }

        return $next($request);
    }
}