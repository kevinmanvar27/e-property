<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $module, $action): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // For AJAX requests, return JSON response instead of redirect
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => 'Authentication required. Please log in.'], 401);
            }
            return redirect('/admin/login');
        }
        
        $user = auth()->user();
        
        // Super admins have all permissions
        if ($user->isSuperAdmin()) {
            return $next($request);
        }
        
        // Check if user has the required permission
        if ($user->hasPermission($module, $action)) {
            return $next($request);
        }
        
        // If user doesn't have required permission, redirect to home with error
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['message' => 'You do not have permission to access this page.'], 403);
        }
        
        return redirect('/')->with('error', 'You do not have permission to access this page.');
    }
}