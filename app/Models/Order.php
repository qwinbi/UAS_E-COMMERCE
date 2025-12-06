<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'va_number',
        'qris_image',
        'shipping_address',
        'notif_admin_seen',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute()
    {
        return [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Dibayar',
            'cancelled' => 'Dibatalkan',
        ][$this->status] ?? $this->status;
    }

    public function getPaymentMethodLabelAttribute()
    {
        return [
            'va' => 'Virtual Account',
            'qris' => 'QRIS',
        ][$this->payment_method] ?? $this->payment_method;
    }
}