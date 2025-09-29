<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $categoryId = $request->get('category_id');
        $sortBy = $request->get('sort', 'name');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

        // Build the query
        $productsQuery = Product::with(['category', 'photos', 'reviews'])
            ->where('stock', '>', 0);

        // Apply search query
        if ($query) {
            $productsQuery->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            });
        }

        // Apply category filter
        if ($categoryId) {
            $productsQuery->where('category_id', $categoryId);
        }

        // Apply price range filter
        if ($minPrice) {
            $productsQuery->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $productsQuery->where('price', '<=', $maxPrice);
        }

        // Apply sorting
        switch ($sortBy) {
            case 'price_low':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_high':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'newest':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $productsQuery->withCount('orderItems')->orderBy('order_items_count', 'desc');
                break;
            default:
                $productsQuery->orderBy('name', 'asc');
        }

        $products = $productsQuery->paginate(12);
        $categories = Category::withCount('products')->get();

        return view('search.index', compact('products', 'categories', 'query', 'categoryId', 'sortBy', 'minPrice', 'maxPrice'));
    }
}
