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

            <!-- Attributes Management Section - MOVED INSIDE FORM -->
            <div class="mt-8 border-t pt-6">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Thuộc tính Sản phẩm
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">Quản lý các đặc điểm kỹ thuật cho sản phẩm thuộc danh mục này</p>
                        </div>
                        <button type="button" onclick="openAddAttributeModal()" 
                                class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700 shadow-md transition">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Thêm thuộc tính
                        </button>
                    </div>
                </div>

                <!-- Info Box -->
                <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-semibold text-blue-900">💡 Thuộc tính giúp mô tả chi tiết sản phẩm</h4>
                            <div class="mt-2 text-xs text-blue-700 space-y-1">
                                <p>• <strong>Laptop:</strong> CPU, RAM, Ổ cứng, Card đồ họa, Màn hình</p>
                                <p>• <strong>Điện thoại:</strong> Camera, Pin, Chip, Màn hình</p>
                                <p>• <strong>Tai nghe:</strong> Driver, Trở kháng, Độ nhạy, Kết nối</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attributes List -->
                @if($category->productAttributes->count() > 0)
                <div class="space-y-2">
                    @foreach($category->productAttributes as $attribute)
                    <div class="flex items-center justify-between p-3 bg-white border border-purple-200 rounded-lg hover:shadow-md transition">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-900">{{ $attribute->name }}</h4>
                                @if($attribute->unit)
                                <p class="text-xs text-gray-600">Đơn vị: <span class="font-medium text-purple-600">{{ $attribute->unit }}</span></p>
                                @else
                                <p class="text-xs text-gray-500 italic">Không có đơn vị</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="editAttribute({{ $attribute->id }}, '{{ addslashes($attribute->name) }}', '{{ addslashes($attribute->unit ?? '') }}')"
                                    class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Sửa
                            </button>
                            <form action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST" class="inline" onsubmit="return confirm('Xóa thuộc tính này sẽ xóa tất cả giá trị liên quan. Bạn có chắc chắn?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">
                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Xóa
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg">
                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <h3 class="mt-3 text-sm font-medium text-gray-900">Chưa có thuộc tính nào</h3>
                    <p class="mt-1 text-xs text-gray-500 max-w-md mx-auto">
                        Click nút "Thêm thuộc tính" ở trên để thêm đặc điểm kỹ thuật cho sản phẩm
                    </p>
                </div>
                @endif
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

    </div>
</div>

<!-- Add/Edit Attribute Modal -->
<div id="attributeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">Thêm thuộc tính mới</h3>
            <button onclick="closeAttributeModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="attributeForm" method="POST" action="{{ route('admin.attributes.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <input type="hidden" name="category_id" value="{{ $category->id }}">
            <input type="hidden" id="attributeId" name="attribute_id" value="">
            
            <div class="space-y-4">
                <div>
                    <label for="attribute_name" class="block text-sm font-medium text-gray-700">Tên thuộc tính *</label>
                    <input type="text" name="name" id="attribute_name" required
                           placeholder="VD: CPU, RAM, Màn hình..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>

                <div>
                    <label for="attribute_unit" class="block text-sm font-medium text-gray-700">Đơn vị (tùy chọn)</label>
                    <input type="text" name="unit" id="attribute_unit"
                           placeholder="VD: GB, inch, MHz..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="closeAttributeModal()" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Hủy
                </button>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                    <span id="submitButtonText">Thêm thuộc tính</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Attribute Modal Functions
function openAddAttributeModal() {
    document.getElementById('modalTitle').textContent = 'Thêm thuộc tính mới';
    document.getElementById('submitButtonText').textContent = 'Thêm thuộc tính';
    document.getElementById('attributeForm').action = '{{ route("admin.attributes.store") }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('attributeId').value = '';
    document.getElementById('attribute_name').value = '';
    document.getElementById('attribute_unit').value = '';
    document.getElementById('attributeModal').classList.remove('hidden');
}

function editAttribute(id, name, unit) {
    document.getElementById('modalTitle').textContent = 'Chỉnh sửa thuộc tính';
    document.getElementById('submitButtonText').textContent = 'Cập nhật';
    document.getElementById('attributeForm').action = '/admin/attributes/' + id;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('attributeId').value = id;
    document.getElementById('attribute_name').value = name;
    document.getElementById('attribute_unit').value = unit || '';
    document.getElementById('attributeModal').classList.remove('hidden');
}

function closeAttributeModal() {
    document.getElementById('attributeModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('attributeModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeAttributeModal();
    }
});

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
