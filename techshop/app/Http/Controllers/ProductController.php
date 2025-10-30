<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display product information page.
     * Route name: productInformation
     */
    public function productInformation($id)
    {
        $product = Product::with(['inventoryItem.category', 'images', 'inventoryItem.attributeValues.attribute'])
            ->where('status', 'active')
            ->findOrFail($id);

        // Suggestions: random products from same category (exclude current)
        $categoryId = optional($product->inventoryItem)->category_id;
        $suggestions = collect();
        if ($categoryId) {
            $suggestions = Product::with(['images', 'inventoryItem'])
                ->where('status', 'active')
                ->whereHas('inventoryItem', function ($q) use ($categoryId) {
                    $q->where('category_id', $categoryId);
                })
                ->where('id', '!=', $product->id)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }

        return view('product.information', compact('product', 'suggestions'));
    }
}
