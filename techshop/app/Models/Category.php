<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'slug',
        'name',
        'description',
        'image_url',
        'status',
        'display_order',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
