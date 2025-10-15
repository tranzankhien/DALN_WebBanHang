<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        $parentCategories = Category::whereNull('parent_id')
            ->where('status', 'active')
            ->get();
        
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required|max:100',
            'slug' => 'nullable|unique:categories,slug|max:100',
            'description' => 'nullable',
            'image_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'display_order' => 'nullable|integer|min:0',
        ]);

        // Auto generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Set default display_order
        if (empty($validated['display_order'])) {
            $validated['display_order'] = Category::max('display_order') + 1;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::with(['parent', 'children', 'inventoryItems'])
            ->findOrFail($id);
        
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->where('status', 'active')
            ->get();
        
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'name' => 'required|max:100',
            'slug' => 'required|max:100|unique:categories,slug,' . $id,
            'description' => 'nullable',
            'image_url' => 'nullable|url|max:255',
            'status' => 'required|in:active,inactive',
            'display_order' => 'nullable|integer|min:0',
        ]);

        // Prevent category from being its own parent
        if ($validated['parent_id'] == $id) {
            return back()->withErrors(['parent_id' => 'Danh mục không thể là danh mục con của chính nó!']);
        }

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

        // Check if category has children
        if ($category->children()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Không thể xóa danh mục có danh mục con!');
        }

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
