@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm bán')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900" style="font-size: 1.875rem;">Thêm sản phẩm bán mới</h1>
    <p class="mt-1 text-sm text-gray-600">Tạo sản phẩm bán từ kho hàng</p>
</div>

<div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf
        
        <!-- Select from Inventory -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h3 class="text-lg font-medium text-blue-900 mb-4">Bước 1: Chọn sản phẩm từ kho</h3>
            <div>
                <label for="inventory_item_id" class="block text-sm font-medium text-gray-700">Sản phẩm trong kho *</label>
                <select name="inventory_item_id" id="inventory_item_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('inventory_item_id') border-red-500 @enderror">
                    <option value="">-- Chọn sản phẩm --</option>
                    @foreach($inventoryItems as $item)
                        <option value="{{ $item->id }}" 
                            data-name="{{ $item->name }}"
                            data-price="{{ $item->cost_price }}"
                            data-stock="{{ $item->stock_quantity }}"
                            {{ old('inventory_item_id') == $item->id ? 'selected' : '' }}>
                            [{{ $item->sku }}] {{ $item->name }} - {{ $item->category->name }} (Tồn: {{ $item->stock_quantity }})
                        </option>
                    @endforeach
                </select>
                @error('inventory_item_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500" id="selected-info"></p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name (Marketing) -->
            <div class="md:col-span-2">
                <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm (Marketing) *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <p class="mt-1 text-xs text-gray-500">Tên hiển thị cho khách hàng (có thể khác tên trong kho)</p>
            </div>

            <!-- Price -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Giá bán *</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" step="1000" min="0" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Discount Price -->
            <div>
                <label for="discount_price" class="block text-sm font-medium text-gray-700">Giá khuyến mãi</label>
                <input type="number" name="discount_price" id="discount_price" value="{{ old('discount_price') }}" step="1000" min="0"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Stock -->
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Số lượng hiển thị *</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <p class="mt-1 text-xs text-gray-500">Số lượng khách hàng có thể mua</p>
            </div>

            <!-- Max Stock -->
            <div>
                <label for="max_stock" class="block text-sm font-medium text-gray-700">Giới hạn bán</label>
                <input type="number" name="max_stock" id="max_stock" value="{{ old('max_stock') }}" min="0"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <p class="mt-1 text-xs text-gray-500">Số lượng tối đa muốn bán (để trống = không giới hạn)</p>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái *</label>
                <select name="status" id="status" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Nháp</option>
                    <option value="active" {{ old('status', 'draft') == 'active' ? 'selected' : '' }}>Đang bán</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Ngừng bán</option>
                    <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
                </select>
            </div>

            <!-- Display Order -->
            <div>
                <label for="display_order" class="block text-sm font-medium text-gray-700">Thứ tự hiển thị</label>
                <input type="number" name="display_order" id="display_order" value="{{ old('display_order', 0) }}" min="0"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <!-- Is Featured -->
            <div class="md:col-span-2">
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_featured" class="ml-2 block text-sm text-gray-700">
                        Sản phẩm nổi bật (hiển thị ở trang chủ)
                    </label>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mt-6">
            <label for="description" class="block text-sm font-medium text-gray-700">Mô tả chi tiết</label>
            <textarea name="description" id="description" rows="6"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>

        <!-- Images -->
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Hình ảnh sản phẩm</label>
            <div id="images-container" class="space-y-2">
                <div class="flex gap-2 image-row">
                    <input type="url" name="images[0][url]" placeholder="URL hình ảnh" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <label class="flex items-center">
                        <input type="checkbox" name="images[0][is_main]" value="1" class="h-4 w-4 text-blue-600 rounded">
                        <span class="ml-1 text-sm">Ảnh chính</span>
                    </label>
                    <button type="button" onclick="removeImageRow(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" style="margin-left: 10px;">Xóa</button>
                </div>
            </div>
            <button type="button" onclick="addImageRow()" class="mt-2 text-sm text-blue-600 hover:text-blue-800">+ Thêm ảnh</button>
        </div>

        <!-- Buttons -->
        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Hủy
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" style="background-color: #1e40af; margin-left: 10px;">
                Lưu sản phẩm
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let imageCount = 1;

    // Auto-fill product name and price from inventory
    document.getElementById('inventory_item_id').addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (option.value) {
            document.getElementById('name').value = option.dataset.name;
            document.getElementById('price').value = parseFloat(option.dataset.price) * 1.3; // Markup 30%
            document.getElementById('stock').value = option.dataset.stock;
            document.getElementById('selected-info').textContent = `Tồn kho: ${option.dataset.stock} sản phẩm`;
        }
    });

    function addImageRow() {
        const container = document.getElementById('images-container');
        const row = document.createElement('div');
        row.className = 'flex gap-2 image-row';
        row.innerHTML = `
            <input type="url" name="images[${imageCount}][url]" placeholder="URL hình ảnh" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <label class="flex items-center">
                <input type="checkbox" name="images[${imageCount}][is_main]" value="1" class="h-4 w-4 text-blue-600 rounded">
                <span class="ml-1 text-sm">Ảnh chính</span>
            </label>
            <button type="button" onclick="removeImageRow(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Xóa</button>
        `;
        container.appendChild(row);
        imageCount++;
    }

    function removeImageRow(button) {
        if (document.querySelectorAll('.image-row').length > 1) {
            button.closest('.image-row').remove();
        } else {
            alert('Phải có ít nhất một ảnh!');
        }
    }
</script>
@endpush
@endsection
