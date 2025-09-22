<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class registerController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        // If user is already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard')->with('info', 'Anda sudah login.');
        }

        return view('register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/' // Only letters and spaces
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/' // At least one lowercase, uppercase, number, and special character
            ],
            'terms' => [
                'required',
                'accepted'
            ]
        ], [
            // Custom error messages
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter khusus.',
            'terms.required' => 'Anda harus menyetujui syarat dan ketentuan.',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan.'
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'buyer' // Default role for new registrations
            ]);

            // Log the user in automatically after registration
            Auth::login($user);

            // Redirect to dashboard with success message
            return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Mini Commerce.');

        } catch (\Exception $e) {
            // If there's an error during user creation
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mendaftarkan akun. Silakan coba lagi.')
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }
}
