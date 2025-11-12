<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TechShop - Trang chủ</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="antialiased bg-gray-50">
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

                <!-- Search Bar (Desktop) - styled like admin filters but single-field -->
                <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                    <div class="w-full bg-white shadow rounded-lg px-3 py-2">
                        @livewire('product-search')
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="flex items-center space-x-4">
                    @auth
                    @php
                    $homeCartRelation = auth()->user()->cart;
                    $homeCartCount = $homeCartRelation ? $homeCartRelation->items()->sum('quantity') : 0;
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600" aria-label="Giỏ hàng">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span
                            class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-semibold text-white">{{ $homeCartCount }}</span>
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
                    <button type="button" class="relative p-2 text-gray-600 hover:text-blue-600" data-trigger-login-popup aria-label="Giỏ hàng">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>
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
    @include('components.pop-up.required_login-popup')
    @if(session('forceLoginPopup'))
    <script>
        window.addEventListener('load', function () {
            if (typeof window.showRequiredLoginPopup === 'function') {
                window.showRequiredLoginPopup();
            }
        });
    </script>
    @endif
    <!-- Advertisements -->

    <div x-data="advertCarousel({{ $ads->toJson() }})" x-init="init()" class="w-[70%] mx-auto relative">

        @if ($ads->count())
        <!-- Khung ảnh quảng cáo -->
        <div class="relative overflow-hidden rounded-md shadow">
            <template x-for="(ad, i) in ads" :key="i">
                <img x-show="index === i" :src="ad.link_url" :alt="`Quảng cáo ${ad.id_advert}`"
                    class="w-full max-h-96 object-contain mx-auto transition-opacity duration-700 bg-gray-100">
            </template>
        </div>

        <!-- Nút tròn điều hướng -->
        <div class="flex items-center justify-center gap-2 mt-3">
            <template x-for="(a, i) in ads" :key="i">
                <button @click="goTo(i)" :aria-label="`Đi tới quảng cáo ${i+1}`"
                    class="w-3 h-3 rounded-full focus:outline-none transition"
                    :class="index === i ? 'bg-blue-600' : 'bg-gray-300'">
                </button>
            </template>
        </div>
        @else
        <p class="text-gray-500 text-center">Hiện chưa có quảng cáo nào.</p>
        @endif
    </div>

    <script>
    function advertCarousel(initialAds) {
        return {
            ads: initialAds || [],
            index: 0,
            timer: null,
            init() {
                if (this.ads.length > 1) {
                    this.start();
                }
            },
            start() {
                this.clear();
                this.timer = setInterval(() => {
                    this.index = (this.index + 1) % this.ads.length;
                }, 15000); // đổi ảnh mỗi 15s
            },
            clear() {
                if (this.timer) {
                    clearInterval(this.timer);
                    this.timer = null;
                }
            },
            goTo(i) {
                this.index = i % this.ads.length;
                this.start(); // reset lại thời gian xoay khi người dùng click
            }
        }
    }
    </script>


    <!-- Categories -->
    <section id="categories" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">Danh mục sản phẩm</h2>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach($categories as $category)
                <a href="#category-{{ $category->id }}" data-target="#category-{{ $category->id }}"
                    data-category-id="{{ $category->id }}" class="group"
                    aria-label="Đi tới danh mục {{ $category->name }}">
                    <div
                        class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div
                            class="w-16 h-16 mx-auto mb-4 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($category->name, 0, 1)) }}
                        </div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $category->inventory_items_count }} sản phẩm
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <script>
    // Smooth scroll to category sections when clicking top-category anchors.
    // Anchors have data-target="#category-{id}" and data-category-id="{id}".
    (function() {
        function scrollToSectionById(id) {
            var section = document.getElementById(id) || document.querySelector('[data-category-id="' + id + '"]');
            if (!section) return;
            var header = document.querySelector('header');
            var offset = header ? header.offsetHeight + 12 : 12; // give some breathing room
            var top = section.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({
                top: top,
                behavior: 'smooth'
            });
            try {
                history.replaceState(null, null, '#' + id);
            } catch (e) {}
        }

        document.querySelectorAll('a[data-target], a[data-category-id]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                // allow opening in new tab with modifier keys
                if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
                e.preventDefault();
                var target = this.dataset.target || this.getAttribute('href');
                if (!target) return;
                // target may be like '#category-5' or 'category-5'
                var id = target.replace(/^#/, '');
                // If the id is numeric only, try data-category-id first
                if (/^\d+$/.test(id)) {
                    // numeric id -> look for section with matching data-category-id
                    scrollToSectionById(id);
                } else {
                    scrollToSectionById(id);
                }
            });
        });
    })();
    </script>

    <!-- Featured Products -->
    <section id="featured" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Sản phẩm nổi bật</h2>
                <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Xem tất cả →</a>
            </div>
            {{-- Slider: shows 4 at a time; if >4 it will auto-slide right->left every interval --}}
            @php $fpCount = $featuredProducts->count(); @endphp
            <div class="relative">
                <div id="featured-viewport" class="overflow-hidden">
                    <div id="featured-track" class="flex gap-6 transition-transform duration-700"
                        style="will-change: transform;">
                        @foreach($featuredProducts as $product)
                        <div class="flex-shrink-0" style="width: calc(100%/4);">
                            <div
                                class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                                <!-- Product Image -->
                                <div class="relative h-48 bg-gray-100 overflow-hidden">
                                    @php
                                    $mainImage = $product->images->where('is_main', true)->first() ??
                                    $product->images->first();
                                    @endphp
                                    @if($mainImage)
                                    <img src="{{ $mainImage->image_url }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    <!-- overlay link to product information -->
                                    <a href="{{ route('productInformation', $product->id) }}" class="absolute inset-0"
                                        aria-label="Xem {{ $product->name }}"></a>
                                    @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    @endif

                                    <!-- Featured Badge -->
                                    <div class="absolute top-2 right-2">
                                        <span
                                            class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            HOT
                                        </span>
                                    </div>

                                </div>

                                <!-- Product Info -->
                                <div class="p-4">
                                    <p class="text-xs text-gray-500 mb-1">{{ $product->inventoryItem->category->name }}
                                    </p>
                                    <h3
                                        class="font-semibold text-gray-900 mb-2 line-clamp-2 leading-tight h-10 group-hover:text-blue-600 transition">
                                        <a href="{{ route('productInformation', $product->id) }}"
                                            class="inline-block">{{ $product->name }}</a>
                                    </h3>

                                    <div class="flex items-center justify-between">
                                        <div>
                                            @if($product->discount_price)
                                            <p class="text-lg font-bold text-red-600">
                                                {{ number_format($product->discount_price) }}đ
                                            </p>
                                            <p class="text-sm text-gray-400 line-through">
                                                {{ number_format($product->price) }}đ
                                            </p>
                                            @else
                                            <p class="text-lg font-bold text-gray-900">
                                                {{ number_format($product->price) }}đ
                                            </p>
                                            @endif
                                        </div>

                                        <button
                                            class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Optional navigation dots (hidden by default) --}}
                @if($fpCount > 4)
                <div id="featured-dots" class="mt-4 flex items-center justify-center space-x-2"></div>
                @endif
            </div>

            {{-- Auto-slide script for featured products --}}
            <script>
            (function() {
                const total = {
                    {
                        $fpCount
                    }
                };
                const visible = 4;
                if (total <= visible) return; // no sliding needed

                const viewport = document.getElementById('featured-viewport');
                const track = document.getElementById('featured-track');
                const dotsContainer = document.getElementById('featured-dots');

                // compute pages
                const pages = Math.ceil(total / visible);
                let current = 0;

                // create dots
                if (dotsContainer) {
                    for (let i = 0; i < pages; i++) {
                        const d = document.createElement('button');
                        d.className = 'w-2 h-2 rounded-full bg-gray-300';
                        d.setAttribute('aria-label', 'Go to slide ' + (i + 1));
                        d.onclick = (() => {
                            return function() {
                                goTo(i);
                                resetTimer();
                            };
                        })();
                        dotsContainer.appendChild(d);
                    }
                }

                function updateDots() {
                    if (!dotsContainer) return;
                    Array.from(dotsContainer.children).forEach((btn, idx) => {
                        btn.className = idx === current ? 'w-3 h-3 rounded-full bg-blue-600' :
                            'w-2 h-2 rounded-full bg-gray-300';
                    });
                }

                function goTo(page) {
                    current = page % pages;
                    const percent = (current * 100);
                    // each page moves by 100% of viewport
                    track.style.transform = 'translateX(-' + percent + '%)';
                    updateDots();
                }

                // Because each item width is calc(100%/4), the full track width equals pages * 100%.
                // Set track width accordingly to allow percent-based translate to work.
                track.style.width = (pages * 100) + '%';
                // also set each child (slide) width to (100 / (pages*4))% to maintain layout
                Array.from(track.children).forEach(function(child) {
                    child.style.width = (100 / (pages * 4)) + '%';
                });

                updateDots();

                // auto slide every 17 seconds (between 15-20s as requested)
                const intervalMs = 17000;
                let timer = setInterval(() => {
                    goTo((current + 1) % pages);
                }, intervalMs);

                function resetTimer() {
                    clearInterval(timer);
                    timer = setInterval(() => {
                        goTo((current + 1) % pages);
                    }, intervalMs);
                }

                // Pause on hover
                viewport.addEventListener('mouseenter', () => clearInterval(timer));
                viewport.addEventListener('mouseleave', () => {
                    resetTimer();
                });

                // Initialize position
                goTo(0);
            })();
            </script>
        </div>
    </section>

    <!-- Show Products per Category -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-900">Các loại sản phẩm</h2>


            <!-- Sections: one <section> per category with up to 10 products (5 cols x 2 rows) -->
            <!-- Hiển thị danh mục + sản phẩm -->
            @foreach($categories as $cat)
            <section id="category-{{ $cat->id }}" data-category-id="{{ $cat->id }}" class="mb-12">
                <!-- Tiêu đề danh mục -->
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <!-- Tiêu đề có nền xanh + góc chéo -->
                    <div class="relative inline-block">
                        <h3 class="text-2xl font-semibold text-white uppercase tracking-wide px-6 py-2 bg-blue-600 shadow-md"
                            style="clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 100%, 0% 100%);">
                            {{ $cat->name }}
                        </h3>
                    </div>

                    <!-- Link xem tất cả -->
                    <a href="{{ route('home', ['category' => $cat->id]) }}"
                        class="text-blue-600 hover:text-blue-700 font-medium flex items-center">
                        Xem tất cả →
                    </a>
                </div>

                <!-- Lưới sản phẩm -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-5">
                    @forelse($cat->previewProducts as $product)
                    <div
                        class="bg-white rounded-xl shadow hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 hover:-translate-y-1">
                        <!-- Hình ảnh sản phẩm -->
                        <div class="relative bg-gray-50">
                            @php
                            $mainImage = $product->images->where('is_main', true)->first() ?? $product->images->first();
                            @endphp

                            @if($mainImage)
                            <img src="{{ $mainImage->image_url }}" alt="{{ $product->name }}"
                                class="w-full h-48 object-cover">
                            <a href="{{ route('productInformation', $product->id) }}" class="absolute inset-0"
                                aria-label="Xem {{ $product->name }}"></a>
                            @else
                            <div class="w-full h-48 flex items-center justify-center bg-gray-100 text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif

                            <!-- Badge giảm giá -->
                            @if($product->discount_price)
                            @php
                            $discountPercent = round((1 - $product->discount_price / $product->price) * 100);
                            @endphp
                            <span
                                class="absolute top-2 left-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">
                                -{{ $discountPercent }}%
                            </span>
                            @endif
                        </div>

                        <!-- Thông tin sản phẩm -->
                        <div class="p-3">
                            <p class="text-xs text-gray-500 mb-1 truncate">
                                {{ $product->inventoryItem->category->name ?? $cat->name }}</p>
                            <h4 class="text-sm font-medium text-gray-900 leading-tight line-clamp-2 h-10">
                                <a href="{{ route('productInformation', $product->id) }}"
                                    class="inline-block">{{ $product->name }}</a>
                            </h4>

                            <!-- Giá -->
                            <div class="mt-2">
                                @if($product->discount_price)
                                <div class="text-red-600 font-bold text-base">
                                    {{ number_format($product->discount_price) }}đ
                                </div>
                                <div class="text-gray-400 text-xs line-through">{{ number_format($product->price) }}đ
                                </div>
                                @else
                                <div class="text-gray-900 font-bold text-base">{{ number_format($product->price) }}đ
                                </div>
                                @endif
                            </div>

                            <!-- Đánh giá -->
                            <div class="mt-1 flex items-center text-yellow-400 text-sm">
                                ★★★★★
                                <span class="text-gray-500 text-xs ml-1">(0 đánh giá)</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-5 text-center text-gray-400 py-8">Không có sản phẩm trong danh mục này.</div>
                    @endforelse
                </div>
            </section>
            @endforeach

        </div>
    </section>

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
    @livewireScripts
</body>

</html>