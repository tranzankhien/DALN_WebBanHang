<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('parent')
            ->orderBy('display_order')
            ->get();
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'slug' => 'nullable|unique:categories,slug|max:100',
            'description' => 'nullable',
            'image_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'display_order' => 'nullable|integer|min:0',
            'attributes' => 'nullable|array',
            'attributes.*.name' => 'required|string|max:100',
            'attributes.*.unit' => 'nullable|string|max:50',
            'attributes.*.input_type' => 'required|in:text,number,select',
        ]);

        // Auto generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set default display_order
        if (empty($validated['display_order'])) {
            $validated['display_order'] = Category::max('display_order') + 1;
        }

        // Create category
        $category = Category::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
            'status' => $validated['status'],
            'display_order' => $validated['display_order'],
        ]);

        // Create attributes if provided
        if (!empty($validated['attributes'])) {
            foreach ($validated['attributes'] as $attr) {
                ProductAttribute::create([
                    'category_id' => $category->id,
                    'name' => $attr['name'],
                    'unit' => $attr['unit'] ?? null,
                    'input_type' => $attr['input_type'],
                ]);
            }
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được tạo thành công!' . 
                   (!empty($validated['attributes']) ? ' Đã thêm ' . count($validated['attributes']) . ' thuộc tính.' : ''));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with(['parent', 'children', 'inventoryItems', 'productAttributes.attributeValues'])
            ->findOrFail($id);
        
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:100',
            'slug' => 'required|max:100|unique:categories,slug,' . $id,
            'description' => 'nullable',
            'image_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        // Check if category has inventory items
        if ($category->inventoryItems()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục đã có sản phẩm!');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được xóa!');
    }

    /**
     * Update display order via AJAX
     */
    public function updateOrder(Request $request)
    {
        $orders = $request->input('orders');
        
        foreach ($orders as $order) {
            Category::where('id', $order['id'])->update(['display_order' => $order['order']]);
        }

        return response()->json(['success' => true]);
    }
}
