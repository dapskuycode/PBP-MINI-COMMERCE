<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get latest 8 products with their categories
        $products = Product::with('category')
            ->latest()
            ->limit(8)
            ->get();

        // Get some basic stats
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        return view('admindashboard', compact('products', 'totalProducts', 'totalCategories'));
    }
}
