<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index()
    {
        $cart = $this->getUserCart();
        $cartItems = $cart ? $cart->cartItems()->with('product')->get() : collect();
        
        return view('cart', compact('cartItems', 'cart'));
    }

    /**
     * Add item to cart.
     */
    public function add(Request $request)
    {
        try {
            // Debug logging
            \Log::info('Cart add request received', [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'request_data' => $request->all()
            ]);

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $product = Product::findOrFail($request->product_id);
            
            if ($product->stock < $request->quantity) {
                \Log::warning('Insufficient stock', [
                    'product_id' => $product->id,
                    'requested' => $request->quantity,
                    'available' => $product->stock
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }

            $cart = $this->getUserCart();
            if (!$cart) {
                $cart = Cart::create([
                    'user_id' => Auth::id()
                ]);
                \Log::info('New cart created', ['cart_id' => $cart->id]);
            }

            $cartItem = $cart->cartItems()->where('product_id', $request->product_id)->first();
            
            if ($cartItem) {
                \Log::info('Product already in cart', [
                    'cart_item_id' => $cartItem->id,
                    'product_id' => $request->product_id,
                    'existing_quantity' => $cartItem->quantity
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Produk sudah ada di keranjang',
                    'already_exists' => true
                ]);
            } else {
                $cartItem = CartItem::create([
                    'cart_id' => $cart->id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity
                ]);
                
                \Log::info('New cart item created', ['cart_item_id' => $cartItem->id]);
                
                $this->updateCartTotal($cart);

                \Log::info('Cart operation successful', ['cart_id' => $cart->id]);

                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart successfully'
                ]);
            }
            
        } catch (\Exception $e) {
            \Log::error('Cart add error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($id);
        
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $product = $cartItem->product;
        
        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available'
            ], 400);
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        // Update cart total
        $this->updateCartTotal($cartItem->cart);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully'
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $cart = $cartItem->cart;
        $cartItem->delete();

        // Update cart total
        $this->updateCartTotal($cart);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart'
        ]);
    }

    /**
     * Get or create user's cart.
     */
    private function getUserCart()
    {
        return Cart::where('user_id', Auth::id())->first();
    }

    /**
     * Clear all items from cart.
     */
    public function clear()
    {
        $cart = $this->getUserCart();
        
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ], 404);
        }

        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $cart->cartItems()->delete();

        
        if (!request()->expectsJson()) {
            return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan');
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }

   
    private function updateCartTotal(Cart $cart)
    {
        $total = $cart->cartItems()->with('product')->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        \Log::info('Cart total calculated', ['cart_id' => $cart->id, 'total' => $total]);
        
       
    }
}
