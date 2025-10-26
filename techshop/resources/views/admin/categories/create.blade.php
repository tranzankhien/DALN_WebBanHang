@extends('admin.layouts.app')

@section('title', 'Thêm danh mục')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Thêm danh mục mới
            </h1>
            <p class="mt-2 text-sm text-gray-600">Tạo danh mục sản phẩm mới cho cửa hàng</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Quay lại
        </a>
    </div>
</div>

<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <form action="{{ route('admin.categories.store') }}" method="POST" id="categoryForm">
        @csrf
        
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h2 class="text-lg font-semibold text-gray-900">Thông tin danh mục</h2>
            <p class="mt-1 text-sm text-gray-600">Điền thông tin chi tiết cho danh mục mới</p>
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
                           value="{{ old('name') }}" 
                           required
                           placeholder="Ví dụ: Điện thoại, Laptop..."
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 
                                  @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Tên hiển thị của danh mục trên website</p>
                </div>

                <!-- Slug -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700">
                        Slug (URL)
                    </label>
                    <div class="mt-1 flex rounded-lg shadow-sm">
                        <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 text-gray-600 text-sm">
                            /category/
                        </span>
                        <input type="text" 
                               name="slug" 
                               id="slug" 
                               value="{{ old('slug') }}"
                               placeholder="tu-dong-tao"
                               class="flex-1 block w-full rounded-none rounded-r-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Để trống để tự động tạo từ tên danh mục</p>
                </div>

                <!-- Parent Category -->
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700">
                        Danh mục cha
                    </label>
                    <select name="parent_id" 
                            id="parent_id"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Không có (danh mục gốc) --</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Chọn nếu đây là danh mục con</p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Trạng thái <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex items-center p-3 cursor-pointer border-2 border-blue-500 bg-blue-50 rounded-lg transition">
                            <input type="radio" 
                                   name="status" 
                                   value="active" 
                                   checked
                                   class="sr-only"
                                   onchange="updateStatusStyle(this)">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full border-2 border-blue-500 flex items-center justify-center mr-3">
                                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-gray-900">Hoạt động</p>
                                    <p class="text-xs text-gray-600">Hiển thị công khai</p>
                                </div>
                            </div>
                        </label>
                        <label class="relative flex items-center p-3 cursor-pointer border-2 border-gray-300 rounded-lg transition hover:border-red-300">
                            <input type="radio" 
                                   name="status" 
                                   value="inactive"
                                   class="sr-only"
                                   onchange="updateStatusStyle(this)">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center mr-3">
                                    <div class="w-2 h-2 rounded-full bg-red-500 hidden"></div>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-gray-900">Không hoạt động</p>
                                    <p class="text-xs text-gray-600">Ẩn khỏi trang web</p>
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
                           value="{{ old('display_order', 0) }}" 
                           min="0"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Số nhỏ hơn sẽ hiển thị trước (mặc định: 0)</p>
                </div>

                <!-- Image URL -->
                <div>
                    <label for="image_url" class="block text-sm font-medium text-gray-700">
                        URL ảnh đại diện
                    </label>
                    <input type="url" 
                           name="image_url" 
                           id="image_url" 
                           value="{{ old('image_url') }}"
                           placeholder="https://example.com/image.jpg"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                           onchange="previewImage(this)">
                    <p class="mt-1 text-xs text-gray-500">Link đầy đủ đến hình ảnh đại diện</p>
                </div>
            </div>

            <!-- Image Preview -->
            <div class="mt-6 hidden" id="imagePreviewContainer">
                <label class="block text-sm font-medium text-gray-700 mb-2">Xem trước ảnh</label>
                <div class="relative inline-block">
                    <img id="imagePreview" 
                         src="" 
                         alt="Preview" 
                         class="h-40 w-auto rounded-lg shadow-lg object-cover border-2 border-gray-200">
                    <button type="button" 
                            onclick="removeImagePreview()" 
                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700">
                    Mô tả
                </label>
                <textarea name="description" 
                          id="description" 
                          rows="4"
                          placeholder="Nhập mô tả chi tiết về danh mục (tùy chọn)..."
                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Mô tả sẽ hiển thị trên trang danh mục</p>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span><span class="text-red-500">*</span> là trường bắt buộc</span>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.categories.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Hủy
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 border border-transparent rounded-lg font-semibold text-white hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Lưu danh mục
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Help Cards -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-semibold text-blue-900">Slug tự động</h3>
                <p class="mt-1 text-xs text-blue-700">Khi bạn nhập tên danh mục, slug sẽ được tạo tự động. Bạn có thể chỉnh sửa nếu muốn.</p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-semibold text-green-900">Danh mục phân cấp</h3>
                <p class="mt-1 text-xs text-green-700">Bạn có thể tạo danh mục con bằng cách chọn danh mục cha. Hỗ trợ 2 cấp.</p>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <div>
                <h3 class="text-sm font-semibold text-purple-900">Hình ảnh</h3>
                <p class="mt-1 text-xs text-purple-700">Thêm hình ảnh đại diện giúp danh mục trở nên hấp dẫn và dễ nhận diện hơn.</p>
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
    const container = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');
    
    if (input.value) {
        preview.src = input.value;
        container.classList.remove('hidden');
    } else {
        container.classList.add('hidden');
    }
}

// Remove image preview
function removeImagePreview() {
    document.getElementById('image_url').value = '';
    document.getElementById('imagePreviewContainer').classList.add('hidden');
}

// Update status radio button style
function updateStatusStyle(input) {
    const labels = input.closest('div').querySelectorAll('label');
    labels.forEach(label => {
        const radio = label.querySelector('input[type="radio"]');
        const dot = label.querySelector('.w-2');
        const circle = label.querySelector('.w-4');
        
        if (radio.checked) {
            if (radio.value === 'active') {
                label.classList.add('border-blue-500', 'bg-blue-50');
                label.classList.remove('border-gray-300', 'border-red-500', 'bg-red-50');
                circle.classList.remove('border-gray-300');
                circle.classList.add('border-blue-500');
                dot.classList.remove('hidden', 'bg-red-500');
                dot.classList.add('bg-blue-500');
            } else {
                label.classList.add('border-red-500', 'bg-red-50');
                label.classList.remove('border-gray-300', 'border-blue-500', 'bg-blue-50');
                circle.classList.remove('border-gray-300', 'border-blue-500');
                circle.classList.add('border-red-500');
                dot.classList.remove('hidden', 'bg-blue-500');
                dot.classList.add('bg-red-500');
            }
        } else {
            label.classList.remove('border-blue-500', 'bg-blue-50', 'border-red-500', 'bg-red-50');
            label.classList.add('border-gray-300');
            circle.classList.remove('border-blue-500', 'border-red-500');
            circle.classList.add('border-gray-300');
            dot.classList.add('hidden');
        }
    });
}

// Form validation before submit
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    const name = document.getElementById('name').value.trim();
    
    if (!name) {
        e.preventDefault();
        alert('Vui lòng nhập tên danh mục!');
        document.getElementById('name').focus();
        return false;
    }
});
</script>
@endpush
@endsection
