<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Authorization - pastikan user hanya bisa melihat order mereka sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $order->load(['items.product']);
        return view('orders.show', compact('order'));
    }

    public function cancel(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Order tidak dapat dibatalkan karena sudah diproses.');
        }

        $order->update(['status' => 'cancelled']);

        // Kembalikan stok produk
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order berhasil dibatalkan.');
    }

    public function confirmPayment(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Order sudah diproses.');
        }

        // Simulasi konfirmasi pembayaran
        // Di aplikasi nyata, ini akan dipanggil oleh payment gateway callback
        $order->update(['status' => 'paid']);
        
        // Buat notifikasi untuk admin
        \App\Models\Notification::createOrderPaidNotification($order->id, $order->total_amount);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pembayaran berhasil dikonfirmasi! Order sedang diproses.');
    }
}