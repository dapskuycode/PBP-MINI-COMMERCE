<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'buyer')->count();
        $totalOrders = 0; // Will be implemented later when Order model is ready
        $totalRevenue = 0; // Will be implemented later

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalUsers',
            'totalOrders',
            'totalRevenue'
        ));
    }
}
