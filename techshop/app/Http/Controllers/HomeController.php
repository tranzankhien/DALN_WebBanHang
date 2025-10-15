<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products
        $featuredProducts = Product::with(['inventoryItem.category', 'images'])
            ->where('status', 'active')
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(8)
            ->get();

        // Get latest products
        $latestProducts = Product::with(['inventoryItem.category', 'images'])
            ->where('status', 'active')
            ->latest('published_at')
            ->take(12)
            ->get();

        // Get categories with product count
        $categories = Category::withCount(['inventoryItems'])
            ->where('status', 'active')
            ->orderBy('display_order')
            ->get();

        return view('home', compact('featuredProducts', 'latestProducts', 'categories'));
    }
}
