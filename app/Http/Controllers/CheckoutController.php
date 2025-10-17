<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong. Silakan tambahkan produk sebelum checkout.');
        }

        $total = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        $cartItem = $cart->cartItems;
        return view('checkout', compact('cart', 'total', 'cartItem'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong. Silakan tambahkan produk sebelum checkout.');
        }

        $total = $cart->cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        // Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'pending',
            'address' => $request->address,
        ]);

        // Create Order Items
        foreach ($cart->cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);
        }

        foreach ($cart->cartItems as $cartItem) {
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $product->stock -= $cartItem->quantity;
                $product->save();
            }
        }

        // Clear Cart
        $cart->cartItems()->delete();

        return redirect()->route('orders.history')->with('success', 'Pesanan berhasil dibuat! Terima kasih telah berbelanja.');
    }
}
