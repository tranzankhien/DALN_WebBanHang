@extends('admin.layouts.app')

@section('title', 'Chi tiết Danh mục')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Chi tiết Danh mục</h1>
            <p class="mt-1 text-sm text-gray-600">Xem thông tin chi tiết danh mục</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại
            </a>
            <a href="{{ route('admin.categories.edit', $category->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Chỉnh sửa
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Info Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Thông tin cơ bản</h2>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tên danh mục</label>
                        <p class="mt-1 text-base text-gray-900 font-semibold">{{ $category->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Slug (URL)</label>
                        <p class="mt-1 text-base text-gray-900 font-mono text-sm">{{ $category->slug }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Trạng thái</label>
                        <p class="mt-1">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                {{ $category->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $category->status == 'active' ? 'Hoạt động' : 'Không hoạt động' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Thứ tự hiển thị</label>
                        <p class="mt-1 text-base text-gray-900">{{ $category->display_order }}</p>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500">Mô tả</label>
                    <p class="mt-1 text-base text-gray-900">{{ $category->description ?: 'Chưa có mô tả' }}</p>
                </div>

                @if($category->image_url)
                <div>
                    <label class="text-sm font-medium text-gray-500">Hình ảnh</label>
                    <div class="mt-2">
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-48 w-auto rounded-lg shadow-md object-cover">
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Children Categories Card -->
        @if($category->children->count() > 0)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Danh mục con ({{ $category->children->count() }})</h2>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($category->children as $child)
                    <a href="{{ route('admin.categories.show', $child->id) }}" class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-900">{{ $child->name }}</span>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full {{ $child->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $child->status == 'active' ? 'Hoạt động' : 'Dừng' }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Attributes Management Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Thuộc tính sản phẩm ({{ $category->productAttributes->count() }})</h2>
                        <p class="mt-1 text-sm text-gray-600">Các trường thông tin sẽ hiển thị khi thêm sản phẩm thuộc danh mục này</p>
                    </div>
                    <a href="{{ route('admin.categories.edit', $category->id) }}" 
                       class="inline-flex items-center px-3 py-1.5 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700 transition" style="background-color: #001faaff;">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Chỉnh sửa thuộc tính
                    </a>
                </div>
            </div>
            <div class="px-6 py-4">
                <!-- Example Info Box -->
                <!-- <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-900">Ví dụ cho danh mục "{{ $category->name }}":</p>
                            <p class="mt-1 text-xs text-blue-700">
                                @if(stripos($category->name, 'màn hình') !== false || stripos($category->name, 'monitor') !== false)
                                    Thêm các thuộc tính: <strong>Hãng</strong>, <strong>Kích thước</strong> (inch), <strong>Độ phân giải</strong>, <strong>Tần số quét</strong> (Hz)
                                @elseif(stripos($category->name, 'tai nghe') !== false || stripos($category->name, 'headphone') !== false)
                                    Thêm các thuộc tính: <strong>Hãng</strong>, <strong>Loại kết nối</strong>, <strong>Chống ồn</strong>
                                @elseif(stripos($category->name, 'bàn phím') !== false || stripos($category->name, 'keyboard') !== false)
                                    Thêm các thuộc tính: <strong>Hãng</strong>, <strong>Loại switch</strong>, <strong>Kết nối</strong>, <strong>LED</strong>
                                @else
                                    Thêm các thuộc tính phù hợp với loại sản phẩm. Ví dụ: <strong>Hãng</strong>, <strong>Màu sắc</strong>, <strong>Kích thước</strong>
                                @endif
                            </p>
                        </div>
                    </div>
                </div> -->

                @if($category->productAttributes->count() > 0)
                <div class="space-y-3">
                    @foreach($category->productAttributes as $attribute)
                    <div class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg hover:border-purple-300 transition bg-gradient-to-r from-white to-purple-50">
                        <div class="flex items-center flex-1">
                            <div class="flex-shrink-0 h-12 w-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-base font-bold text-gray-900">{{ $attribute->name }}</p>
                                @if($attribute->unit)
                                <p class="text-sm text-purple-600 font-medium">Đơn vị: {{ $attribute->unit }}</p>
                                @endif
                                <p class="text-xs text-gray-500 mt-1">
                                    Trường này sẽ xuất hiện khi thêm sản phẩm thuộc "{{ $category->name }}"
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <button onclick="editAttribute({{ $attribute->id }}, '{{ $attribute->name }}', '{{ $attribute->unit }}')" class="p-2 text-blue-600 hover:bg-blue-50 rounded-md transition" title="Chỉnh sửa">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <form action="{{ route('admin.attributes.destroy', $attribute->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thuộc tính này?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-md transition" title="Xóa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <h3 class="mt-4 text-base font-semibold text-gray-900">Chưa có thuộc tính nào</h3>
                    <p class="mt-2 text-sm text-gray-600 max-w-md mx-auto">
                        Thêm các thuộc tính để tạo form nhập liệu chi tiết khi thêm sản phẩm.<br>
                        Ví dụ: Hãng, Kích thước, Màu sắc, v.v.
                    </p>
                    <button onclick="openAddAttributeModal()" class="mt-4 inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Thêm thuộc tính đầu tiên
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Products Card -->
        @if($category->inventoryItems->count() > 0)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Sản phẩm ({{ $category->inventoryItems->count() }})</h2>
            </div>
            <div class="px-6 py-4">
                <div class="space-y-3">
                    @foreach($category->inventoryItems->take(5) as $item)
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">{{ $item->sku }}</p>
                                <p class="text-xs text-gray-500">Số lượng: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">{{ number_format($item->quantity) }}</span>
                    </div>
                    @endforeach
                    @if($category->inventoryItems->count() > 5)
                    <p class="text-sm text-center text-gray-500 pt-2">
                        Và {{ $category->inventoryItems->count() - 5 }} sản phẩm khác...
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Statistics Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 shadow rounded-lg overflow-hidden text-white">
            <div class="px-6 py-4">
                <h2 class="text-lg font-semibold">Thống kê</h2>
            </div>
            <div class="px-6 py-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-90">Thuộc tính</span>
                    <span class="text-2xl font-bold">{{ $category->productAttributes->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-90">Sản phẩm</span>
                    <span class="text-2xl font-bold">{{ $category->inventoryItems->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-90">Tổng số lượng</span>
                    <span class="text-2xl font-bold">{{ number_format($category->inventoryItems->sum('stock_quantity')) }}</span>
                </div>
            </div>
        </div>

        <!-- Timestamps Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Thông tin khác</h2>
            </div>
            <div class="px-6 py-4 space-y-3">
                <div>
                    <label class="text-xs font-medium text-gray-500">Ngày tạo</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500">Cập nhật lần cuối</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500">ID</label>
                    <p class="mt-1 text-sm text-gray-900 font-mono">#{{ $category->id }}</p>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 space-y-2">
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Chỉnh sửa
                </a>
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Xóa danh mục
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
