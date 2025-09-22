<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'buyer']);
    }

    /**
     * Show checkout page for direct buy
     */
    public function directBuy(Product $product, Request $request)
    {
        $quantity = $request->input('quantity', 1);

        // Validate stock
        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        $items = collect([
            (object) [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $product->price * $quantity
            ]
        ]);

        $total = $items->sum('subtotal');

        return view('checkout.index', compact('items', 'total', 'product'));
    }

    /**
     * Show checkout page for selected cart items
     */
    public function fromCart(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu produk untuk checkout.');
        }

        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $cartItems = $cart->cartItems()
            ->whereIn('id', $selectedItems)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Item yang dipilih tidak valid.');
        }

        // Check stock for all items
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->route('cart.index')
                    ->with('error', "Stok {$item->product->name} tidak mencukupi.");
            }
        }

        $items = $cartItems->map(function ($item) {
            return (object) [
                'product' => $item->product,
                'quantity' => $item->quantity,
                'subtotal' => $item->product->price * $item->quantity
            ];
        });

        $total = $items->sum('subtotal');

        return view('checkout.index', compact('items', 'total', 'cartItems'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|in:bank_transfer,e_wallet,cod'
        ]);

        // This is a simplified checkout process
        // In real application, you would:
        // 1. Create order record
        // 2. Process payment
        // 3. Update stock
        // 4. Send confirmation email
        // 5. Clear cart if checkout from cart

        return redirect()->route('dashboard')->with('success', 'Pesanan berhasil dibuat! Kami akan menghubungi Anda segera.');
    }
}
