<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class PublicCategoryController extends Controller
{
    /**
     * Show products for a category (public)
     */
    public function products($id)
    {
        $category = Category::findOrFail($id);

        $products = Product::with(['images', 'inventoryItem'])
            ->where('status', 'active')
            ->whereHas('inventoryItem', function ($q) use ($id) {
                $q->where('category_id', $id);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(20);

        return view('category', compact('category', 'products'));
    }
}
