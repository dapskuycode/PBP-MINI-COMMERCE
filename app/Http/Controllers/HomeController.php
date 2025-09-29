<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get 10 random products for recommendations
        $recommendedProducts = Product::with('photos')->inRandomOrder()->limit(10)->get();
        
        return view('home', compact('recommendedProducts'));
    }
}
