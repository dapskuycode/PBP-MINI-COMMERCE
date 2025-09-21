<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function () {
    // Handle registration logic here
    // This will be implemented later with proper controller
    return redirect()->route('register')->with('success', 'Registration functionality coming soon!');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    // Handle login logic here
    // This will be implemented later with proper controller
    return redirect('/login')->with('error', 'Login functionality coming soon!');
});
