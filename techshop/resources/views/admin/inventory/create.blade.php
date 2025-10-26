@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm vào kho')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900" style="font-size: 1.875rem;">Thêm sản phẩm vào kho</h1>
    <p class="mt-1 text-sm text-gray-600">Nhập thông tin sản phẩm mới</p>
</div>

<div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('admin.inventory.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- SKU -->
            <div>
                <label for="sku" class="block text-sm font-medium text-gray-700">Mã SKU *</label>
                <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('sku') border-red-500 @enderror">
                @error('sku')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Brand -->
            <div>
                <label for="brand" class="block text-sm font-medium text-gray-700">Thương hiệu</label>
                <input type="text" name="brand" id="brand" value="{{ old('brand') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Category -->
            <div class="md:col-span-2">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục *</label>
                <select name="category_id" id="category_id" required onchange="loadCategoryAttributes()"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Dynamic Attributes Section -->
        <div id="attributes-container" class="mt-6 hidden">
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Thông tin chi tiết sản phẩm
                </h3>
                <div id="attributes-fields" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Dynamic fields will be loaded here -->
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <!-- Cost Price -->
            <div>
                <label for="cost_price" class="block text-sm font-medium text-gray-700">Giá nhập *</label>
                <input type="number" name="cost_price" id="cost_price" value="{{ old('cost_price') }}" step="0.01" min="0" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('cost_price') border-red-500 @enderror">
                @error('cost_price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Stock Quantity -->
            <div>
                <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Số lượng *</label>
                <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('stock_quantity') border-red-500 @enderror">
                @error('stock_quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div class="mt-6">
            <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
            <textarea name="description" id="description" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>

        <!-- Buttons -->
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.inventory.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Hủy
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" style="background-color: #1e40af; margin-left: 10px;">
                Lưu sản phẩm
            </button>
        </div>
    </form>
</div>

<script>
function loadCategoryAttributes() {
    const categoryId = document.getElementById('category_id').value;
    const container = document.getElementById('attributes-container');
    const fieldsContainer = document.getElementById('attributes-fields');
    
    if (!categoryId) {
        container.classList.add('hidden');
        fieldsContainer.innerHTML = '';
        return;
    }
    
    // Show loading state
    fieldsContainer.innerHTML = '<div class="col-span-2 text-center py-4"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div><p class="mt-2 text-sm text-gray-600">Đang tải thông tin...</p></div>';
    container.classList.remove('hidden');
    
    // Fetch attributes for this category
    fetch(`/admin/inventory/attributes/${categoryId}`)
        .then(response => response.json())
        .then(attributes => {
            if (attributes.length === 0) {
                container.classList.add('hidden');
                fieldsContainer.innerHTML = '';
                return;
            }
            
            // Build attribute fields
            let html = '';
            attributes.forEach(attr => {
                const fieldId = `attribute_${attr.id}`;
                html += `
                    <div>
                        <label for="${fieldId}" class="block text-sm font-medium text-gray-700">
                            ${attr.name} ${attr.unit ? `<span class="text-gray-500 text-xs">(${attr.unit})</span>` : ''}
                        </label>
                        <input 
                            type="text" 
                            name="attributes[${attr.id}]" 
                            id="${fieldId}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                            placeholder="Nhập ${attr.name.toLowerCase()}...">
                    </div>
                `;
            });
            
            fieldsContainer.innerHTML = html;
            container.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error loading attributes:', error);
            fieldsContainer.innerHTML = '<div class="col-span-2 text-center py-4 text-red-600">Không thể tải thông tin thuộc tính</div>';
        });
}

// Load attributes if category is pre-selected (e.g., from old input after validation error)
document.addEventListener('DOMContentLoaded', function() {
    const categoryId = document.getElementById('category_id').value;
    if (categoryId) {
        loadCategoryAttributes();
    }
});
</script>
@endsection
