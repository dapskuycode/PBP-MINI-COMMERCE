<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Double check admin access
        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman ini hanya untuk admin.');
        }
        // Get latest products with their categories and photos
        $products = Product::with(['category', 'photos'])
            ->latest()
            ->limit(100)
            ->get();

        // Get some basic stats
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $categories = Category::all();

        return view('admindashboard', compact('products', 'totalProducts', 'totalCategories', 'categories'));
    }
}
