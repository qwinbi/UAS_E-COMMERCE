<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'paid')->sum('total_amount'),
            'unread_notifications' => Notification::where('is_read', false)->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $notifications = Notification::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'notifications'));
    }
}