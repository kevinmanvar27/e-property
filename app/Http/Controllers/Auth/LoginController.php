<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }
    
    /**
     * Handle login request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Check if too many login attempts have been made
        $throttleKey = Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
        
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again in '.RateLimiter::availableIn($throttleKey).' seconds.',
            ])->onlyInput('email');
        }
        
        // Validate the request
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        // Attempt to authenticate the user
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Clear the rate limiter on successful login
            RateLimiter::clear($throttleKey);
            // Get the authenticated user
            $user = Auth::user();
            
            // Check if user is active
            if (!$user->isActive()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is not active.',
                ])->onlyInput('email');
            }
            
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
            
            // Record user login
            $user->recordLogin();
            
            // Redirect based on user role
            if ($user->isSuperAdmin()) {
                return redirect()->intended('/admin/settings');
            } elseif ($user->isAdmin()) {
                return redirect()->intended('/admin/settings');
            } else {
                return redirect()->intended('/');
            }
        }
        
        // Authentication failed
        // Increment the rate limiter on failed login
        RateLimiter::hit($throttleKey, 300); // Lock for 5 minutes
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
    /**
     * Log the user out
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/admin/login');
    }
}