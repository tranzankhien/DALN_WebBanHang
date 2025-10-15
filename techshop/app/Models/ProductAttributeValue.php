<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    protected $fillable = [
        'inventory_item_id',
        'attribute_id',
        'value',
    ];

    // Relationships
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id');
    }
}
