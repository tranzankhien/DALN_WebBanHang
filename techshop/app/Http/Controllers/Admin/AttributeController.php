<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use App\Models\Category;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $attributes = ProductAttribute::with('category')->latest()->paginate(20);
        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        return view('admin.attributes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
        ]);

        ProductAttribute::create($validated);

        return redirect()
            ->route('admin.categories.show', $request->category_id)
            ->with('success', 'Thuộc tính đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $attribute = ProductAttribute::with(['category', 'attributeValues'])->findOrFail($id);
        return view('admin.attributes.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        return view('admin.attributes.edit', compact('attribute', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:50',
        ]);

        $attribute->update($validated);

        return redirect()
            ->route('admin.categories.show', $attribute->category_id)
            ->with('success', 'Thuộc tính đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $categoryId = $attribute->category_id;
        $attribute->delete();

        return redirect()
            ->route('admin.categories.show', $categoryId)
            ->with('success', 'Thuộc tính đã được xóa thành công!');
    }
}

