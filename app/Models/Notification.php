<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'data',
        'is_read',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
    ];

    public static function createOrderPaidNotification($orderId, $amount)
    {
        return self::create([
            'type' => 'order_paid',
            'data' => [
                'order_id' => $orderId,
                'amount' => $amount,
                'message' => 'Order #' . $orderId . ' telah dibayar sebesar Rp ' . number_format($amount, 0, ',', '.'),
            ],
            'is_read' => false,
        ]);
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
}