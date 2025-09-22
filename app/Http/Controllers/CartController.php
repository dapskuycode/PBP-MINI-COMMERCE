<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the cart contents.
     */
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart->cartItems()->with(['product.category'])->get();

        return view('cart.index', compact('cart', 'cartItems'));
    }

    /**
     * Add product to cart.
     */
    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        if ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi.'
            ]);
        }

        $cart = $this->getOrCreateCart();

        // Check if product already in cart
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();

        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $quantity;
            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total quantity melebihi stok yang tersedia.'
                ]);
            }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'cartCount' => $cart->cartItems()->sum('quantity')
        ]);
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        // Check if cart item belongs to current user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $quantity = $request->input('quantity');

        if ($cartItem->product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi.'
            ]);
        }

        $cartItem->update(['quantity' => $quantity]);

        $cart = $cartItem->cart->load('cartItems');

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil diperbarui.',
            'itemTotal' => $cartItem->quantity * $cartItem->product->price,
            'cartTotal' => $cart->total,
            'cartTotalQuantity' => $cart->total_quantity
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function remove(CartItem $cartItem)
    {
        // Check if cart item belongs to current user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        $cart = $cartItem->cart;
        $cartItem->delete();

        $cart->load('cartItems');
        $cartEmpty = $cart->cartItems->count() === 0;

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari keranjang.',
            'cartEmpty' => $cartEmpty,
            'cartTotal' => $cart->total,
            'cartTotalQuantity' => $cart->total_quantity
        ]);
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        $cart = $this->getOrCreateCart();
        $cart->cartItems()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan.'
        ]);
    }

    /**
     * Get cart item count for navbar.
     */
    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $cart = $this->getOrCreateCart();
        $count = $cart->cartItems()->sum('quantity');

        return response()->json(['count' => $count]);
    }

    /**
     * Get or create cart for current user.
     */
    private function getOrCreateCart()
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()]);
    }
}
