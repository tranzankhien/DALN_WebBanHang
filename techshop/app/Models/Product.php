<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'inventory_item_id',
        'name',
        'description',
        'price',
        'discount_price',
        'stock',
        'max_stock',
        'status',
        'is_featured',
        'display_order',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'stock' => 'integer',
        'max_stock' => 'integer',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
