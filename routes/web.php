<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\CheckoutController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/register', [registerController::class, 'showRegistrationForm'])->name('register')->middleware('guest');
Route::post('/register', [registerController::class, 'register'])->middleware('guest');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');

Route::get('/profile', function () {
    return view('profile');
})->name('profile')->middleware('auth');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Product Routes (Accessible to all users)
Route::get('/products', [ProductDetailController::class, 'catalog'])->name('products.catalog');
Route::get('/products/{product}', [ProductDetailController::class, 'show'])->name('products.detail');

// Cart Routes (Protected by auth and buyer middleware)
Route::middleware(['auth', 'buyer'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
});

// Checkout Routes (Protected by auth and buyer middleware)
Route::middleware(['auth', 'buyer'])->group(function () {
    Route::get('/checkout/buy-now/{product}', [CheckoutController::class, 'directBuy'])->name('checkout.direct');
    Route::post('/checkout/from-cart', [CheckoutController::class, 'fromCart'])->name('checkout.from-cart');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Admin Routes (Protected by admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::patch('/users/{user}/change-role', [UserController::class, 'changeRole'])->name('users.change-role');
});
