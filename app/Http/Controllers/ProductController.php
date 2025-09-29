<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::with(['category', 'photos', 'reviews', 'orderItems'])
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        // If this is an API request, return JSON
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $products,
                'message' => 'Products retrieved successfully'
            ]);
        }

        // Otherwise return view for web
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories
            ],
            'message' => 'Categories for product creation retrieved successfully'
        ]);
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'required|integer|min:0|max:100',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount,
        ]);

        if (!$request->expectsJson()) {
            return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan');
        }

        return response()->json([
            'success' => true,
            'data' => $product->load('category'),
            'message' => 'Product created successfully'
        ], 201);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'variants', 'photos', 'reviews.user']);
        
        // Get related products from same category
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        // If this is an API request, return JSON
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $product,
                'message' => 'Product retrieved successfully'
            ]);
        }

        // Otherwise return view for web
        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('category');

        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
                'categories' => $categories
            ],
            'message' => 'Product and categories for editing retrieved successfully'
        ]);
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'required|integer|min:0|max:100',
        ]);

        $product->update($request->only(['category_id','name','description','price','stock','discount']));

        // Jika request dari Blade (bukan dari API)
        if (!$request->expectsJson()) {
            return redirect()->route('dashboard')->with('success', 'Produk berhasil diperbarui');
        }

        return response()->json([
            'success' => true,
            'data' => $product->load('category'),
            'message' => 'Product updated successfully'
        ]);
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        // Check if product has orders (optional - prevent deletion if has orders)
        // $hasOrders = $product->orderItems()->exists();
        // if ($hasOrders) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Cannot delete product that has been ordered'
        //     ], 422);
        // }

        $productName = $product->name;
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => "Product '{$productName}' deleted successfully"
        ]);
    }

    /**
     * Get products by category.
     */
    public function getByCategory($categoryId)
    {
        $products = Product::with('category')
            ->where('category_id', $categoryId)
            ->where('stock', '>', 0)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Products by category retrieved successfully'
        ]);
    }

    /**
     * Search products.
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        $categoryId = $request->get('category_id');

        $products = Product::with('category')
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($categoryId, function ($q) use ($categoryId) {
                return $q->where('category_id', $categoryId);
            })
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Products search completed successfully'
        ]);
    }

    /**
     * Update product stock.
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->update([
            'stock' => $request->stock,
        ]);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product stock updated successfully'
        ]);
    }
}
