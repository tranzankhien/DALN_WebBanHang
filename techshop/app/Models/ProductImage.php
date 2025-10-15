<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_url',
        'is_main',
        'display_order',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'display_order' => 'integer',
    ];

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
