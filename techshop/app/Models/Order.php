<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_district',
        'shipping_ward',
        'customer_note',
        'cancel_reason',
        'cancelled_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'cancelled_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Helper Methods
    public function isCancellable()
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shipped' => 'Đang giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'shipped' => 'purple',
            'completed' => 'green',
            'cancelled' => 'red',
        ];
        return $colors[$this->status] ?? 'gray';
    }
}
