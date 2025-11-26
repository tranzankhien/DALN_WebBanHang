@extends('admin.layouts.app')

@section('title', 'Thêm danh mục')

@section('content')
<!-- Background with solid color -->
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 flex items-center" style="font-size: 30px; font-weight: 800; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                        <!-- <svg class="w-10 h-10 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                        </svg> -->
                        Thêm Danh Mục Mới
                    </h1>
                    <!-- <p class="mt-2 text-base text-gray-600 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tạo danh mục sản phẩm mới cho cửa hàng của bạn
                    </p> -->
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
            <form action="{{ route('admin.categories.store') }}" method="POST" id="categoryForm">
                @csrf
                
                <!-- Header Section -->
                <div class="px-8 py-6 border-b-4 border-blue-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-white/20 rounded-2xl">
                            <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-2xl font-bold">Thông Tin Danh Mục</h2>
                            <p class="text-black-100 text-sm mt-1">Điền đầy đủ thông tin để tạo danh mục mới</p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-8">
                <div class="px-8 py-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Category Name -->
                        <div class="group">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Tên danh mục <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}" 
                                       required
                                       placeholder="VD: Điện thoại, Laptop, Màn hình..."
                                       class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-purple-500 focus:ring-4 focus:ring-purple-100 transition-all px-4 py-3 text-gray-800 placeholder-gray-400 
                                              @error('name') border-red-500 @enderror">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Tên hiển thị của danh mục trên website
                            </p>
                        </div>

                        <!-- Slug -->
                        <div class="group">
                            <label for="slug" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                                Slug (URL)
                            </label>
                            <div class="mt-1 flex rounded-xl shadow-sm overflow-hidden border-2 border-gray-200 focus-within:border-blue-500 transition-all">
                                <span class="inline-flex items-center px-4 bg-blue-50 text-blue-700 text-sm font-semibold">
                                    /category/
                                </span>
                                <input type="text" 
                                       name="slug" 
                                       id="slug" 
                                       value="{{ old('slug') }}"
                                       placeholder="tu-dong-tao"
                                       class="flex-1 block w-full border-0 focus:ring-0 px-4 py-3 text-gray-800 placeholder-gray-400">
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Tự động tạo từ tên danh mục
                            </p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Trạng thái <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4 " >
                                <label class="relative flex items-center p-4 cursor-pointer border-3 border-green-500 bg-green-50 rounded-2xl transition-all hover:shadow-lg transform hover:-translate-y-1">
                                    <input type="radio" 
                                           name="status" 
                                           value="active" 
                                           checked
                                           class="sr-only"
                                           onchange="updateStatusStyle(this)">
                                    <div class="flex items-center w-full">
                                        <div class="w-6 h-6 rounded-full border-3 border-green-500 flex items-center justify-center mr-3 bg-white">
                                            <div class="w-3 h-3 rounded-full bg-green-900"></div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-sm text-gray-900">Hoạt động</p>
                                            <p class="text-xs text-green-600">✓ Hiển thị công khai</p>
                                        </div>
                                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </label>
                                <label class="relative flex items-center p-4 cursor-pointer border-3 border-gray-300 bg-gray-50 rounded-2xl transition-all hover:shadow-lg hover:border-red-400 transform hover:-translate-y-1">
                                    <input type="radio" 
                                           name="status" 
                                           value="inactive"
                                           class="sr-only"
                                           onchange="updateStatusStyle(this)">
                                    <div class="flex items-center w-full">
                                        <div class="w-6 h-6 rounded-full border-3 border-gray-300 flex items-center justify-center mr-3 bg-white">
                                            <div class="w-3 h-3 rounded-full bg-red-500 hidden"></div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-bold text-sm text-gray-900">Tạm ẩn</p>
                                            <p class="text-xs text-gray-500">✕ Ẩn khỏi trang web</p>
                                        </div>
                                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Display Order -->
                        <div class="group">
                            <label for="display_order" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                                Thứ tự hiển thị
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       name="display_order" 
                                       id="display_order" 
                                       value="{{ old('display_order', 0) }}" 
                                       min="0"
                                       class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all px-4 py-3 text-gray-800">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                                Số nhỏ hơn sẽ hiển thị trước
                            </p>
                        </div>

                        
                        <!-- Image URL -->
                        <div class="group">
                            <label for="image_url" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                URL ảnh đại diện
                            </label>
                            <div class="relative">
                                <input type="url" 
                                       name="image_url" 
                                       id="image_url" 
                                       value="{{ old('image_url') }}"
                                       placeholder="https://example.com/image.jpg"
                                       class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-pink-500 focus:ring-4 focus:ring-pink-100 transition-all px-4 py-3 text-gray-800 placeholder-gray-400"
                                       onchange="previewImage(this)">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-pink-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Link đầy đủ đến hình ảnh đại diện
                            </p>
                        </div>
                    </div>


                    <!-- Image Preview -->
                    <div class="mt-8 hidden" id="imagePreviewContainer">
                        <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Xem trước ảnh
                        </label>
                        <div class="relative inline-block group">
                            <img id="imagePreview" 
                                 src="" 
                                 alt="Preview" 
                                 class="h-48 w-auto rounded-2xl shadow-2xl object-cover border-4 border-white ring-4 ring-purple-100 transition-transform group-hover:scale-105">
                            <button type="button" 
                                    onclick="removeImagePreview()" 
                                    class="absolute -top-3 -right-3 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-full p-2 hover:from-red-600 hover:to-pink-600 transition-all shadow-lg hover:shadow-xl transform hover:scale-110">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Attributes Section -->
                    <div class="mt-10 border-t-4 border-dashed border-purple-200 pt-8" >
                        <div class="bg-purple-50 rounded-3xl p-8 border-3 border-purple-300 shadow-xl bg-gray-50" style="border-radius: 20px;">
                            <div class="flex items-center justify-between mb-6" >
                                <div class="flex items-center" style="gap: 12px; margin-top: 8px;">
                                    <div class="p-3 bg-purple-600 rounded-2xl shadow-lg" >
                                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-2xl font-extrabold text-purple-900" style="font-size: 24px; font-weight: 800; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                            Thuộc Tính Sản Phẩm
                                        </h3>
                                        <p class="text-sm text-purple-700 mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Thêm các thuộc tính kỹ thuật cho danh mục
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Attributes Container -->
                            <div id="attributes-container" class="space-y-4 mb-6">
                                <!-- Attribute rows will be added here -->
                            </div>

                            <!-- Add Attribute Button -->
                            <button type="button" 
                                    onclick="addAttributeRow()"
                                    class="w-full inline-flex bg-blue-600 items-center justify-center px-6 py-4 hover:bg-blue-700 text-white rounded-2xl transition-all shadow-lg hover:shadow-2xl transform hover:-translate-y-1 font-bold text-lg" style="border-radius: 20px;">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Thêm Thuộc Tính Mới
                            </button>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-8">
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                            Mô tả danh mục
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  placeholder="Nhập mô tả chi tiết về danh mục (tùy chọn)..."
                                  class="mt-1 block w-full rounded-xl border-2 border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all px-4 py-3 text-gray-800 placeholder-gray-400 resize-none">{{ old('description') }}</textarea>
                        <p class="mt-2 text-xs text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            Mô tả giúp khách hàng hiểu rõ hơn về danh mục
                        </p>
                    </div>

                    
                </div>

                <!-- Form Actions -->
                <div class="px-8 py-6 border-t-2 border-gray-200 flex items-center justify-between">
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="inline-flex items-center px-6 py-3 border-2 border-gray-400 rounded-xl text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-500 transition-all shadow-md hover:shadow-lg font-semibold transform hover:-translate-y-0.5" style="border-radius: 30px;">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Hủy bỏ
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg font-semibold text-white hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5" style="border-radius: 30px; background-color: #000000ff;">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Lưu Danh Mục
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let attributeCount = 0;

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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
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
                const number = r.querySelector('.w-8 span');
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
                label.classList.remove('border-gray-300', 'border-red-500', 'from-gray-50', 'to-slate-50', 'from-red-50', 'to-pink-50');
                circle.classList.remove('border-gray-300', 'border-red-500');
                circle.classList.add('border-green-500');
                dot.classList.remove('hidden', 'bg-red-500');
                dot.classList.add('bg-green-500');
            } else {
                label.classList.add('border-red-500', 'bg-gradient-to-br', 'from-red-50', 'to-pink-50', 'scale-105');
                label.classList.remove('border-gray-300', 'border-green-500', 'from-gray-50', 'to-slate-50', 'from-green-50', 'to-emerald-50');
                circle.classList.remove('border-gray-300', 'border-green-500');
                circle.classList.add('border-red-500');
                dot.classList.remove('hidden', 'bg-green-500');
                dot.classList.add('bg-red-500');
            }
        } else {
            label.classList.remove('border-green-500', 'from-green-50', 'to-emerald-50', 'border-red-500', 'from-red-50', 'to-pink-50', 'scale-105');
            label.classList.add('border-gray-300', 'from-gray-50', 'to-slate-50');
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
