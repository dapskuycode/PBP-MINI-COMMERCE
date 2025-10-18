<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // Redirect based on user role if user is already authenticated
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->is_admin) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        return view('login');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Return JSON response for API requests
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'data' => [
                        'user' => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                            'role' => $user->role,
                            'is_admin' => $user->is_admin,
                        ]
                    ],
                    'redirect' => $user->is_admin ? route('dashboard') : route('home')
                ]);
            }

            // Redirect berdasarkan role user untuk web requests
            if ($user->is_admin) {
                return redirect()->intended(route('dashboard'));
            } else {
                return redirect()->intended(route('home'));
            }
        }

        // Return JSON error for API requests
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password yang Anda masukkan salah.',
                'errors' => [
                    'email' => ['Email atau password yang Anda masukkan salah.']
                ]
            ], 401);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->withInput($request->only('email'));
    }

    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        // Redirect if user is already authenticated
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->is_admin) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('home');
            }
        }

        return view('register');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role is user
        ]);

        // Login user after successful registration
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '!');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Display user profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Show the form for editing user profile.
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profile berhasil diupdate!');
    }

    /**
     * Show the form for changing password.
     */
    public function showChangePasswordForm()
    {
        return view('changepassword');
    }


    /**
     * Update user password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini tidak benar.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.profile')->with('success', 'Password berhasil diubah!');
    }

    /**
     * Delete user account.
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        // Check if password is correct
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password tidak benar.'
            ]);
        }

        // Logout user before deleting
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Delete user account
        $user->delete();

        return redirect()->route('home')->with('success', 'Akun berhasil dihapus.');
    }

    /**
     * Display a listing of users (for admin).
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user (for admin).
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user (for admin).
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user (for admin).
     */
    public function update(Request $request, $manageuser)
    {
        // Find user by ID
        $user = User::findOrFail($manageuser);
        
        // Check if this is a status-only update (from Blokir/Aktifkan buttons)
        if ($request->has('status') && !$request->has('name') && !$request->has('email')) {
            // Status-only update - minimal validation
            $request->validate([
                'status' => 'required|in:active,banned',
            ]);

            $user->update(['status' => $request->status]);
            
            $message = $request->status === 'banned' 
                ? "User {$user->name} berhasil diblokir!" 
                : "User {$user->name} berhasil diaktifkan!";
                
            return redirect()->route('admin.manageusers.showUsers')->with('success', $message);
        }
        
        // Full profile update (from Edit modal)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,customer,admin,moderator',
            'status' => 'nullable|in:active,banned',
        ]);

        $updateData = $request->only(['name', 'email', 'role']);
        
        // Add status if provided
        if ($request->has('status')) {
            $updateData['status'] = $request->status;
        }
        
        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|min:8',
            ]);
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('admin.manageusers.showUsers')->with('success', 'User berhasil diupdate!');
    }

    /**
     * Remove the specified user (for admin).
     */
    public function destroy($manageuser)
    {
        $user = User::findOrFail($manageuser);
        $user->delete();

        return redirect()->route('admin.manageusers.showUsers')->with('success', 'User berhasil dihapus!');
    }

    public function showUsers(Request $request)
    {
        $query = User::query();

        // Filter by search (name or email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Order by latest and paginate
        $users = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.adminuser', compact('users'));
    }
}
