<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\InventoryItem;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['inventoryItem.category', 'images']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by featured
        if ($request->has('is_featured') && $request->is_featured != '') {
            $query->where('is_featured', $request->is_featured);
        }

        $products = $query->latest()->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventoryItems = InventoryItem::with('category')
            ->where('stock_quantity', '>', 0)
            ->get();
        
        return view('admin.products.create', compact('inventoryItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'name' => 'required|max:150',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,active,inactive,out_of_stock',
            'is_featured' => 'boolean',
            'display_order' => 'nullable|integer|min:0',
            'published_at' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*.url' => 'required|url',
            'images.*.is_main' => 'boolean',
        ]);

        // Get inventory item to check stock
        $inventoryItem = InventoryItem::findOrFail($validated['inventory_item_id']);
        
        if ($validated['stock'] > $inventoryItem->stock_quantity) {
            return back()->withErrors(['stock' => 'Số lượng không được vượt quá số lượng trong kho (' . $inventoryItem->stock_quantity . ')']);
        }

        $validated['is_featured'] = $request->has('is_featured');
        
        if (empty($validated['display_order'])) {
            $validated['display_order'] = Product::max('display_order') + 1;
        }

        $product = Product::create($validated);

        // Save images if provided
        if ($request->has('images')) {
            foreach ($request->images as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $image['url'],
                    'is_main' => $image['is_main'] ?? false,
                    'display_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with(['inventoryItem.category', 'images', 'inventoryItem.attributeValues.attribute'])
            ->findOrFail($id);
        
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with(['images', 'inventoryItem'])->findOrFail($id);
        $inventoryItems = InventoryItem::with('category')->get();
        
        return view('admin.products.edit', compact('product', 'inventoryItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'inventory_item_id' => 'required|exists:inventory_items,id',
            'name' => 'required|max:150',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'max_stock' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,active,inactive,out_of_stock',
            'is_featured' => 'boolean',
            'display_order' => 'nullable|integer|min:0',
            'published_at' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*.url' => 'required|url',
            'images.*.is_main' => 'boolean',
        ]);

        // Check stock
        $inventoryItem = InventoryItem::findOrFail($validated['inventory_item_id']);
        if ($validated['stock'] > $inventoryItem->stock_quantity) {
            return back()->withErrors(['stock' => 'Số lượng không được vượt quá số lượng trong kho (' . $inventoryItem->stock_quantity . ')']);
        }

        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        // Update images if provided
        if ($request->has('images')) {
            // Delete old images
            ProductImage::where('product_id', $product->id)->delete();
            
            // Create new images
            foreach ($request->images as $index => $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $image['url'],
                    'is_main' => $image['is_main'] ?? false,
                    'display_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Check if product has orders
        if ($product->orderItems()->count() > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Không thể xóa sản phẩm đã có trong đơn hàng!');
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa!');
    }

    /**
     * Publish a product
     */
    public function publish(string $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'status' => 'active',
            'published_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', 'Sản phẩm đã được công khai!');
    }

    /**
     * Unpublish a product
     */
    public function unpublish(string $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'status' => 'inactive',
        ]);

        return redirect()->back()
            ->with('success', 'Sản phẩm đã được ẩn!');
    }
}
