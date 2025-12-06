<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function confirm(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validator = \Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::find($request->order_id);
        
        if ($order->status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Order sudah dibayar'
            ], 400);
        }

        $order->update(['status' => 'paid']);

        // Buat notifikasi untuk admin
        Notification::createOrderPaidNotification($order->id, $order->total_amount);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran dikonfirmasi',
            'data' => [
                'order_id' => $order->id,
                'status' => $order->status,
                'total_amount' => $order->total_amount,
            ]
        ], 200);
    }
}