<?php

namespace App\Http\Controllers;

use App\Models\ItemPhoto;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ItemPhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ItemPhoto::with('product');

        // Filter by product if specified
        if ($request->has('product_id') && $request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $photos = $query->latest()->paginate(12);
        $products = Product::orderBy('name')->get();

        return view('admin.photos.index', compact('photos', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.photos.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'photos' => 'required|array|min:1|max:5',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'is_primary' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = Product::findOrFail($request->product_id);
        $savedPhotos = [];

        // If this photo is set as primary, unset other primary photos for this product
        if ($request->is_primary) {
            ItemPhoto::where('product_id', $product->id)->update(['is_primary' => false]);
        }

        foreach ($request->file('photos') as $index => $photo) {
            try {
                // Generate unique filename
                $filename = Str::random(20) . '.' . $photo->getClientOriginalExtension();
                
                // Store in storage/app/public/products directory
                $path = $photo->storeAs('products', $filename, 'public');

                // Create database record
                $itemPhoto = ItemPhoto::create([
                    'product_id' => $product->id,
                    'url' => $path,
                    'alt_text' => $request->alt_text ?? $product->name . ' - Image ' . ($index + 1),
                    'is_primary' => $request->is_primary && $index === 0 // Only first photo can be primary
                ]);

                $savedPhotos[] = $itemPhoto;

            } catch (\Exception $e) {
                // If error occurs, delete previously saved photos
                foreach ($savedPhotos as $savedPhoto) {
                    Storage::disk('public')->delete($savedPhoto->url);
                    $savedPhoto->delete();
                }
                
                return back()->with('error', 'Error uploading photo: ' . $e->getMessage())->withInput();
            }
        }

        return redirect()->route('admin.photos.index', ['product_id' => $product->id])
                        ->with('success', count($savedPhotos) . ' foto berhasil ditambahkan untuk produk ' . $product->name);
    }

    /**
     * Display the specified resource.
     */
    public function show(ItemPhoto $itemPhoto)
    {
        $itemPhoto->load('product');
        return view('admin.photos.show', compact('itemPhoto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ItemPhoto $itemPhoto)
    {
        $products = Product::orderBy('name')->get();
        return view('admin.photos.edit', compact('itemPhoto', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ItemPhoto $itemPhoto)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'is_primary' => 'boolean'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // If this photo is set as primary, unset other primary photos for this product
            if ($request->is_primary) {
                ItemPhoto::where('product_id', $request->product_id)
                        ->where('id', '!=', $itemPhoto->id)
                        ->update(['is_primary' => false]);
            }

            // Handle photo replacement
            if ($request->hasFile('photo')) {
                // Delete old photo
                Storage::disk('public')->delete($itemPhoto->url);
                
                // Upload new photo
                $photo = $request->file('photo');
                $filename = Str::random(20) . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('products', $filename, 'public');
                
                $itemPhoto->url = $path;
            }

            // Update other fields
            $itemPhoto->product_id = $request->product_id;
            $itemPhoto->alt_text = $request->alt_text;
            $itemPhoto->is_primary = $request->boolean('is_primary');
            $itemPhoto->save();

            return redirect()->route('admin.photos.index', ['product_id' => $itemPhoto->product_id])
                            ->with('success', 'Foto berhasil diperbarui');

        } catch (\Exception $e) {
            return back()->with('error', 'Error updating photo: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($photoId)
    {
        // Find the photo manually 
        $photo = ItemPhoto::findOrFail($photoId);
        
        // Debug logging
        \Log::info('Photo delete called', [
            'photo_id' => $photo->id,
            'product_id' => $photo->product_id,
            'url' => $photo->url,
            'expects_json' => request()->expectsJson()
        ]);

        try {
            // Delete file from storage
            Storage::disk('public')->delete($photo->url);
            \Log::info('Photo file deleted from storage');
            
            // Delete database record
            $productId = $photo->product_id;
            $photo->delete();
            \Log::info('Photo record deleted from database');

            // Check if request expects JSON (AJAX request)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto berhasil dihapus'
                ]);
            }

            return redirect()->route('admin.photos.index', ['product_id' => $productId])
                            ->with('success', 'Foto berhasil dihapus');

        } catch (\Exception $e) {
            // Check if request expects JSON (AJAX request)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting photo: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Error deleting photo: ' . $e->getMessage());
        }
    }

    /**
     * Set photo as primary for product
     */
    public function setPrimary(ItemPhoto $itemPhoto)
    {
        try {
            // Unset other primary photos for this product
            ItemPhoto::where('product_id', $itemPhoto->product_id)->update(['is_primary' => false]);
            
            // Set this photo as primary
            $itemPhoto->update(['is_primary' => true]);

            return back()->with('success', 'Foto berhasil dijadikan foto utama');

        } catch (\Exception $e) {
            return back()->with('error', 'Error setting primary photo: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete photos
     */
    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo_ids' => 'required|array|min:1',
            'photo_ids.*' => 'exists:item_photos,id'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            $photos = ItemPhoto::whereIn('id', $request->photo_ids)->get();
            $productId = $photos->first()->product_id ?? null;

            foreach ($photos as $photo) {
                Storage::disk('public')->delete($photo->url);
                $photo->delete();
            }

            return redirect()->route('admin.photos.index', ['product_id' => $productId])
                            ->with('success', count($photos) . ' foto berhasil dihapus');

        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting photos: ' . $e->getMessage());
        }
    }
}
