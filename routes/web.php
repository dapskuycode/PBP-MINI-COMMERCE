<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\User;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Public routes (Admin restrictions applied where needed)
|--------------------------------------------------------------------------
*/

// Routes that admin should not access - apply no-admin middleware
Route::middleware('no-admin')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // Product browsing
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    
    // Search
    Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

    // Category browsing
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
    
    // Checkout
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'processCheckout'])->name('checkout.process');
    
    //Riwayat Pesanan
    Route::get('/riwayat-pesanan', [OrderController::class, 'index'])->name('orders.history');
    
    //tentang kami
    Route::view('/about', 'about')->name('about');
});


Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

//Auth (Login/Register) - both can access
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');




/*
|--------------------------------------------------------------------------
| Forgot / Reset Password (tanpa paket Breeze/Jetstream)
| - Form lupa sandi pakai view `resources/views/password.blade.php`
| - Jika nanti kamu memindahkan ke `resources/views/auth/forgot-password.blade.php`,
|   ganti view('password') menjadi view('auth.forgot-password').
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Form Lupa Password
    Route::view('/forgot-password', 'password')->name('password.request');

    // Kirim email tautan reset
    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    // Halaman form Reset Password (dibuka dari tautan email)
    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request('email')
        ]);
    })->name('password.reset');

    // Proses submit password baru
    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Protected routes (butuh login)
|--------------------------------------------------------------------------
*/


//syarat dan ketentuan - available to all
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy'); 

Route::middleware('auth')->group(function () {
    
    // User account management - both admin and users can access their profiles
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/profile/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.change-password');
    Route::put('/profile/change-password', [UserController::class, 'changepassword'])->name('user.change-password.update');
    Route::delete('/profile/delete-account', [UserController::class, 'deleteAccount'])->name('user.delete-account');
    
    // Routes restricted to regular users only (not admin)
    Route::middleware('no-admin')->group(function () {
        // Cart functionality - only for customers
        Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
        Route::patch('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
        
        //Orders - for customers only
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        
        // Favorites - for customers only
        Route::view('/favorites', 'favorites')->name('favorites');
    });


    // Admin routes
    Route::middleware('admin')->group(function () {
        // User management
        // Dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('admin/users', UserController::class, [
            'as' => 'admin',
            'except' => ['create', 'store'] // Registration handled by public routes
        ]);

        // Product management
        Route::resource('admin/products', ProductController::class, [
            'as' => 'admin'
        ]);

        //Category management
        Route::get('/admin/managecategories', [App\Http\Controllers\CategoryController::class, 'index'])->name('admin.managecategories.index');
        Route::resource('admin/managecategories', App\Http\Controllers\CategoryController::class, [
            'as' => 'admin'
        ]);

        //order management
        Route::get('/admin/manageorders', [App\Http\Controllers\OrderController::class, 'index'])->name('admin.manageorders.index');
        Route::patch('/admin/manageorders/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('admin.manageorders.updateStatus');
        Route::patch('/admin/manageorders/{order}/ship', [App\Http\Controllers\OrderController::class, 'shipOrder'])->name('admin.manageorders.shipOrder');
        Route::get('/admin/manageorders/{order}/detail', [App\Http\Controllers\OrderController::class, 'show'])->name('admin.manageorders.detail');
        Route::resource('admin/manageorders', App\Http\Controllers\OrderController::class, [
            'as' => 'admin'
        ]);

        //user management
        Route::get('/admin/manageusers/all', [App\Http\Controllers\UserController::class, 'showUsers'])->name('admin.manageusers.showUsers');
        Route::resource('admin/manageusers', App\Http\Controllers\UserController::class, [
            'as' => 'admin'
        ]);

        // Additional product routes
        Route::get('admin/products/category/{categoryId}', [ProductController::class, 'getByCategory'])
            ->name('admin.products.by-category');
        Route::get('admin/products/search', [ProductController::class, 'search'])
            ->name('admin.products.search');
        Route::patch('admin/products/{product}', [ProductController::class, 'updateStock'])
            ->name('admin.products.update-stock');

        // Photo management  
        Route::resource('admin/photos', App\Http\Controllers\ItemPhotoController::class, [
            'as' => 'admin'
        ]);
        Route::post('admin/photos/{itemPhoto}/set-primary', [App\Http\Controllers\ItemPhotoController::class, 'setPrimary'])
            ->name('admin.photos.set-primary');
        Route::post('admin/photos/bulk-delete', [App\Http\Controllers\ItemPhotoController::class, 'bulkDelete'])
            ->name('admin.photos.bulk-delete');
    });
    
    // Test route for debugging - available to all authenticated users
    Route::get('/test-auth', function () {
        return view('test-auth');
    })->name('test.auth');

    // This is redundant - orders route already defined above in no-admin middleware group

});

// Halaman Produk Favorit 
Route::middleware('auth')->group(function () {
    Route::view('/favorites', 'favorites')->name('favorites');
});

