<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (! auth()->check()) {
            // For AJAX requests, return JSON response instead of redirect
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Authentication required. Please log in.'], 401);
            }

            return redirect('/admin/login');
        }

        $user = auth()->user();

        // Check if user is active
        if (! $user->isActive()) {
            auth()->logout();
            // For AJAX requests, return JSON response instead of redirect
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Your account is not active.'], 401);
            }

            return redirect('/admin/login')->with('error', 'Your account is not active.');
        }

        // If no specific roles are required, just check authentication
        if (empty($roles)) {
            return $next($request);
        }

        // Check if user has required role
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // If user doesn't have required role, redirect to home with error
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'You do not have permission to access this page.'], 403);
        }

        return redirect('/')->with('error', 'You do not have permission to access this page.');
    }
}
