<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} — TechShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <!-- Header / Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}"
                        class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                        TechShop
                    </a>
                </div>

                <!-- Search Bar (Desktop) -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <form class="w-full">
                        <div class="relative">
                            <input type="text" placeholder="Tìm kiếm sản phẩm..."
                                class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <button type="submit"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Navigation Links -->
                <nav class="flex items-center space-x-4">
                    @auth
                    <!-- Cart -->
                    <a href="#" class="p-2 text-gray-600 hover:text-blue-600 relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">0</span>
                    </a>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100">
                            @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full">
                            @else
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            @endif
                            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50"
                            style="display: none;">
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Quản trị
                            </a>
                            @endif
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                Tài khoản
                            </a>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                Đơn hàng
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                        Đăng nhập
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg hover:shadow-lg transition">
                        Đăng ký
                    </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Trang chủ</a>
                <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-400">{{ optional($product->inventoryItem->category)->name ?? 'Sản phẩm' }}</span>
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
                        <img id="main-image" src="{{ $imageArray[$mainImageIndex]->image_url }}" 
                             alt="{{ $product->name }}"
                             class="max-h-full max-w-full object-contain p-4">
                        
                        <!-- Navigation Arrows -->
                        @if(count($imageArray) > 1)
                        <button onclick="previousImage()" 
                                class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 rounded-full p-3 shadow-lg transition-all hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button onclick="nextImage()" 
                                class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 rounded-full p-3 shadow-lg transition-all hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                        @endif
                    </div>

                    <!-- Thumbnail Images -->
                    @if(count($imageArray) > 1)
                    <div class="flex gap-2 p-4 bg-gray-50 overflow-x-auto">
                        @foreach($imageArray as $index => $img)
                        <button type="button" 
                                onclick="changeImage({{ $index }})"
                                class="flex-shrink-0 border-2 rounded-lg overflow-hidden hover:border-blue-500 transition thumbnail-btn {{ $index == $mainImageIndex ? 'border-blue-500' : 'border-gray-300' }}"
                                data-index="{{ $index }}">
                            <img src="{{ $img->image_url }}" class="w-20 h-20 object-cover" alt="">
                        </button>
                        @endforeach
                    </div>
                    @endif
                    @else
                    <div class="h-[500px] flex items-center justify-center text-gray-300">
                        <div class="text-center">
                            <svg class="w-24 h-24 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
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
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                            </svg>
                            <span class="text-gray-700 font-medium">4.8</span>
                            <span class="text-gray-500">({{ rand(100, 999) }} đánh giá)</span>
                        </div>
                        <span class="text-gray-400">|</span>
                        <span class="text-gray-600">Đã bán: {{ rand(50, 500) }}</span>
                    </div>
                </div>

                <!-- Category & Attributes -->
                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                    <div class="flex items-center gap-2 text-sm">
                        <span class="font-medium text-gray-600">Danh mục:</span>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full font-medium">
                            {{ optional($product->inventoryItem->category)->name ?? 'Chưa phân loại' }}
                        </span>
                    </div>

                    @if(isset($product->inventoryItem->attributeValues) && $product->inventoryItem->attributeValues->count())
                    <div class="border-t pt-3 space-y-2">
                        @foreach($product->inventoryItem->attributeValues as $av)
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-medium text-gray-600">{{ $av->attribute->name }}:</span>
                            <span class="text-gray-900 font-semibold">{{ $av->value }}{{ $av->attribute->unit ? ' ' . $av->attribute->unit : '' }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

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
                        <button type="button" onclick="decreaseQty()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                        </button>
                        <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                               class="w-16 text-center py-2 border-0 focus:ring-0 font-semibold text-gray-900">
                        <button type="button" onclick="increaseQty()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </button>
                    </div>
                    <span class="text-sm text-gray-500">{{ $product->stock }} sản phẩm có sẵn</span>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <form method="POST" action="/cart/add" class="flex-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" id="cart-quantity" value="1">
                        <button type="submit" @if($product->stock <= 0) disabled @endif
                                class="w-full px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Thêm vào giỏ hàng
                        </button>
                    </form>

                    <form method="POST" action="/orders/create" class="flex-1">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" id="order-quantity" value="1">
                        <button type="submit" @if($product->stock <= 0) disabled @endif
                                class="w-full px-6 py-4 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Mua ngay
                        </button>
                    </form>
                </div>

                <!-- Additional Info -->
                <div class="border-t pt-4 space-y-2 text-sm">
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Miễn phí vận chuyển cho đơn hàng từ 500.000₫</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span>Bảo hành chính hãng 12 tháng</span>
                    </div>
                    <div class="flex items-center gap-2 text-gray-600">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Đổi trả trong 7 ngày nếu có lỗi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description Section -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Mô tả sản phẩm
            </h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed">
                {!! nl2br(e($product->description ?: 'Chưa có mô tả chi tiết cho sản phẩm này.')) !!}
            </div>
        </div>

        {{-- Suggestions --}}
        <div class="mt-8">
            <h2 class="text-xl font-semibold mb-4">Gợi ý cho bạn</h2>
            @if($suggestions->count())
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @foreach($suggestions as $s)
                @php $simg = $s->images->where('is_main', true)->first() ?? $s->images->first(); @endphp
                <a href="{{ route('productInformation', $s->id) }}"
                    class="block bg-white rounded-lg p-3 shadow hover:shadow-md">
                    <div class="h-36 bg-gray-100 flex items-center justify-center overflow-hidden mb-2">
                        @if($simg)
                        <img src="{{ $simg->image_url }}" class="w-full h-full object-contain" alt="{{ $s->name }}">
                        @else
                        <div class="text-gray-300">No image</div>
                        @endif
                    </div>
                    <div class="text-sm font-medium text-gray-900">{{ $s->name }}</div>
                    <div class="text-sm text-gray-600">{{ number_format($s->price) }}đ</div>
                </a>
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

    <script>
        // Image Gallery Navigation
        const images = @json($imageArray ?? []);
        let currentIndex = {{ $mainImageIndex ?? 0 }};

        function changeImage(index) {
            currentIndex = index;
            const mainImage = document.getElementById('main-image');
            mainImage.src = images[index].image_url;
            
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
            if (images.length <= 1) return;
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            changeImage(currentIndex);
        }

        function nextImage() {
            if (images.length <= 1) return;
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
            document.getElementById('cart-quantity').value = qty;
            document.getElementById('order-quantity').value = qty;
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

        // Keyboard navigation for images
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft') {
                previousImage();
            } else if (e.key === 'ArrowRight') {
                nextImage();
            }
        });
    </script>
</body>

</html>