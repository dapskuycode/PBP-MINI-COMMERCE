<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Authentication routes
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User account management
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/profile/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.change-password');
    Route::put('/profile/change-password', [UserController::class, 'changePassword'])->name('user.change-password.update');
    Route::delete('/profile/delete-account', [UserController::class, 'deleteAccount'])->name('user.delete-account');
    
    // Admin routes
    Route::middleware('admin')->group(function () {
        // User management
        Route::resource('admin/users', UserController::class, [
            'as' => 'admin',
            'except' => ['create', 'store'] // Registration handled by public routes
        ]);
        
        // Product management
        Route::resource('admin/products', ProductController::class, [
            'as' => 'admin'
        ]);
        
        // Additional product routes
        Route::get('admin/products/category/{categoryId}', [ProductController::class, 'getByCategory'])
            ->name('admin.products.by-category');
        Route::get('admin/products/search', [ProductController::class, 'search'])
            ->name('admin.products.search');
        Route::patch('admin/products/{product}/stock', [ProductController::class, 'updateStock'])
            ->name('admin.products.update-stock');
    });
});



