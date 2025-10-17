<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get 10 random products for recommendations
        $recommendedProducts = Product::with('photos')->inRandomOrder()->limit(10)->get();
        
        // Get top-selling products from v_produk_terlaris view
        $topSellingProducts = collect(DB::select('
            SELECT 
                p.id,
                p.name,
                p.price,
                p.description,
                vp.total_terjual,
                (SELECT url FROM item_photos WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as image_url
            FROM v_produk_terlaris vp
            JOIN products p ON p.id = vp.product_id
            ORDER BY vp.total_terjual DESC
            LIMIT 10
        '))->map(function ($item) {
            // Convert stdClass to object with required properties for product card
            $product = new \stdClass();
            $product->id = $item->id;
            $product->name = $item->name;
            $product->price = $item->price;
            $product->description = $item->description;
            $product->total_sold = $item->total_terjual;
            $product->image_url = $item->image_url;
            
            // Calculate rating (mock data based on sales)
            $product->average_rating = min(5.0, 3.5 + ($item->total_terjual * 0.1));
            
            return $product;
        });
        
        return view('home', compact('recommendedProducts', 'topSellingProducts'));
    }
}
