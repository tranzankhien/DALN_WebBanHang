<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = InventoryItem::with('category');

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Filter by stock status
        if ($request->has('stock_status')) {
            if ($request->stock_status == 'low') {
                $query->where('stock_quantity', '<', 10);
            } elseif ($request->stock_status == 'out') {
                $query->where('stock_quantity', '<=', 0);
            }
        }

        $items = $query->latest()->paginate(15);
        $categories = Category::where('status', 'active')->get();

        return view('admin.inventory.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.inventory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:inventory_items,sku|max:50',
            'name' => 'required|max:150',
            'description' => 'nullable',
            'brand' => 'nullable|max:100',
            'category_id' => 'required|exists:categories,id',
            'cost_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'attributes' => 'nullable|array',
            'attributes.*.attribute_id' => 'required|exists:product_attributes,id',
            'attributes.*.value' => 'required|max:100',
        ]);

        $item = InventoryItem::create($validated);

        // Save attributes if provided
        if ($request->has('attributes')) {
            foreach ($request->attributes as $attr) {
                ProductAttributeValue::create([
                    'inventory_item_id' => $item->id,
                    'attribute_id' => $attr['attribute_id'],
                    'value' => $attr['value'],
                ]);
            }
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Sản phẩm đã được thêm vào kho thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = InventoryItem::with(['category', 'attributeValues.attribute', 'products', 'transactions'])
            ->findOrFail($id);
        
        return view('admin.inventory.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = InventoryItem::with('attributeValues')->findOrFail($id);
        $categories = Category::where('status', 'active')->get();
        $attributes = ProductAttribute::where('category_id', $item->category_id)->get();
        
        return view('admin.inventory.edit', compact('item', 'categories', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = InventoryItem::findOrFail($id);

        $validated = $request->validate([
            'sku' => 'required|max:50|unique:inventory_items,sku,' . $id,
            'name' => 'required|max:150',
            'description' => 'nullable',
            'brand' => 'nullable|max:100',
            'category_id' => 'required|exists:categories,id',
            'cost_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'attributes' => 'nullable|array',
            'attributes.*.attribute_id' => 'required|exists:product_attributes,id',
            'attributes.*.value' => 'required|max:100',
        ]);

        $item->update($validated);

        // Update attributes
        if ($request->has('attributes')) {
            // Delete old attributes
            ProductAttributeValue::where('inventory_item_id', $item->id)->delete();
            
            // Create new attributes
            foreach ($request->attributes as $attr) {
                ProductAttributeValue::create([
                    'inventory_item_id' => $item->id,
                    'attribute_id' => $attr['attribute_id'],
                    'value' => $attr['value'],
                ]);
            }
        }

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = InventoryItem::findOrFail($id);
        
        // Check if item has products
        if ($item->products()->count() > 0) {
            return redirect()->route('admin.inventory.index')
                ->with('error', 'Không thể xóa sản phẩm này vì đã có sản phẩm bán liên kết!');
        }

        $item->delete();

        return redirect()->route('admin.inventory.index')
            ->with('success', 'Sản phẩm đã được xóa khỏi kho!');
    }

    /**
     * Get attributes by category
     */
    public function getAttributesByCategory(Request $request)
    {
        $attributes = ProductAttribute::where('category_id', $request->category_id)->get();
        return response()->json($attributes);
    }
}
