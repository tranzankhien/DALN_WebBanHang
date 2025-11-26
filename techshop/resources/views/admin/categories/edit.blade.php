@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa Danh mục')

@section('content')
<!-- Background with solid color -->
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 flex items-center" style="font-size: 30px; font-weight: 800; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                        Chỉnh sửa Danh Mục
                    </h1>
                </div>
                <a href="{{ route('admin.categories.index') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg font-semibold text-white hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5" style="border-radius: 30px; background-color: #000000ff;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-semibold">Quay lại</span>
                </a>
            </div>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" id="categoryForm">
                @csrf
                @method('PUT')
                
                <!-- Header Section -->
                <div class="px-8 py-6 border-b-4 border-blue-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-2xl">
                            <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-2xl font-bold">Thông Tin Danh Mục</h2>
                            <p class="text-black-100 text-sm mt-1">Cập nhật thông tin cho danh mục {{ $category->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Category Name -->
                        <div class="group">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <span class="w-1 h-6 bg-blue-600 rounded-full mr-2"></span>
                                Tên danh mục <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $category->name) }}" 
                                       required
                                       placeholder="Nhập tên danh mục..."
                                       class="block w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all text-gray-800 font-medium placeholder-gray-400 @error('name') border-red-500 @enderror">
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="group">
                            <label for="slug" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <span class="w-1 h-6 bg-purple-600 rounded-full mr-2"></span>
                                Slug (URL) <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="mt-1 flex rounded-xl shadow-sm overflow-hidden border-2 border-gray-200 focus-within:border-blue-500 transition-all">
                                <span class="inline-flex items-center px-4 bg-gray-50 text-gray-500 text-sm font-medium border-r-2 border-gray-200">
                                    techshop.com/
                                </span>
                                <input type="text" 
                                       name="slug" 
                                       id="slug" 
                                       value="{{ old('slug', $category->slug) }}" 
                                       required
                                       class="flex-1 block w-full px-4 py-3 border-0 focus:ring-0 text-gray-800 font-medium placeholder-gray-400">
                            </div>
                            @error('slug')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                <span class="w-1 h-6 bg-green-600 rounded-full mr-2"></span>
                                Trạng thái <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex items-center p-4 cursor-pointer border-2 rounded-xl transition-all {{ old('status', $category->status) == 'active' ? 'border-green-500 bg-gradient-to-br from-green-50 to-emerald-50 scale-105' : 'border-gray-200 hover:border-green-200' }}">
                                    <input type="radio" name="status" value="active" class="sr-only" {{ old('status', $category->status) == 'active' ? 'checked' : '' }} onchange="updateStatusStyle(this)">
                                    <div class="w-6 h-6 border-2 rounded-full mr-3 flex items-center justify-center transition-colors {{ old('status', $category->status) == 'active' ? 'border-green-500' : 'border-gray-300' }}">
                                        <div class="w-3 h-3 rounded-full bg-green-500 {{ old('status', $category->status) == 'active' ? '' : 'hidden' }}"></div>
                                    </div>
                                    <span class="font-bold text-gray-700">Hoạt động</span>
                                </label>
                                
                                <label class="relative flex items-center p-4 cursor-pointer border-2 rounded-xl transition-all {{ old('status', $category->status) == 'inactive' ? 'border-red-500 bg-gradient-to-br from-red-50 to-pink-50 scale-105' : 'border-gray-200 hover:border-red-200' }}">
                                    <input type="radio" name="status" value="inactive" class="sr-only" {{ old('status', $category->status) == 'inactive' ? 'checked' : '' }} onchange="updateStatusStyle(this)">
                                    <div class="w-6 h-6 border-2 rounded-full mr-3 flex items-center justify-center transition-colors {{ old('status', $category->status) == 'inactive' ? 'border-red-500' : 'border-gray-300' }}">
                                        <div class="w-3 h-3 rounded-full bg-red-500 {{ old('status', $category->status) == 'inactive' ? '' : 'hidden' }}"></div>
                                    </div>
                                    <span class="font-bold text-gray-700">Ẩn</span>
                                </label>
                            </div>
                        </div>

                        <!-- Display Order -->
                        <div class="group">
                            <label for="display_order" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <span class="w-1 h-6 bg-orange-500 rounded-full mr-2"></span>
                                Thứ tự hiển thị
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="display_order" 
                                       id="display_order" 
                                       value="{{ old('display_order', $category->display_order) }}" 
                                       min="0"
                                       class="block w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all text-gray-800 font-medium">
                            </div>
                        </div>

                        <!-- Image URL -->
                        <div class="group">
                            <label for="image_url" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <span class="w-1 h-6 bg-pink-500 rounded-full mr-2"></span>
                                URL ảnh đại diện
                            </label>
                            <div class="relative">
                                <input type="url" 
                                       name="image_url" 
                                       id="image_url" 
                                       value="{{ old('image_url', $category->image_url) }}"
                                       placeholder="https://example.com/image.jpg"
                                       class="block w-full pl-4 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all text-gray-800 font-medium"
                                       onchange="previewImage(this)">
                            </div>
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div class="mt-8 {{ $category->image_url ? '' : 'hidden' }}" id="imagePreviewContainer">
                        <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Xem trước ảnh
                        </label>
                        <div class="relative inline-block group">
                            <img id="imagePreview" 
                                 src="{{ $category->image_url }}" 
                                 alt="Preview" 
                                 class="h-48 w-auto rounded-2xl shadow-2xl object-cover border-4 border-white ring-4 ring-purple-100 transition-transform group-hover:scale-105">
                            <button type="button" 
                                    onclick="removeImagePreview()"
                                    class="absolute -top-3 -right-3 bg-red-500 text-white p-2 rounded-full shadow-lg hover:bg-red-600 transition-all transform hover:scale-110 opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Attributes Section -->
                    <div class="mt-10 border-t-4 border-dashed border-purple-200 pt-8">
                        <div class="bg-purple-50 rounded-3xl p-8 border-3 border-purple-300 shadow-xl bg-gray-50" style="border-radius: 20px;">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <span class="bg-purple-600 text-white p-2 rounded-lg mr-3 shadow-md">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                            </svg>
                                        </span>
                                        Thuộc tính sản phẩm
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1 ml-12">Định nghĩa các thông số kỹ thuật cho sản phẩm thuộc danh mục này</p>
                                </div>
                                <button type="button" 
                                        onclick="addAttributeRow()"
                                        class="inline-flex items-center px-5 py-2.5 bg-purple-600 border border-transparent rounded-xl font-bold text-white hover:bg-purple-700 focus:outline-none focus:ring-4 focus:ring-purple-200 transition-all shadow-lg hover:shadow-purple-500/30 transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Thêm thuộc tính
                                </button>
                            </div>

                            <div id="attributes-container" class="space-y-4">
                                <!-- Existing Attributes -->
                                @foreach($category->productAttributes as $index => $attribute)
                                <div class="attribute-row bg-white rounded-2xl p-5 border-3 border-purple-300 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1" data-index="{{ $index + 1 }}">
                                    <input type="hidden" name="attributes[{{ $index + 1 }}][id]" value="{{ $attribute->id }}">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 mt-3">
                                            <div class="w-10 h-10 rounded-xl bg-purple-600 flex items-center justify-center shadow-lg">
                                                <span class="text-black font-black text-base">{{ $index + 1 }}</span>
                                            </div>
                                        </div>
                                        <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <!-- Attribute Name -->
                                            <div>
                                                <label class="block text-xs font-bold text-gray-700 mb-2 flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                    </svg>
                                                    Tên thuộc tính <span class="text-red-500">*</span>
                                                </label>
                                                <input type="text" 
                                                       name="attributes[{{ $index + 1 }}][name]" 
                                                       value="{{ $attribute->name }}"
                                                       required
                                                       class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all font-medium">
                                            </div>
                                            
                                            <!-- Unit -->
                                            <div>
                                                <label class="block text-xs font-bold text-gray-700 mb-2 flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                                    </svg>
                                                    Đơn vị <span class="text-gray-400 text-xs">(tuỳ chọn)</span>
                                                </label>
                                                <input type="text" 
                                                       name="attributes[{{ $index + 1 }}][unit]" 
                                                       value="{{ $attribute->unit }}"
                                                       class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all font-medium">
                                            </div>
                                            
                                            <!-- Input Type -->
                                            <div>
                                                <label class="block text-xs font-bold text-gray-700 mb-2 flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Kiểu nhập liệu
                                                </label>
                                                <select name="attributes[{{ $index + 1 }}][input_type]"
                                                        class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all font-medium">
                                                    <option value="text" {{ $attribute->input_type == 'text' ? 'selected' : '' }}>📝 Text (Văn bản)</option>
                                                    <option value="number" {{ $attribute->input_type == 'number' ? 'selected' : '' }}>🔢 Number (Số)</option>
                                                    <option value="select" {{ $attribute->input_type == 'select' ? 'selected' : '' }}>📋 Select (Lựa chọn)</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Remove Button -->
                                        <button type="button" 
                                                onclick="removeAttributeRow({{ $index + 1 }})"
                                                class="flex-shrink-0 mt-2 p-2.5 bg-red-500 text-white hover:bg-red-600 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-110"
                                                title="Xóa thuộc tính">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Hidden flag to indicate attributes section was submitted -->
                            <input type="hidden" name="attributes_submitted_flag" value="1">
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <span class="w-1 h-6 bg-gray-500 rounded-full mr-2"></span>
                            Mô tả
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  placeholder="Nhập mô tả chi tiết về danh mục..."
                                  class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all px-4 py-3 text-gray-800 placeholder-gray-400 resize-none">{{ old('description', $category->description) }}</textarea>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-8 py-6 border-t-2 border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-500 font-medium">
                        <span class="text-blue-600">Lưu ý:</span> Các trường có dấu <span class="text-red-500">*</span> là bắt buộc
                    </div>
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="px-6 py-3 border-2 border-gray-200 rounded-xl text-gray-700 font-bold hover:bg-gray-50 hover:border-gray-300 transition-all">
                            Hủy bỏ
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-white hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all shadow-lg hover:shadow-blue-500/30 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Cập nhật
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let attributeCount = {{ $category->productAttributes->count() }};

// Add attribute row
function addAttributeRow() {
    attributeCount++;
    const container = document.getElementById('attributes-container');
    const row = document.createElement('div');
    row.className = 'attribute-row bg-white rounded-2xl p-5 border-3 border-purple-300 shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-1';
    row.setAttribute('data-index', attributeCount);
    
    row.innerHTML = `
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 mt-3">
                <div class="w-10 h-10 rounded-xl bg-purple-600 flex items-center justify-center shadow-lg">
                    <span class="text-black font-black text-base">${attributeCount}</span>
                </div>
            </div>
            <div class="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Attribute Name -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Tên thuộc tính <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="attributes[${attributeCount}][name]" 
                           placeholder="VD: Kích cỡ, CPU..."
                           required
                           class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all font-medium">
                </div>
                
                <!-- Unit -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                        </svg>
                        Đơn vị <span class="text-gray-400 text-xs">(tuỳ chọn)</span>
                    </label>
                    <input type="text" 
                           name="attributes[${attributeCount}][unit]" 
                           placeholder="VD: inch, GB, Hz..."
                           class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all font-medium">
                </div>
                
                <!-- Input Type -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2 flex items-center">
                        <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Kiểu nhập liệu
                    </label>
                    <select name="attributes[${attributeCount}][input_type]"
                            class="w-full px-3 py-2.5 text-sm border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-4 focus:ring-green-100 transition-all font-medium">
                        <option value="text">📝 Text (Văn bản)</option>
                        <option value="number">🔢 Number (Số)</option>
                        <option value="select">📋 Select (Lựa chọn)</option>
                    </select>
                </div>
            </div>
            
            <!-- Remove Button -->
            <button type="button" 
                    onclick="removeAttributeRow(${attributeCount})"
                    class="flex-shrink-0 mt-2 p-2.5 bg-red-500 text-white hover:bg-red-600 rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-110"
                    title="Xóa thuộc tính">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    `;
    
    container.appendChild(row);
    
    // Animate entrance
    setTimeout(() => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(-10px) scale(0.95)';
        row.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0) scale(1)';
        }, 10);
    }, 0);
}

// Remove attribute row
function removeAttributeRow(index) {
    const row = document.querySelector(`[data-index="${index}"]`);
    if (row) {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        setTimeout(() => {
            row.remove();
            // Renumber remaining rows
            const rows = document.querySelectorAll('.attribute-row');
            rows.forEach((r, i) => {
                const number = r.querySelector('.w-10 span');
                if (number) number.textContent = i + 1;
            });
        }, 300);
    }
}

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
        const dot = label.querySelector('.w-3');
        const circle = label.querySelector('.w-6');
        
        if (radio.checked) {
            if (radio.value === 'active') {
                label.classList.add('border-green-500', 'bg-gradient-to-br', 'from-green-50', 'to-emerald-50', 'scale-105');
                label.classList.remove('border-gray-200', 'hover:border-green-200', 'border-red-500', 'from-red-50', 'to-pink-50');
                circle.classList.remove('border-gray-300', 'border-red-500');
                circle.classList.add('border-green-500');
                dot.classList.remove('hidden', 'bg-red-500');
                dot.classList.add('bg-green-500');
            } else {
                label.classList.add('border-red-500', 'bg-gradient-to-br', 'from-red-50', 'to-pink-50', 'scale-105');
                label.classList.remove('border-gray-200', 'hover:border-red-200', 'border-green-500', 'from-green-50', 'to-emerald-50');
                circle.classList.remove('border-gray-300', 'border-green-500');
                circle.classList.add('border-red-500');
                dot.classList.remove('hidden', 'bg-green-500');
                dot.classList.add('bg-red-500');
            }
        } else {
            label.classList.remove('border-green-500', 'from-green-50', 'to-emerald-50', 'border-red-500', 'from-red-50', 'to-pink-50', 'scale-105');
            label.classList.add('border-gray-200');
            circle.classList.remove('border-green-500', 'border-red-500');
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
    
    // Validate attributes if any
    const attributeInputs = document.querySelectorAll('[name^="attributes"][name$="[name]"]');
    for (let input of attributeInputs) {
        if (input.value.trim() === '') {
            e.preventDefault();
            alert('Vui lòng nhập tên cho tất cả các thuộc tính hoặc xóa bỏ!');
            input.focus();
            return false;
        }
    }
});
</script>
@endpush
@endsection
