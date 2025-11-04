@extends('admin.layouts.app')

@section('title', 'Chi tiết Sản phẩm Bán')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Chi tiết Sản phẩm Bán</h1>
            <p class="mt-1 text-sm text-gray-600">Xem thông tin chi tiết sản phẩm đang bán</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại
            </a>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
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
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h2 class="text-lg font-semibold text-gray-900">Thông tin sản phẩm</h2>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Tên sản phẩm (Marketing)</label>
                    <p class="mt-1 text-xl text-gray-900 font-bold">{{ $product->name }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Sản phẩm kho liên kết</label>
                        <a href="{{ route('admin.inventory.show', $product->inventoryItem->id) }}" class="mt-1 flex items-center text-blue-600 hover:text-blue-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span class="font-medium">{{ $product->inventoryItem->name }}</span>
                        </a>
                        <p class="text-xs text-gray-500 mt-1">SKU: {{ $product->inventoryItem->sku }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Danh mục</label>
                        <p class="mt-1">
                            <a href="{{ route('admin.categories.show', $product->inventoryItem->category->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                {{ $product->inventoryItem->category->name }}
                            </a>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 p-4 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg">
                    <div>
                        <label class="text-sm font-medium text-gray-600">Giá bán</label>
                        <p class="mt-1 text-2xl text-gray-900 font-bold">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
                    </div>
                    @if($product->discount_price)
                    <div>
                        <label class="text-sm font-medium text-gray-600">Giá khuyến mãi</label>
                        <p class="mt-1 text-2xl text-red-600 font-bold">{{ number_format($product->discount_price, 0, ',', '.') }} ₫</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Giảm giá</label>
                        <p class="mt-1 text-2xl text-green-600 font-bold">{{ number_format((($product->price - $product->discount_price) / $product->price) * 100, 0) }}%</p>
                    </div>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Số lượng hiển thị</label>
                        <p class="mt-1 text-lg font-bold {{ $product->stock > 10 ? 'text-green-600' : ($product->stock > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ number_format($product->stock) }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Giới hạn bán</label>
                        <p class="mt-1 text-lg font-bold text-gray-900">
                            {{ $product->max_stock ? number_format($product->max_stock) : 'Không giới hạn' }}
                        </p>
                    </div>
                </div>

                @if($product->description)
                <div>
                    <label class="text-sm font-medium text-gray-500">Mô tả chi tiết</label>
                    <p class="mt-1 text-base text-gray-900 whitespace-pre-line">{{ $product->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Product Attributes from Inventory -->
        @if($product->inventoryItem->attributeValues->count() > 0)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <h2 class="text-lg font-semibold text-gray-900">Thông số kỹ thuật</h2>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($product->inventoryItem->attributeValues as $attrValue)
                    <div class="flex items-center p-3 border border-purple-200 rounded-lg bg-gradient-to-r from-white to-purple-50">
                        <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-xs font-medium text-gray-500">{{ $attrValue->attribute->name }}</p>
                            <p class="text-base font-bold text-gray-900">
                                {{ $attrValue->value }}
                                @if($attrValue->attribute->unit)
                                    <span class="text-sm text-purple-600">{{ $attrValue->attribute->unit }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Product Images -->
        @if($product->images->count() > 0)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Hình ảnh sản phẩm ({{ $product->images->count() }})</h2>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($product->images->sortBy('display_order') as $image)
                    <div class="relative group">
                        <img src="{{ $image->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg shadow-md">
                        @if($image->is_main)
                        <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-xs font-bold">
                            Ảnh chính
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Status Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Trạng thái</h2>
            </div>
            <div class="px-6 py-4 space-y-3">
                <div>
                    <label class="text-xs font-medium text-gray-500">Trạng thái bán</label>
                    <p class="mt-1">
                        @if($product->status == 'active')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Đang bán
                            </span>
                        @elseif($product->status == 'draft')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Nháp
                            </span>
                        @elseif($product->status == 'inactive')
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Ngừng bán
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                Hết hàng
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500">Sản phẩm nổi bật</label>
                    <p class="mt-1">
                        @if($product->is_featured)
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                ⭐ Nổi bật
                            </span>
                        @else
                            <span class="text-sm text-gray-600">Không</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500">Thứ tự hiển thị</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $product->display_order }}</p>
                </div>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 shadow rounded-lg overflow-hidden text-white">
            <div class="px-6 py-4">
                <h2 class="text-lg font-semibold">Thống kê</h2>
            </div>
            <div class="px-6 py-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-90">Tồn kho</span>
                    <span class="text-2xl font-bold">{{ number_format($product->inventoryItem->quantity) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-90">Đang bán</span>
                    <span class="text-2xl font-bold">{{ number_format($product->stock) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-90">Hình ảnh</span>
                    <span class="text-2xl font-bold">{{ $product->images->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Timestamps Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Thông tin khác</h2>
            </div>
            <div class="px-6 py-4 space-y-3">
                @if($product->published_at)
                <div>
                    <label class="text-xs font-medium text-gray-500">Ngày công khai</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $product->published_at->format('d/m/Y H:i') }}</p>
                </div>
                @endif
                <div>
                    <label class="text-xs font-medium text-gray-500">Ngày tạo</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500">Cập nhật lần cuối</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $product->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500">ID</label>
                    <p class="mt-1 text-sm text-gray-900 font-mono">#{{ $product->id }}</p>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 space-y-2">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Chỉnh sửa
                </a>
                
                @if($product->status != 'active')
                <form action="{{ route('admin.products.publish', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Công khai
                    </button>
                </form>
                @else
                <form action="{{ route('admin.products.unpublish', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-white hover:bg-yellow-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                        Ẩn sản phẩm
                    </button>
                </form>
                @endif
                
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Xóa sản phẩm
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
