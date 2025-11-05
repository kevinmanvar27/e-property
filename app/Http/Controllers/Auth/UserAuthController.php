<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;

class UserAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('user.sign-up');
    }

    public function showLoginForm()
    {
        return view('user.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'contact'  => $request->contact,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user', 
            'status'   => 'active',
        ]);

        $user->sendEmailVerificationNotification();

        return redirect()->route('user-login')
                        ->with('success', 'Registration successful! Please check your email to verify your account.');
    }


    public function login(Request $request)
    {
        $throttleKey = Str::lower($request->email).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return back()->withErrors([
                'email' => 'Too many login attempts. Try again in '.RateLimiter::availableIn($throttleKey).' seconds.',
            ])->onlyInput('email');
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $user = Auth::user();

            // Check if user is active
            if ($user->status !== 'active') {
                Auth::logout();
                return redirect()->route('user-login')
                                ->withInput(['email' => $user->email])
                                ->with('error', 'Your account is not active. Please contact administrator. Or fill out this <a href="'.route('contact').'?subject=Account%20Active%20Request">contact us form</a>.');
            }

            if ($user->email_verified_at === null) {
                Auth::logout();
                return redirect()->route('user-login')
                                ->withInput(['email' => $user->email])
                                ->with('error', 'Please verify your email before logging in.');
            }

            $request->session()->regenerate();
            return redirect()->intended('/user-profile');
        }

        RateLimiter::hit($throttleKey, 300);

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user-login');
    }

    public function verify($id, $hash)
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            return redirect()->route('user-login')
                            ->with('error', 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('user-login')
                            ->with('success', 'Email already verified. You can log in.');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect()->route('user-login')
                        ->with('success', 'Your email has been verified! You can now log in.');
    }

}
