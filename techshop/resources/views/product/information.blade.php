<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $product->name }} — TechShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50">
    <!-- Header / Navigation -->
    @include('layouts.navigation')
    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Trang chủ</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                @php $cat = optional($product->inventoryItem)->category; @endphp
                @if($cat && $cat->id)
                <a href="{{ route('categoryProducts', $cat->id) }}" class="hover:text-blue-600">{{ $cat->name }}</a>
                @else
                <span class="text-gray-600">{{ optional($product->inventoryItem->category)->name ?? 'Sản phẩm' }}</span>
                @endif
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-400">{{ $product->name }}</span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Product Details Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 bg-white rounded-lg shadow-lg p-6">
            <!-- Left: Image Gallery with Navigation Arrows -->
            <div class="relative">
                <div class="relative bg-white rounded-lg overflow-hidden border-2 border-gray-200">
                    @php
                    $images = $product->images;
                    $imageArray = $images->values()->all();
                    $mainImageIndex = 0;
                    foreach($imageArray as $index => $img) {
                    if($img->is_main) {
                    $mainImageIndex = $index;
                    break;
                    }
                    }
                    @endphp

                    @if(count($imageArray) > 0)
                    <!-- Main Image -->
                    <div class="relative h-[500px] flex items-center justify-center bg-white">
                        <img id="main-image"
                            src="{{ $imageArray[$mainImageIndex]->image_url ?? 'https://cdn-icons-png.flaticon.com/512/679/679720.png' }}"
                            alt="{{ $product->name }}" class="product-auto-fit max-h-full max-w-full object-contain p-4"
                            data-fallback="https://cdn-icons-png.flaticon.com/512/679/679720.png"
                            onerror="this.onerror=null;this.src=this.dataset.fallback || 'https://cdn-icons-png.flaticon.com/512/679/679720.png'">

                        <!-- Navigation Arrows -->
                        @if(count($imageArray) > 1)
                        <button onclick="previousImage()"
                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 rounded-full p-3 shadow-lg transition-all hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button onclick="nextImage()"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 rounded-full p-3 shadow-lg transition-all hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                        @endif
                    </div>

                    <!-- Thumbnail Images -->
                    @if(count($imageArray) > 1)
                    <div class="flex gap-2 p-4 bg-gray-50 overflow-x-auto">
                        @foreach($imageArray as $index => $img)
                        <button type="button" onclick="changeImage({{ $index }})"
                            class="flex-shrink-0 border-2 rounded-lg overflow-hidden hover:border-blue-500 transition thumbnail-btn {{ $index == $mainImageIndex ? 'border-blue-500' : 'border-gray-300' }}"
                            data-index="{{ $index }}">
                            <img src="{{ $img->image_url ?? 'https://cdn-icons-png.flaticon.com/512/679/679720.png' }}"
                                class="product-auto-fit w-20 h-20 object-contain" alt=""
                                data-fallback="https://cdn-icons-png.flaticon.com/512/679/679720.png"
                                onerror="this.onerror=null;this.src=this.dataset.fallback || 'https://cdn-icons-png.flaticon.com/512/679/679720.png'">
                        </button>
                        @endforeach
                    </div>
                    @endif
                    @else
                    <div class="h-[500px] flex items-center justify-center text-gray-300">
                        <div class="text-center">
                            <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <p class="mt-2">Không có ảnh</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right: Product Information -->
            <div class="space-y-6">
                <!-- Product Title -->
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $product->name }}</h1>
                    <div class="flex items-center gap-4 mt-3 text-sm">
                        <div class="flex items-center gap-1 text-yellow-500">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                <path
                                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                            </svg>
                            <span class="text-gray-700 font-medium">4.8</span>
                            <span class="text-gray-500">({{ rand(100, 999) }} đánh giá)</span>
                        </div>
                        <span class="text-gray-400">|</span>
                        <span class="text-gray-600">Đã bán: {{ rand(50, 500) }}</span>
                    </div>
                </div>

                <!-- Category -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-4 border border-blue-200">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                            </path>
                        </svg>
                        <span class="font-semibold text-gray-700">Danh mục:</span>
                        <span class="px-3 py-1 bg-blue-600 text-white rounded-full font-bold text-sm shadow-md">
                            {{ optional($product->inventoryItem->category)->name ?? 'Chưa phân loại' }}
                        </span>
                    </div>
                </div>

                <!-- Product Attributes / Specifications -->
                @if(isset($product->inventoryItem->attributeValues) && $product->inventoryItem->attributeValues->count()
                > 0)
                <div class="bg-white rounded-lg border-2 border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-600 to-blue-600 px-4 py-3">
                        <h3 class="font-bold text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                            Thông số kỹ thuật
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($product->inventoryItem->attributeValues as $index => $av)
                        <div
                            class="flex items-center px-4 py-3 hover:bg-gray-50 transition {{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                            <div class="flex-1 flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-gradient-to-r from-purple-500 to-blue-500"></div>
                                <span
                                    class="font-semibold text-gray-700 min-w-[120px]">{{ $av->attribute->name }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-900 font-bold text-lg">{{ $av->value }}</span>
                                @if($av->attribute->unit)
                                <span class="text-gray-500 text-sm font-medium">{{ $av->attribute->unit }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <!-- No Attributes Available -->
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-yellow-800">Chưa có thông số kỹ thuật</h4>
                            <p class="text-sm text-yellow-700 mt-1">Thông tin chi tiết về sản phẩm sẽ được cập nhật sớm
                                nhất.</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Price Section -->
                <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-lg p-5 border-2 border-red-200">
                    <div class="flex items-baseline gap-3">
                        @if($product->discount_price)
                        <div class="text-3xl font-bold text-red-600">
                            {{ number_format($product->discount_price, 0, ',', '.') }}₫
                        </div>
                        <div class="text-lg text-gray-500 line-through">
                            {{ number_format($product->price, 0, ',', '.') }}₫
                        </div>
                        <div class="px-2 py-1 bg-red-500 text-white text-sm font-bold rounded">
                            -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                        </div>
                        @else
                        <div class="text-3xl font-bold text-gray-900">
                            {{ number_format($product->price, 0, ',', '.') }}₫
                        </div>
                        @endif
                    </div>
                    <div class="mt-2 text-sm text-gray-600">
                        <span class="font-medium">Tình trạng:</span>
                        @if($product->stock > 0)
                        <span class="text-green-600 font-semibold">Còn hàng ({{ $product->stock }} sản phẩm)</span>
                        @else
                        <span class="text-red-600 font-semibold">Hết hàng</span>
                        @endif
                    </div>
                </div>

                <!-- Quantity Selector -->
                <div class="flex items-center gap-4">
                    <span class="text-gray-700 font-medium">Số lượng:</span>
                    <div class="flex items-center border-2 border-gray-300 rounded-lg overflow-hidden">
                        <button type="button" onclick="decreaseQty()"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                </path>
                            </svg>
                        </button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}"
                            class="w-16 text-center py-2 border-0 focus:ring-0 font-semibold text-gray-900">
                        <button type="button" onclick="increaseQty()"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                    <span class="text-sm text-gray-500">{{ $product->stock }} sản phẩm có sẵn</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    @auth
                    <form method="POST" action="{{ route('cart.add') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" id="cart-quantity" value="1">
                        <button type="button" data-url="{{ route('cart.add') }}" data-method="post"
                            data-product-id="{{ $product->id }}" @if($product->stock <= 0) disabled @endif
                                class="js-add-to-cart flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 font-bold text-white shadow-lg transition-all hover:from-blue-600 hover:to-blue-700 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                Thêm vào giỏ hàng
                        </button>
                    </form>
                    @else
                    <div class="flex-1">
                        <input type="hidden" id="cart-quantity" value="1">
                        <button type="button" data-url="{{ route('cart.add') }}" data-method="post"
                            data-product-id="{{ $product->id }}" @if($product->stock <= 0) disabled @endif
                                class="js-add-to-cart flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 font-bold text-white shadow-lg transition-all hover:from-blue-600 hover:to-blue-700 hover:shadow-xl disabled:cursor-not-allowed disabled:opacity-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                Thêm vào giỏ hàng
                        </button>
                    </div>
                    @endauth

                    <form method="POST" action="{{ route('cart.buy-now') }}" class="flex-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" id="order-quantity" value="1">
                        <button type="button" @if($product->stock <= 0) disabled @endif data-product-id="{{ $product->id }}" data-quantity="1"
                                class="js-buy-now w-full px-6 py-4 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Mua ngay
                        </button>
                    </form>
                </div>

                <!-- Additional Info -->
                <div class="border-t pt-4 space-y-2 text-sm">
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Miễn phí vận chuyển cho đơn hàng từ 500.000₫</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                        <span>Bảo hành chính hãng 12 tháng</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Đổi trả trong 7 ngày nếu có lỗi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description & Specifications Section -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Product Description (2/3 width) -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Mô tả sản phẩm
                </h2>
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($product->description ?: 'Chưa có mô tả chi tiết cho sản phẩm này.')) !!}
                </div>
            </div>

            <!-- Right: Technical Specifications (1/3 width) -->
            <div class="lg:col-span-1">
                @if(isset($product->inventoryItem->attributeValues) && $product->inventoryItem->attributeValues->count()
                > 0)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden sticky top-4">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-4">
                        <h3 class="font-bold text-white text-lg flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Thông số kỹ thuật
                        </h3>
                    </div>
                    <div class="p-5">
                        <table class="w-full">
                            <tbody class="divide-y divide-gray-200">
                                @foreach($product->inventoryItem->attributeValues as $av)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div>
                                            <span
                                                class="text-sm font-semibold text-gray-700">{{ $av->attribute->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-right">
                                        <span class="text-sm font-bold text-gray-900">{{ $av->value }}</span>
                                        @if($av->attribute->unit)
                                        <span class="text-xs text-gray-500 ml-1">{{ $av->attribute->unit }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Additional Product Info -->
                    <div class="bg-gray-50 px-5 py-4 border-t border-gray-200">
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-700">Sản phẩm chính hãng 100%</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                <span class="text-gray-700">Bảo hành chính hãng 12 tháng</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-purple-600 flex-shrink-0 mt-0.5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                                <span class="text-gray-700">Hỗ trợ trả góp 0%</span>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Chưa có thông số kỹ thuật</h3>
                        <p class="text-sm text-gray-500">Thông tin sẽ được cập nhật sớm</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Suggestions --}}
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Gợi ý cho bạn</h2>
            @if($suggestions->count())
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($suggestions as $s)
                @php $simg = $s->images->where('is_main', true)->first() ?? $s->images->first(); @endphp
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 hover:-translate-y-1 relative">
                    <!-- image -->
                    <div class="relative bg-gray-50">
                        <div class="h-40 bg-gray-50 flex items-center justify-center p-4">
                            @if($simg)
                            <a href="{{ route('productInformation', $s->id) }}" class="block w-full h-full flex items-center justify-center">
                                <img src="{{ $simg->image_url }}" alt="{{ $s->name }}" class="max-h-full max-w-full object-contain" data-fallback="https://cdn-icons-png.flaticon.com/512/679/679720.png" onerror="this.src=this.dataset.fallback">
                            </a>
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <img src="https://cdn-icons-png.flaticon.com/512/679/679720.png" class="max-h-full max-w-full" alt="no image">
                            </div>
                            @endif
                        </div>

                        @if($s->discount_price)
                        @php $discountPercent = round((1 - $s->discount_price / max($s->price,1)) * 100); @endphp
                        <span class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">-{{ $discountPercent }}%</span>
                        @endif
                    </div>

                    <!-- absolute cart button -->
                    <button type="button" data-url="{{ route('cart.add') }}" data-product-id="{{ $s->id }}" data-method="post" @if($s->stock <= 0) disabled @endif
                        class="js-add-to-cart absolute bottom-3 right-3 z-10 inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-lg @if($s->stock <= 0) opacity-60 cursor-not-allowed pointer-events-none @endif">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z" />
                        </svg>
                    </button>

                    <div class="p-3">
                        <p class="text-xs text-gray-500 mb-1 truncate">{{ optional($s->inventoryItem->category)->name ?? '' }}</p>
                        <h4 class="text-sm font-medium text-gray-900 leading-tight line-clamp-2 h-10">
                            <a href="{{ route('productInformation', $s->id) }}" class="inline-block">{{ $s->name }}</a>
                        </h4>

                        <!-- Giá -->
                        <div class="mt-2">
                            @if($s->discount_price)
                            <div class="text-red-600 font-bold text-base">{{ number_format($s->discount_price) }}đ</div>
                            <div class="text-gray-400 text-xs line-through">{{ number_format($s->price) }}đ</div>
                            @else
                            <div class="text-gray-900 font-bold text-base">{{ number_format($s->price) }}đ</div>
                            @endif
                        </div>

                        <!-- Đánh giá -->
                        <div class="mt-1 flex items-center text-yellow-400 text-sm">
                            ★★★★★
                            <span class="text-gray-500 text-xs ml-1">(0 đánh giá)</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-gray-500">Không có gợi ý nào.</div>
            @endif
        </div>
    </div>
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3
                        class="text-2xl font-bold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
                        TechShop</h3>
                    <p class="text-gray-400 text-sm">
                        Cung cấp các sản phẩm điện tử chất lượng cao với giá tốt nhất.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Về chúng tôi</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Giới thiệu</a></li>
                        <li><a href="#" class="hover:text-white">Liên hệ</a></li>
                        <li><a href="#" class="hover:text-white">Tuyển dụng</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Hỗ trợ</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white">Chính sách bảo hành</a></li>
                        <li><a href="#" class="hover:text-white">Chính sách đổi trả</a></li>
                        <li><a href="#" class="hover:text-white">Hướng dẫn mua hàng</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Theo dõi chúng tôi</h4>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center hover:bg-blue-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center hover:bg-pink-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm text-gray-400">
                <p>&copy; 2025 TechShop. All rights reserved.</p>
            </div>
        </div>
    </footer>
    <!-- Toast container for this page -->
    <div id="toast-container" class="fixed top-6 right-6 z-50"></div>
    <script>
    // Image Gallery Navigation + robust fallback handling
    const FALLBACK_IMG = 'https://cdn-icons-png.flaticon.com/512/679/679720.png';
    const images = @json($imageArray ?? []);
    let currentIndex = {
        {
            $mainImageIndex ?? 0
        }
    };

    function applyImgFallback(img) {
        if (!img) return;
        try {
            img.dataset.fallback = img.dataset.fallback || FALLBACK_IMG;
            img.style.objectFit = img.style.objectFit || 'contain';
            img.onerror = function() {
                this.onerror = null;
                this.src = this.dataset.fallback || FALLBACK_IMG;
            };
            // If image already failed before handler attached
            if (img.complete && (!img.naturalWidth || img.naturalWidth === 0)) {
                img.src = img.dataset.fallback || FALLBACK_IMG;
            }
        } catch (e) {
            // ignore
        }
    }

    function changeImage(index) {
        if (!images || !images[index]) return;
        currentIndex = index;
        const mainImage = document.getElementById('main-image');
        const url = images[index].image_url || FALLBACK_IMG;
        mainImage.src = url;
        mainImage.dataset.fallback = mainImage.dataset.fallback || FALLBACK_IMG;
        applyImgFallback(mainImage);

        // Update thumbnail borders
        document.querySelectorAll('.thumbnail-btn').forEach((btn, i) => {
            if (i === index) {
                btn.classList.remove('border-gray-300');
                btn.classList.add('border-blue-500');
            } else {
                btn.classList.remove('border-blue-500');
                btn.classList.add('border-gray-300');
            }
        });
    }

    function previousImage() {
        if (!images || images.length <= 1) return;
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        changeImage(currentIndex);
    }

    function nextImage() {
        if (!images || images.length <= 1) return;
        currentIndex = (currentIndex + 1) % images.length;
        changeImage(currentIndex);
    }

    // Quantity Controls
    function decreaseQty() {
        const qtyInput = document.getElementById('quantity');
        const currentQty = parseInt(qtyInput.value) || 1;
        if (currentQty > 1) {
            qtyInput.value = currentQty - 1;
            updateHiddenQuantities();
        }
    }

    function increaseQty() {
        const qtyInput = document.getElementById('quantity');
        const maxQty = parseInt(qtyInput.getAttribute('max')) || 999;
        const currentQty = parseInt(qtyInput.value) || 1;
        if (currentQty < maxQty) {
            qtyInput.value = currentQty + 1;
            updateHiddenQuantities();
        }
    }

    function updateHiddenQuantities() {
        const qty = document.getElementById('quantity').value;
        const cartInput = document.getElementById('cart-quantity');
        if (cartInput) {
            cartInput.value = qty;
        }
        const orderInput = document.getElementById('order-quantity');
        if (orderInput) {
            orderInput.value = qty;
        }
    }

    // Update hidden inputs when quantity changes manually
    document.getElementById('quantity')?.addEventListener('change', function() {
        const maxQty = parseInt(this.getAttribute('max')) || 999;
        let value = parseInt(this.value) || 1;
        if (value < 1) value = 1;
        if (value > maxQty) value = maxQty;
        this.value = value;
        updateHiddenQuantities();
    });

    // attach fallback handlers on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        applyImgFallback(document.getElementById('main-image'));
        document.querySelectorAll('.thumbnail-btn img, .suggestions img, img.product-auto-fit').forEach(
            applyImgFallback);
    });

    // Keyboard navigation for images
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            previousImage();
        } else if (e.key === 'ArrowRight') {
            nextImage();
        }
    });
    </script>

    <script>
    (function() {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        window.isAuthenticated = @json(Auth::check());
        window.currentUser = @json(Auth::check() ? Auth::user()->only(['id', 'email']) : null);

        function showToast(message, type = 'success', duration = 3000) {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const el = document.createElement('div');
            el.className = (type === 'error' ? 'bg-red-500' : 'bg-green-600') +
                ' text-white px-4 py-3 rounded shadow-lg mb-2 max-w-sm flex items-center gap-3';
            el.style.opacity = '0';
            el.innerHTML = `<div class="flex-1 text-sm">${message}</div>`;
            container.appendChild(el);
            requestAnimationFrame(() => {
                el.style.transition = 'opacity 200ms';
                el.style.opacity = '1';
            });
            setTimeout(() => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 250);
            }, duration);
        }

        async function addToCart(options) {
            const url = options.url;
            const method = (options.method || 'POST').toUpperCase();
            const productId = options.productId;
            const quantity = options.quantity || 1;
            try {
                if (method === 'GET') {
                    const res = await fetch(url, {
                        method: 'GET',
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (res.ok) {
                        showToast('Bạn đã thêm sản phẩm vào giỏ hàng', 'success');
                        return true;
                    }
                } else {
                    const form = new FormData();
                    if (productId) form.append('product_id', productId);
                    form.append('quantity', quantity);
                    const res = await fetch(url, {
                        method: method,
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrf
                        },
                        body: form
                    });
                    if (res.ok) {
                        showToast('Bạn đã thêm sản phẩm vào giỏ hàng', 'success');
                        return true;
                    }
                }
            } catch (e) {}
            if (typeof openLoginPopup === 'function') openLoginPopup();
            return false;
        }

        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.js-add-to-cart');
            if (!btn) return;
            e.preventDefault();
            const url = btn.dataset.url || btn.getAttribute('href') || btn.dataset.urlFallback;
            const method = btn.dataset.method || btn.getAttribute('data-method') || 'POST';
            const productId = btn.dataset.productId || btn.getAttribute('data-product-id');
            const qtyFromBtn = btn.dataset.quantity || btn.getAttribute('data-quantity');
            let quantity = qtyFromBtn ? parseInt(qtyFromBtn, 10) : null;
            if (!quantity) {
                const qEl = document.getElementById('cart-quantity') || document.getElementById('quantity');
                if (qEl) quantity = parseInt(qEl.value || qEl.getAttribute('value') || 1, 10);
            }
            if (!window.isAuthenticated) {
                if (typeof openLoginPopup === 'function') openLoginPopup();
                return;
            }
            if (!window.currentUser || !window.currentUser.email) {
                if (typeof openLoginPopup === 'function') openLoginPopup();
                return;
            }
            if (!url) {
                if (typeof openLoginPopup === 'function') openLoginPopup();
                return;
            }
            addToCart({
                url: url,
                method: method,
                productId: productId,
                quantity: quantity
            });
        });
    })();
    </script>
    @include('components.pop-up.required_login-popup')
    <script>
    (function() {
        function openLoginPopup(message) {
            const modal = document.getElementById('required-login-popup');
            if (!modal) return;
            const msgEl = document.getElementById('required-login-popup-message');
            if (msgEl && message) msgEl.textContent = message;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeLoginPopup() {
            const modal = document.getElementById('required-login-popup');
            if (!modal) return;
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modal.setAttribute('aria-hidden', 'true');
        }
        window.openLoginPopup = openLoginPopup;
        window.closeLoginPopup = closeLoginPopup;
        document.addEventListener('click', function(e) {
            const closeBtn = e.target.closest('[data-close-login-popup]');
            if (closeBtn) {
                e.preventDefault();
                closeLoginPopup();
            }
            const modal = document.getElementById('required-login-popup');
            if (modal && e.target === modal) closeLoginPopup();
        });
    })();
    </script>
</body>

</html>