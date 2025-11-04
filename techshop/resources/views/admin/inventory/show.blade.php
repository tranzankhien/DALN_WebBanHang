@extends('admin.layouts.app')

@section('title', 'Chi tiết Sản phẩm Kho')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Chi tiết Sản phẩm Kho</h1>
            <p class="mt-1 text-sm text-gray-600">Xem thông tin chi tiết sản phẩm trong kho</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.inventory.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Quay lại
            </a>
            <a href="{{ route('admin.inventory.edit', $item->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
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
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h2 class="text-lg font-semibold text-gray-900">Thông tin cơ bản</h2>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Mã SKU</label>
                        <p class="mt-1 text-base text-gray-900 font-mono font-bold">{{ $item->sku }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Danh mục</label>
                        <p class="mt-1">
                            <a href="{{ route('admin.categories.show', $item->category->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                {{ $item->category->name }}
                            </a>
                        </p>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500">Tên sản phẩm</label>
                    <p class="mt-1 text-lg text-gray-900 font-semibold">{{ $item->name }}</p>
                </div>

                @if($item->brand)
                <div>
                    <label class="text-sm font-medium text-gray-500">Thương hiệu</label>
                    <p class="mt-1 text-base text-gray-900">{{ $item->brand }}</p>
                </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Giá nhập</label>
                        <p class="mt-1 text-xl text-gray-900 font-bold">{{ number_format($item->cost_price, 0, ',', '.') }} ₫</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Số lượng tồn kho</label>
                        <p class="mt-1 text-xl font-bold {{ $item->quantity > 10 ? 'text-green-600' : ($item->quantity > 0 ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ number_format($item->quantity) }}
                        </p>
                    </div>
                </div>

                @if($item->description)
                <div>
                    <label class="text-sm font-medium text-gray-500">Mô tả</label>
                    <p class="mt-1 text-base text-gray-900">{{ $item->description }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Product Attributes Card -->
        @if($item->attributeValues->count() > 0)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <h2 class="text-lg font-semibold text-gray-900">Thông tin chi tiết sản phẩm</h2>
            </div>
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($item->attributeValues as $attrValue)
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

        <!-- Related Products Card -->
        @if($item->products->count() > 0)
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Sản phẩm bán liên quan ({{ $item->products->count() }})</h2>
            </div>
            <div class="px-6 py-4">
                <div class="space-y-3">
                    @foreach($item->products as $product)
                    <a href="{{ route('admin.products.show', $product->id) }}" class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-center flex-1">
                            <div class="flex-shrink-0 h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-semibold text-gray-900">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">Giá: {{ number_format($product->price) }} ₫ - Stock: {{ $product->stock }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : 
                               ($product->status == 'draft' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Statistics Card -->
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 shadow rounded-lg overflow-hidden text-white">
            <div class="px-6 py-4">
                <h2 class="text-lg font-semibold">Thống kê</h2>
            </div>
            <div class="px-6 py-4 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-90">Số lượng tồn</span>
                    <span class="text-2xl font-bold">{{ number_format($item->quantity) }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-90">Sản phẩm bán</span>
                    <span class="text-2xl font-bold">{{ $item->products->count() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm opacity-90">Giao dịch</span>
                    <span class="text-2xl font-bold">{{ $item->transactions->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-900">Trạng thái kho</h2>
            </div>
            <div class="px-6 py-4 space-y-3">
                <div>
                    <label class="text-xs font-medium text-gray-500">Tình trạng</label>
                    <p class="mt-1">
                        @if($item->quantity > 10)
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Còn hàng
                            </span>
                        @elseif($item->quantity > 0)
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Sắp hết
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Hết hàng
                            </span>
                        @endif
                    </p>
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
                    <label class="text-xs font-medium text-gray-500">Ngày nhập kho</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $item->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500">Cập nhật lần cuối</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $item->updated_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="text-xs font-medium text-gray-500">ID</label>
                    <p class="mt-1 text-sm text-gray-900 font-mono">#{{ $item->id }}</p>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 space-y-2">
                <a href="{{ route('admin.inventory.edit', $item->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Chỉnh sửa
                </a>
                @if($item->products->count() == 0)
                <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi kho?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Xóa khỏi kho
                    </button>
                </form>
                @else
                <div class="p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                    <p class="text-xs text-yellow-800">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Không thể xóa vì đã có sản phẩm bán liên kết
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
