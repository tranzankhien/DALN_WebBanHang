<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_inventory' => InventoryItem::count(),
            'total_stock' => InventoryItem::sum('stock_quantity'),
            'total_products' => Product::where('status', 'active')->count(),
            'total_categories' => Category::where('status', 'active')->count(),
            'low_stock' => InventoryItem::where('stock_quantity', '<', 10)->count(),
            'out_of_stock' => Product::where('status', 'out_of_stock')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                ->where('status', 'completed')
                ->sum('total_amount'),
        ];

        $recent_orders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $low_stock_items = InventoryItem::where('stock_quantity', '<', 10)
            ->orderBy('stock_quantity', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'low_stock_items'));
    }
}
