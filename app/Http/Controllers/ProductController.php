<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ItemPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'discount' => 'required|numeric|min:0|max:100',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'discount' => $request->discount,
        ]);

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $file) {
                if ($file->isValid()) {
                    // Store the file in public/storage/photos
                    $path = $file->store('photos', 'public');
                    
                    if ($path !== false) {
                        // Create ItemPhoto record
                        $product->photos()->create([
                            'url' => $path,
                            'alt_text' => $product->name . ' - Photo ' . ($index + 1),
                            'is_primary' => $index === 0, // First photo is primary
                        ]);
                    }
                }
            }
        }

        if (!$request->expectsJson()) {
            return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan');
        }

        return response()->json([
            'success' => true,
            'data' => $product->load(['category', 'photos']),
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
        $relatedProducts = Product::with(['category', 'photos'])
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
        try {
            // Debug logging for update
            \Log::info('Product update called', [
                'product_id' => $product->id,
                'has_files' => $request->hasFile('photos'),
                'files_count' => $request->hasFile('photos') ? count($request->file('photos')) : 0,
                'request_method' => $request->method(),
                'all_input' => $request->all()
            ]);

            \Log::info('Starting validation for update...');
            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'discount' => 'required|numeric|min:0|max:100',
                'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            \Log::info('Validation passed for update');

            \Log::info('Updating product data...');
            $product->update($request->only(['category_id','name','description','price','stock','discount']));
            \Log::info('Product data updated successfully');

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            \Log::info('Processing photo uploads for update', ['count' => count($request->file('photos'))]);
            
            foreach ($request->file('photos') as $index => $file) {
                \Log::info('Processing file for update', [
                    'index' => $index,
                    'original_name' => $file->getClientOriginalName(),
                    'is_valid' => $file->isValid(),
                    'size' => $file->getSize(),
                    'mime_type' => $file->getMimeType()
                ]);
                
                if ($file->isValid()) {
                    // Store the file in public/storage/photos
                    $path = $file->store('photos', 'public');
                    \Log::info('File stored for update', ['path' => $path]);
                    
                    if ($path !== false) {
                        // Check if this should be primary photo
                        $existingPhotosCount = $product->photos()->count();
                        $isPrimary = ($existingPhotosCount === 0 && $index === 0);
                        
                        \Log::info('Creating photo with primary status', [
                            'existing_photos_count' => $existingPhotosCount,
                            'index' => $index,
                            'is_primary' => $isPrimary
                        ]);
                        
                        // Create ItemPhoto record
                        $photo = $product->photos()->create([
                            'url' => $path,
                            'alt_text' => $product->name . ' - Photo ' . ($index + 1),
                            'is_primary' => $isPrimary,
                        ]);
                        \Log::info('Photo record created for update', ['photo_id' => $photo->id]);
                    } else {
                        \Log::error('Failed to store file in update', ['original_name' => $file->getClientOriginalName()]);
                    }
                }
            }
        } else {
            \Log::info('No files found in update request');
        }

        \Log::info('Product update completed successfully');

        // Jika request dari Blade (bukan dari API)
        if (!$request->expectsJson()) {
            return redirect()->route('dashboard')->with('success', 'Produk berhasil diperbarui');
        }

        return response()->json([
            'success' => true,
            'data' => $product->load(['category', 'photos']),
            'message' => 'Product updated successfully'
        ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed in product update', [
                'errors' => $e->errors(),
                'message' => $e->getMessage()
            ]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error in product update', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if (!$request->expectsJson()) {
                return redirect()->back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
            }
            
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
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
