<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FavoriteItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite status for a product (AJAX).
     */
    public function toggle(Request $request, $productId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to favorite products'
            ], 401);
        }

        $product = Product::findOrFail($productId);
        
        $existingFavorite = FavoriteItem::where('user_id', $user->id)
                                        ->where('product_id', $productId)
                                        ->first();

        if ($existingFavorite) {
            // Remove from favorites
            $existingFavorite->delete();
            $isFavorited = false;
            $message = 'Product removed from favorites';
        } else {
            // Add to favorites
            FavoriteItem::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
            $isFavorited = true;
            $message = 'Product added to favorites';
        }

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'message' => $message
        ]);
    }

    /**
     * Show user's favorite products.
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $favorites = FavoriteItem::with(['product.photos'])
                                ->where('user_id', $user->id)
                                ->latest()
                                ->paginate(12);

        return view('favorites', compact('favorites'));
    }

    /**
     * Remove product from favorites (via DELETE form).
     */
    public function destroy($productId)
    {
        $user = Auth::user();

        FavoriteItem::where('user_id', $user->id)
                    ->where('product_id', $productId)
                    ->delete();

        // Balikin ke halaman favorites lagi biar bisa ngecek kosong/tidak
        return redirect()->route('favorites.index');
    }

    /**
     * Check if a product is favorited by current user.
     */
    public function checkStatus($productId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['is_favorited' => false]);
        }

        $isFavorited = FavoriteItem::where('user_id', $user->id)
                                  ->where('product_id', $productId)
                                  ->exists();

        return response()->json(['is_favorited' => $isFavorited]);
    }

    /**
     * Remove a product from favorites.
     */
    public function remove($productId)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in'
            ], 401);
        }

        $favoriteItem = FavoriteItem::where('user_id', $user->id)
                                   ->where('product_id', $productId)
                                   ->first();

        if ($favoriteItem) {
            $favoriteItem->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product removed from favorites'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in favorites'
        ], 404);
    }
}
