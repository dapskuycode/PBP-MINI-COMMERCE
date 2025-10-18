<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Double check admin access
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Akses ditolak. Halaman ini hanya untuk admin.');
        }

        // Stats Cards Data
        $pendingShippedOrders = Order::whereIn('status', ['processing', 'shipped'])->count();
        
        // Monthly revenue calculation
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $monthlyRevenue = Order::whereIn('status', ['completed', 'shipped'])
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total');
        
        // Active users (users who have made orders in last 30 days)
        $activeUsers = User::whereHas('orders', function($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            })
            ->where('role', 'user')
            ->count();

        // Low stock products (stock <= 10)
        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 10)
            ->orderBy('stock', 'asc')
            ->get();

        // Monthly sales data for chart (last 12 months)
        $salesData = [];
        $monthLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $sales = Order::whereIn('status', ['completed', 'shipped'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total');
            
            $salesData[] = $sales;
            $monthLabels[] = $date->format('M Y'); // Format: "Oct 2024", "Nov 2024", etc.
        }

        // Recent orders
        $recentOrders = Order::with(['user', 'orderItems.product'])
            ->latest()
            ->limit(10)
            ->get();

        // Top selling products (by quantity sold)
        $topProducts = Product::with('category')
            ->select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['completed', 'shipped'])
            ->groupBy('products.id')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        return view('admin.admindashboard', compact(
            'pendingShippedOrders',
            'monthlyRevenue', 
            'activeUsers',
            'lowStockProducts',
            'salesData',
            'monthLabels',
            'recentOrders',
            'topProducts'
        ));
    }
}
