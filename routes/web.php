<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function () {
    return redirect()->route('register')->with('success', 'Registration functionality coming soon!');
});

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});



