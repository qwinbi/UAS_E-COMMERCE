<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        if ($request->status === 'paid') {
            Notification::createOrderPaidNotification($order->id, $order->total_amount);
        }

        return redirect()->back()->with('success', 'Status order diperbarui!');
    }

    public function markNotificationAsRead(Notification $notification)
    {
        $notification->markAsRead();
        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai dibaca!');
    }

    public function markAllNotificationsAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai dibaca!');
    }
}