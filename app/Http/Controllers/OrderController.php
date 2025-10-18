<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
        $user = auth()->user();
        
        if ($user->is_admin) {
            $orders = Order::with(['user', 'orderItems.product'])
                ->latest()
                ->get();
            $totPending = $orders->where('status', 'pending')->count();
            $totProcessing = $orders->where('status', 'processing')->count();
            $totShipped = $orders->where('status', 'shipped')->count();
            $totCompleted = $orders->where('status', 'completed')->count();
            $totCancelled = $orders->where('status', 'cancelled')->count();
            $orderPending = $orders->where('status', 'pending');
            $orderProcessing = $orders->where('status', 'processing');
            $orderShipped = $orders->where('status', 'shipped');
            $orderCompleted = $orders->where('status', 'completed');
            $orderCancelled = $orders->where('status', 'cancelled');
                
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'data' => $orders,
                    'message' => 'Orders retrieved successfully for admin'
                ]);
            }

            return view('admin.adminorders', compact('orders', 'totPending', 'totProcessing', 'totCompleted', 'totCancelled', 'totShipped', 'orderPending', 'orderProcessing', 'orderShipped', 'orderCompleted', 'orderCancelled'));
        } else {
            $orders = Order::with(['orderItems.product'])
                ->where('user_id', $user->id)
                ->latest()
                ->get();
            $totPending = $orders->where('status', 'pending')->count();
            $totProcessing = $orders->where('status', 'processing')->count();
            $totShipped = $orders->where('status', 'shipped')->count();
            $totCompleted = $orders->where('status', 'completed')->count();
            $totCancelled = $orders->where('status', 'cancelled')->count();
            $orderPending = $orders->where('status', 'pending');
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
            
            return view('orders', compact('orders', 'totPending', 'totProcessing', 'totCompleted', 'totCancelled', 'totShipped', 'orderPending', 'orderProcessing', 'orderShipped', 'orderCompleted', 'orderCancelled'));
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
        
        if ($user->is_admin) {
            return view('admin.orders.show', compact('order'));
        } else {
            return view('orders.show', compact('order'));
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
}
