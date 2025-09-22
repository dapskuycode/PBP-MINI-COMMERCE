<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        // Get featured products (latest 8 products)
        $featuredProducts = Product::with('category')
            ->latest()
            ->take(8)
            ->get();

        // Get categories with product count
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        // Get statistics
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        return view('dashboard', compact(
            'featuredProducts',
            'categories',
            'totalProducts',
            'totalCategories'
        ));
    }
}
