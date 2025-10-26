@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Danh mục')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Chỉnh sửa Danh mục</h1>
            <p class="mt-1 text-sm text-gray-600">Cập nhật thông tin danh mục</p>
        </div>
        <a href="{{ route('admin.categories.show', $category->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Quay lại
        </a>
    </div>
</div>

<div class="bg-white shadow rounded-lg overflow-hidden">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" id="categoryForm">
        @csrf
        @method('PUT')
        
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-900">Thông tin danh mục</h2>
        </div>

        <div class="px-6 py-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Tên danh mục <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name', $category->name) }}" 
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 
                                  @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Tên hiển thị của danh mục</p>
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">
                        Slug (URL) <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                            /category/
                        </span>
                        <input type="text" 
                               name="slug" 
                               id="slug" 
                               value="{{ old('slug', $category->slug) }}" 
                               required
                               class="flex-1 block w-full rounded-none rounded-r-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 
                                      @error('slug') border-red-500 @enderror">
                    </div>
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">URL thân thiện (chỉ chữ thường, số và gạch ngang)</p>
                </div>

                <!-- Parent Category -->
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700">
                        Danh mục cha
                    </label>
                    <select name="parent_id" 
                            id="parent_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 
                                   @error('parent_id') border-red-500 @enderror">
                        <option value="">-- Không có (danh mục gốc) --</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">
                        Trạng thái <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 grid grid-cols-2 gap-3">
                        <label class="relative flex items-center p-3 cursor-pointer border rounded-lg 
                                      {{ old('status', $category->status) == 'active' ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }}">
                            <input type="radio" 
                                   name="status" 
                                   value="active" 
                                   {{ old('status', $category->status) == 'active' ? 'checked' : '' }}
                                   class="sr-only"
                                   onchange="updateStatusStyle(this)">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center mr-3 
                                           {{ old('status', $category->status) == 'active' ? 'border-blue-500' : 'border-gray-300' }}">
                                    <div class="w-2 h-2 rounded-full bg-blue-500 {{ old('status', $category->status) == 'active' ? '' : 'hidden' }}"></div>
                                </div>
                                <div>
                                    <p class="font-medium text-sm">Hoạt động</p>
                                    <p class="text-xs text-gray-500">Hiển thị công khai</p>
                                </div>
                            </div>
                        </label>
                        <label class="relative flex items-center p-3 cursor-pointer border rounded-lg 
                                      {{ old('status', $category->status) == 'inactive' ? 'border-red-500 bg-red-50' : 'border-gray-300' }}">
                            <input type="radio" 
                                   name="status" 
                                   value="inactive" 
                                   {{ old('status', $category->status) == 'inactive' ? 'checked' : '' }}
                                   class="sr-only"
                                   onchange="updateStatusStyle(this)">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center mr-3 
                                           {{ old('status', $category->status) == 'inactive' ? 'border-red-500' : 'border-gray-300' }}">
                                    <div class="w-2 h-2 rounded-full bg-red-500 {{ old('status', $category->status) == 'inactive' ? '' : 'hidden' }}"></div>
                                </div>
                                <div>
                                    <p class="font-medium text-sm">Không hoạt động</p>
                                    <p class="text-xs text-gray-500">Ẩn khỏi trang web</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Display Order -->
                <div>
                    <label for="display_order" class="block text-sm font-medium text-gray-700">
                        Thứ tự hiển thị
                    </label>
                    <input type="number" 
                           name="display_order" 
                           id="display_order" 
                           value="{{ old('display_order', $category->display_order) }}" 
                           min="0"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Số thứ tự hiển thị (nhỏ hơn sẽ hiển thị trước)</p>
                </div>

                <!-- Image URL -->
                <div>
                    <label for="image_url" class="block text-sm font-medium text-gray-700">
                        URL ảnh đại diện
                    </label>
                    <input type="url" 
                           name="image_url" 
                           id="image_url" 
                           value="{{ old('image_url', $category->image_url) }}"
                           placeholder="https://example.com/image.jpg"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           onchange="previewImage(this)">
                    <p class="mt-1 text-xs text-gray-500">Link đầy đủ đến hình ảnh</p>
                </div>
            </div>

            <!-- Image Preview -->
            @if($category->image_url)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Xem trước ảnh</label>
                <div class="relative inline-block">
                    <img id="imagePreview" 
                         src="{{ $category->image_url }}" 
                         alt="Preview" 
                         class="h-32 w-auto rounded-lg shadow-md object-cover border-2 border-gray-200">
                </div>
            </div>
            @endif

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700">
                    Mô tả
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          placeholder="Nhập mô tả chi tiết về danh mục..."
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $category->description) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Mô tả chi tiết về danh mục (tùy chọn)</p>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-500">
                <span class="font-medium">Lưu ý:</span> Thay đổi sẽ được áp dụng ngay lập tức
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.categories.show', $category->id) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                    Hủy
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Lưu thay đổi
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Information Cards -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-semibold text-blue-900">Slug tự động</h3>
                <p class="mt-1 text-xs text-blue-700">Khi bạn nhập tên danh mục, slug sẽ tự động được tạo từ tên đó</p>
            </div>
        </div>
    </div>

    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-semibold text-green-900">Danh mục con</h3>
                <p class="mt-1 text-xs text-green-700">{{ $category->children->count() }} danh mục con đang hoạt động</p>
            </div>
        </div>
    </div>

    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <div>
                <h3 class="text-sm font-semibold text-purple-900">Sản phẩm</h3>
                <p class="mt-1 text-xs text-purple-700">{{ $category->inventoryItems->count() }} sản phẩm trong danh mục</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function(e) {
    const name = e.target.value;
    const slug = name.toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/đ/g, 'd')
        .replace(/Đ/g, 'd')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

// Preview image
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if (input.value && preview) {
        preview.src = input.value;
        preview.style.display = 'block';
    } else if (!input.value && preview) {
        preview.style.display = 'none';
    }
}

// Update status radio button style
function updateStatusStyle(input) {
    const labels = input.closest('div').querySelectorAll('label');
    labels.forEach(label => {
        const radio = label.querySelector('input[type="radio"]');
        const dot = label.querySelector('.w-2');
        if (radio.checked) {
            if (radio.value === 'active') {
                label.classList.add('border-blue-500', 'bg-blue-50');
                label.classList.remove('border-gray-300', 'border-red-500', 'bg-red-50');
                dot.classList.remove('hidden');
            } else {
                label.classList.add('border-red-500', 'bg-red-50');
                label.classList.remove('border-gray-300', 'border-blue-500', 'bg-blue-50');
                dot.classList.remove('hidden');
            }
        } else {
            label.classList.remove('border-blue-500', 'bg-blue-50', 'border-red-500', 'bg-red-50');
            label.classList.add('border-gray-300');
            dot.classList.add('hidden');
        }
    });
}

// Form validation
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    const slug = document.getElementById('slug').value.trim();
    
    if (!name || !slug) {
        e.preventDefault();
        alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
        return false;
    }
});
</script>
@endpush
@endsection
