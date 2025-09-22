<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // If user is already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah login.');
        }

        return view('login');
    }

    /**
     * Handle a login request for the application.
     */
    public function login(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'string',
                'email',
                'max:255'
            ],
            'password' => [
                'required',
                'string'
            ]
        ], [
            // Custom error messages
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.'
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Simple session-based rate limiting (alternative to database cache)
        $sessionKey = 'login_attempts_' . $request->ip();
        $attempts = session($sessionKey, 0);
        $lastAttemptTime = session($sessionKey . '_time', 0);

        // Reset attempts if more than 15 minutes have passed
        if (time() - $lastAttemptTime > 900) { // 15 minutes
            $attempts = 0;
        }

        if ($attempts >= 5) {
            $remainingTime = 900 - (time() - $lastAttemptTime); // 15 minutes lockout
            if ($remainingTime > 0) {
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->with('error', 'Terlalu banyak percobaan login. Silakan coba lagi dalam ' . ceil($remainingTime/60) . ' menit.');
            } else {
                // Reset attempts after lockout period
                session()->forget([$sessionKey, $sessionKey . '_time']);
                $attempts = 0;
            }
        }

        // Attempt to log the user in
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Clear login attempts on successful login
            session()->forget([$sessionKey, $sessionKey . '_time']);

            // Regenerate session to prevent session fixation
            $request->session()->regenerate();

            // Get the intended URL or default to dashboard
            $intended = redirect()->intended(route('dashboard'));

            return $intended->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        // If authentication fails, increment attempts counter
        session([$sessionKey => $attempts + 1, $sessionKey . '_time' => time()]);

        // Authentication failed
        return redirect()->back()
            ->withInput($request->only('email'))
            ->with('error', 'Email atau password yang Anda masukkan salah.');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()->name;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard')
            ->with('success', 'Sampai jumpa lagi, ' . $userName . '! Anda telah berhasil logout.');
    }

    /**
     * Handle failed login attempts (optional method for additional security).
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }
}
