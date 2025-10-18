<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Halaman checkout - menampilkan ringkasan pesanan
     */
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong. Silakan tambahkan produk sebelum checkout.');
        }

        $total = $cart->cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $cartItems = $cart->cartItems;

        return view('checkout', compact('cart', 'cartItems', 'total'));
    }

    /**
     * Proses penyimpanan pesanan ke tabel orders
     */
    public function processCheckout(Request $request)
    {
        try {
            // Log data yang diterima untuk debugging
            \Log::info('Checkout Data Received:', $request->all());

            $request->validate([
                'nama_pemesan'      => 'required|string|max:255',
                'kota'              => 'required|string|max:255',
                'kode_pos'          => 'required|string|max:10',
                'nomor_hp'          => 'required|string|max:20',
                'jenis_pengiriman'  => 'required|string|max:255',
                'metode_pembayaran' => 'required|string|max:255',
                'address'           => 'required|string',
                'total'             => 'required|numeric',
            ]);

            $user = Auth::user();
            $cart = Cart::where('user_id', $user->id)->first();

            if (!$cart || $cart->cartItems->isEmpty()) {
                return redirect()->route('cart.index')
                    ->with('error', 'Keranjang Anda kosong. Silakan tambahkan produk sebelum checkout.');
            }

            // ✅ Buat Order baru
            $order = Order::create([
                'user_id'           => $user->id,
                'nama_pemesan'      => $request->nama_pemesan,
                'kota'              => $request->kota,
                'kode_pos'          => $request->kode_pos,
                'nomor_hp'          => $request->nomor_hp,
                'jenis_pengiriman'  => $request->jenis_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
                'address'           => $request->address,
                'total'             => $request->total,
                // Demo flow: set to processing directly since there's no real payment flow
                'status'            => 'processing',
            ]);

            \Log::info('Order Created:', ['order_id' => $order->id]);

            // ✅ Simpan Order Item (produk per item)
            foreach ($cart->cartItems as $cartItem) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity'   => $cartItem->quantity,
                    'price'      => $cartItem->product->price,
                ]);
            }

            // ✅ Update stok produk
            foreach ($cart->cartItems as $cartItem) {
                $product = Product::find($cartItem->product_id);
                if ($product) {
                    $product->stock -= $cartItem->quantity;
                    $product->save();
                }
            }

            // ✅ Kosongkan keranjang
            $cart->cartItems()->delete();

            \Log::info('Checkout completed successfully for order:', ['order_id' => $order->id]);

            return redirect()->route('orders.history')->with('success', 'Pesanan berhasil dibuat! Terima kasih telah berbelanja.');
        } catch (\Exception $e) {
            \Log::error('Checkout Error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
