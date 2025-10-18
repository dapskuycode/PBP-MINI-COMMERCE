<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     * Shows different views based on user role.
     */
    public function index()
    {
        try {
            $user = auth()->user();
            
            if ($user->is_admin) {
                $orders = Order::with(['user', 'orderItems.product'])
                    ->latest()
                    ->get();
                
                // Debug: Log what we get from database
                Log::info('Orders from database:', [
                    'count' => $orders->count(),
                    'orders' => $orders->toArray()
                ]);
                
                // Transform real orders from database
                $transformedOrders = $orders->map(function ($order) {
                    try {
                        return [
                            'code' => 'ORD' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
                            'status' => $this->mapStatusToFrontend($order->status),
                            'date' => $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
                            'total' => (float) $order->total,
                            'items' => $order->orderItems->map(function ($item) {
                                return [
                                    'name' => $item->product ? $item->product->name : 'Unknown Product',
                                    'qty' => (int) $item->quantity
                                ];
                            })->toArray(),
                            'customer' => $order->nama_pemesan ?: ($order->user ? $order->user->name : 'Unknown'),
                            'phone' => $order->nomor_hp ?: 'N/A',
                            'address' => $order->address ?: 'No address',
                            'payment_method' => $order->metode_pembayaran ?: 'Not specified',
                            'shipping' => $order->jenis_pengiriman ?: 'Standard',
                            'user_name' => $order->user ? $order->user->name : 'Guest',
                            'user_email' => $order->user ? $order->user->email : 'N/A',
                            'nomor_resi' => $order->nomor_resi
                        ];
                    } catch (\Exception $e) {
                        Log::error('Error transforming order: ' . $e->getMessage(), [
                            'order_id' => $order->id ?? 'unknown'
                        ]);
                        
                        // Return basic data if transformation fails
                        return [
                            'code' => 'ORD' . str_pad($order->id ?? 0, 4, '0', STR_PAD_LEFT),
                            'status' => 'processing',
                            'date' => now()->format('Y-m-d H:i:s'),
                            'total' => 0,
                            'items' => [],
                            'customer' => 'Unknown',
                            'phone' => 'N/A',
                            'address' => 'No address',
                            'payment_method' => 'Not specified',
                            'shipping' => 'Standard',
                            'user_name' => 'Unknown',
                            'user_email' => 'N/A'
                        ];
                    }
                });
                
                Log::info('Real orders transformed successfully:', [
                    'count' => $transformedOrders->count(),
                    'sample' => $transformedOrders->take(3)->toArray()
                ]);
                
                
                $totProcessing = $orders->where('status', 'processing')->count();
                $totShipped = $orders->where('status', 'shipped')->count();
                $totCompleted = $orders->where('status', 'completed')->count();
                $totCancelled = $orders->where('status', 'cancelled')->count();
                $orderProcessing = $orders->where('status', 'processing');
                $orderShipped = $orders->where('status', 'shipped');
                $orderCompleted = $orders->where('status', 'completed');
                $orderCancelled = $orders->where('status', 'cancelled');
                    
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'data' => $transformedOrders,
                        'message' => 'Orders retrieved successfully for admin'
                    ]);
                }

                return view('admin.adminorders', compact('orders', 'transformedOrders', 'totProcessing', 'totCompleted', 'totCancelled', 'totShipped', 'orderProcessing', 'orderShipped', 'orderCompleted', 'orderCancelled'));
            } else {
                $orders = Order::with(['orderItems.product'])
                    ->where('user_id', $user->id)
                    ->latest()
                    ->get();
                $totProcessing = $orders->where('status', 'processing')->count();
                $totShipped = $orders->where('status', 'shipped')->count();
                $totCompleted = $orders->where('status', 'completed')->count();
                $totCancelled = $orders->where('status', 'cancelled')->count();
                $orderProcessing = $orders->where('status', 'processing');
                $orderShipped = $orders->where('status', 'shipped');
                $orderCompleted = $orders->where('status', 'completed');
                $orderCancelled = $orders->where('status', 'cancelled');
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'data' => $orders,
                        'message' => 'Your orders retrieved successfully'
                    ]);
                }
                
                return view('orders', compact('orders', 'totProcessing', 'totCompleted', 'totCancelled', 'totShipped', 'orderProcessing', 'orderShipped', 'orderCompleted', 'orderCancelled'));
            }
        } catch (\Exception $e) {
            Log::error('Error in OrderController@index: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return error response or redirect
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error retrieving orders: ' . $e->getMessage()
                ], 500);
            }
            
            // For admin, return view with empty data
            if (auth()->user()->is_admin) {
                $transformedOrders = collect([]);
                return view('admin.adminorders', [
                    'orders' => collect([]),
                    'transformedOrders' => $transformedOrders,
                    'totProcessing' => 0,
                    'totCompleted' => 0,
                    'totCancelled' => 0,
                    'totShipped' => 0,
                    'orderProcessing' => collect([]),
                    'orderShipped' => collect([]),
                    'orderCompleted' => collect([]),
                    'orderCancelled' => collect([])
                ]);
            }
            
            return redirect()->back()->with('error', 'Error retrieving orders: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $user = auth()->user();
        
        if (!$user->is_admin && $order->user_id !== $user->id) {
            abort(403, 'Unauthorized to view this order');
        }
        
        $order->load(['user', 'orderItems.product']);
        
        // Transform order data for consistent display
        $transformedOrder = [
            'id' => $order->id,
            'code' => 'ORD' . str_pad($order->id, 4, '0', STR_PAD_LEFT),
            'status' => $this->mapStatusToFrontend($order->status),
            'date' => $order->created_at ? $order->created_at->format('Y-m-d H:i:s') : now()->format('Y-m-d H:i:s'),
            'total' => (float) $order->total,
            'items' => $order->orderItems->map(function ($item) {
                return [
                    'name' => $item->product ? $item->product->name : 'Unknown Product',
                    'qty' => (int) $item->quantity,
                    'price' => (float) $item->price,
                    'subtotal' => (float) ($item->price * $item->quantity)
                ];
            })->toArray(),
            'customer' => $order->nama_pemesan ?: ($order->user ? $order->user->name : 'Unknown'),
            'phone' => $order->nomor_hp ?: 'N/A',
            'address' => $order->address ?: 'No address',
            'payment_method' => $order->metode_pembayaran ?: 'Not specified',
            'shipping' => $order->jenis_pengiriman ?: 'Standard',
            'user_name' => $order->user ? $order->user->name : 'Guest',
            'user_email' => $order->user ? $order->user->email : 'N/A',
            'kota' => $order->kota ?: 'N/A',
            'kode_pos' => $order->kode_pos ?: 'N/A',
            'nomor_resi' => $order->nomor_resi
        ];
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $transformedOrder
            ]);
        }
        
        if ($user->is_admin) {
            return view('admin.orders.show', compact('order', 'transformedOrder'));
        } else {
            return view('orders.show', compact('order', 'transformedOrder'));
        }
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $user = auth()->user();
        
        if (!$user->is_admin) {
            abort(403, 'Unauthorized to update order status');
        }
        
        $request->validate([
            // pending removed because demo flow moves directly to processing
            'status' => 'required|in:processing,shipped,completed,cancelled'
        ]);
        
        try {
            $oldStatus = $order->status;
            $order->update(['status' => $request->status]);
            
            Log::info('Order status updated', [
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'updated_by' => $user->id
            ]);
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status pesanan berhasil diupdate',
                    'data' => [
                        'order_id' => $order->id,
                        'old_status' => $this->mapStatusToFrontend($oldStatus),
                        'new_status' => $this->mapStatusToFrontend($request->status)
                    ]
                ]);
            }
            
            return redirect()->back()->with('success', 'Status pesanan berhasil diupdate');
            
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'status' => $request->status,
                'user_id' => $user->id
            ]);
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate status: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Gagal mengupdate status: ' . $e->getMessage());
        }
    }

    /**
     * Ship order with tracking number
     */
    public function shipOrder(Request $request, Order $order)
    {
        $user = auth()->user();
        
        if (!$user->is_admin) {
            abort(403, 'Unauthorized to ship order');
        }
        
        $request->validate([
            'nomor_resi' => 'required|string|max:255'
        ], [
            'nomor_resi.required' => 'Nomor resi wajib diisi',
            'nomor_resi.max' => 'Nomor resi maksimal 255 karakter'
        ]);
        
        try {
            $oldStatus = $order->status;
            
            if ($oldStatus !== 'processing') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan harus dalam status dikemas untuk dapat dikirim'
                ], 400);
            }
            
            $order->update([
                'status' => 'shipped',
                'nomor_resi' => $request->nomor_resi
            ]);
            
            Log::info('Order shipped with tracking number', [
                'order_id' => $order->id,
                'old_status' => $oldStatus,
                'new_status' => 'shipped',
                'nomor_resi' => $request->nomor_resi,
                'shipped_by' => $user->id
            ]);
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dikirim dengan nomor resi: ' . $request->nomor_resi,
                    'data' => [
                        'order_id' => $order->id,
                        'old_status' => $this->mapStatusToFrontend($oldStatus),
                        'new_status' => 'dikirim',
                        'nomor_resi' => $request->nomor_resi
                    ]
                ]);
            }
            
            return redirect()->back()->with('success', 'Pesanan berhasil dikirim dengan nomor resi: ' . $request->nomor_resi);
            
        } catch (\Exception $e) {
            Log::error('Error shipping order: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'nomor_resi' => $request->nomor_resi,
                'user_id' => $user->id
            ]);
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim pesanan: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Gagal mengirim pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {

    }

    /**
     * Map database status to frontend status
     */
    private function mapStatusToFrontend($status)
    {
        $statusMap = [
            'processing' => 'dikemas', 
            'shipped' => 'dikirim',
            'completed' => 'selesai',
            'cancelled' => 'dibatalkan'
        ];
        
        return $statusMap[$status] ?? $status;
    }
}
