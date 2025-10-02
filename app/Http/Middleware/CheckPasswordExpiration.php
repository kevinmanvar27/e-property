<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPasswordExpiration
{
    /**
     * Handle an incoming request and check if password has expired.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip password expiration check for guest users and specific routes
        if (! auth()->check() ||
            $request->is('logout') ||
            $request->is('profile/password*') ||
            $request->is('refresh-csrf')) {
            return $next($request);
        }

        $user = auth()->user();

        // Check if password has expired (older than 90 days)
        if (! $user->passwordChangedWithin(90)) {
            // For AJAX requests, return JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Your password has expired. Please change it to continue.',
                    'redirect' => route('profile.show') . '#password-change',
                ], 403);
            }

            // For regular requests, redirect to profile page
            return redirect()->route('profile.show', ['#password-change'])
                ->with('error', 'Your password has expired. Please change it to continue.');
        }

        return $next($request);
    }
}
