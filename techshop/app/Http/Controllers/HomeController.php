<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Advertisment;
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
        // For each category prepare up to 10 preview products (for the home page sections)
        foreach ($categories as $category) {
            $category->previewProducts = Product::with(['inventoryItem.category', 'images'])
                ->where('status', 'active')
                ->whereHas('inventoryItem', function ($q) use ($category) {
                    $q->where('category_id', $category->id);
                })
                ->latest('published_at')
                ->take(10)
                ->get();
        }
        // Get advertisments (if table exists, model will query it)
        $ads = collect();
        try {
            $ads = Advertisment::orderBy('id_advert', 'desc')->get();
        } catch (\Exception $e) {
            // If table doesn't exist or query fails, keep $ads empty - view will handle fallback
            $ads = collect();
        }

        return view('home', compact('featuredProducts', 'latestProducts', 'categories', 'ads'));
    }
}
