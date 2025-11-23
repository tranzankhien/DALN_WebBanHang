<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TechShop - Trang chủ</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased bg-gray-50">
    <!-- Header / Navigation -->
    @include('layouts.navigation')
    <a href="#" class="hidden lg:block fixed top-24 left-6 z-40" style="transform: translateY(0);">
        <img src="https://cdn.hstatic.net/files/200000722513/file/gearvn-pc-gvn-t11-sticky-banner.jpg" alt="Left Banner" class="h-72 w-auto rounded-lg shadow-lg object-cover">
    </a>
    <a href="#" class="hidden lg:block fixed top-24 right-6 z-40" style="transform: translateY(0);">
        <img src="https://cdn.hstatic.net/files/200000722513/file/gearvn-laptop-t11-sticky-banner.jpg" alt="Right Banner" class="h-72 w-auto rounded-lg shadow-lg object-cover">
    </a>
    <!-- Advertisements -->

    <div x-data="advertCarousel({{ $ads->toJson() }})" x-init="init()" class="w-[70%] mx-auto relative">

        @if ($ads->count())
        <!-- Khung ảnh quảng cáo -->
        <div class="relative overflow-hidden rounded-md bg-white">
            <template x-for="(ad, i) in ads" :key="i">
                <img x-show="index === i" :src="ad.link_url" :alt="`Quảng cáo ${ad.id_advert}`"
                    class="w-full max-h-96 object-contain mx-auto transition-opacity duration-700 bg-gray-100">
            </template>
        </div>

        <!-- Nút tròn điều hướng -->
        <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex gap-2">
            <template x-for="(ad, i) in ads" :key="i">
                <button @click="go(i)" :class="{'bg-white': index === i, 'bg-gray-400': index !== i}"
                    class="w-3 h-3 rounded-full border-0"></button>
            </template>
        </div>
        @endif
    </div>

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
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Sản phẩm nổi bật</h2>
                <a href="{{ route('products.outstanding') }}" class="text-blue-600 hover:text-blue-700 font-medium">Xem
                    tất cả →</a>
            </div>

            <div id="featured-carousel" class="relative">
                @php
                $pages = $featuredProducts->chunk(8);
                @endphp

                <div class="overflow-hidden">
                    <div class="feature-track flex transition-transform duration-500 ease-in-out" style="width: {{ $pages->count() * 100 }}%;">
                        @foreach($pages as $pIndex => $page)
                        <div class="feature-page min-w-full" data-page-index="{{ $pIndex }}">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                @foreach($page as $product)
                                @php
                                $mainImage = $product->images->where('is_main', true)->first() ?? $product->images->first();
                                @endphp

                                <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col h-72 relative transform transition-transform duration-300 hover:-translate-y-2 hover:shadow-xl">
                                    <!-- image block -->
                                    <div class="h-40 bg-gray-50 flex items-center justify-center p-4">
                                        @if($mainImage)
                                        <a href="{{ route('productInformation', $product->id) }}" class="block w-full h-full flex items-center justify-center">
                                            <img src="{{ $mainImage->image_url }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain" data-fallback="https://cdn-icons-png.flaticon.com/512/679/679720.png" onerror="this.src=this.dataset.fallback">
                                        </a>
                                        @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <img src="https://cdn-icons-png.flaticon.com/512/679/679720.png" class="max-h-full max-w-full" alt="no image">
                                        </div>
                                        @endif
                                    </div>

                                    <!-- content -->
                                    <div class="p-4 flex-1 flex flex-col">
                                        <p class="text-xs text-gray-500 mb-1">{{ optional($product->inventoryItem->category)->name }}</p>
                                        <h3 class="text-sm font-semibold text-gray-900 leading-tight line-clamp-2 mb-2"><a href="{{ route('productInformation', $product->id) }}">{{ $product->name }}</a></h3>

                                        <div class="mt-auto flex items-center justify-between">
                                            <div>
                                                @if($product->discount_price)
                                                <div class="text-red-600 font-bold">{{ number_format($product->discount_price) }}đ</div>
                                                <div class="text-gray-400 text-xs line-through">{{ number_format($product->price) }}đ</div>
                                                @else
                                                <div class="text-gray-900 font-bold">{{ number_format($product->price) }}đ</div>
                                                @endif
                                            </div>
                                        </div>

                                    <!-- absolute cart button -->
                                    <button type="button" data-url="{{ route('cart.add') }}" data-product-id="{{ $product->id }}" data-method="post" @if($product->stock <= 0) disabled @endif
                                        class="js-add-to-cart absolute bottom-4 right-4 z-10 inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-lg @if($product->stock <= 0) opacity-60 cursor-not-allowed pointer-events-none @endif">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z" />
                                        </svg>
                                    </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($pages->count() > 1)
                <div class="mt-6 flex items-center justify-center gap-3">
                    <button id="featured-prev" aria-label="Trang trước" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">‹</button>
                    <div id="featured-dots" class="flex items-center gap-2"></div>
                    <button id="featured-next" aria-label="Trang sau" class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200">›</button>
                </div>
                @endif
            </div>
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
                    <a href="{{ route('categoryProducts', $cat->id) }}"
                        class="text-blue-600 hover:text-blue-700 font-medium flex items-center">
                        Xem tất cả →
                    </a>
                </div>

                <!-- Lưới sản phẩm -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-5">
                    @forelse($cat->previewProducts as $product)
                    <div
                        class="bg-white rounded-xl shadow hover:shadow-lg transition duration-300 overflow-hidden border border-gray-100 hover:-translate-y-1 relative">
                        <!-- Hình ảnh sản phẩm -->
                        <div class="relative bg-gray-50">
                            @php
                            $mainImage = $product->images->where('is_main', true)->first() ?? $product->images->first();
                            @endphp

                            <div class="h-40 bg-gray-50 flex items-center justify-center p-4">
                                @if($mainImage)
                                <a href="{{ route('productInformation', $product->id) }}"
                                    class="block w-full h-full flex items-center justify-center">
                                    <img src="{{ $mainImage->image_url }}" alt="{{ $product->name }}"
                                        class="max-h-full max-w-full object-contain"
                                        data-fallback="https://cdn-icons-png.flaticon.com/512/679/679720.png"
                                        onerror="this.src=this.dataset.fallback">
                                </a>
                                @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <img src="https://cdn-icons-png.flaticon.com/512/679/679720.png"
                                        class="max-h-full max-w-full" alt="no image">
                                </div>
                                @endif
                            </div>


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

                        <!-- absolute cart button -->
                        <button type="button" data-url="{{ route('cart.add') }}" data-product-id="{{ $product->id }}" data-method="post" @if($product->stock <= 0) disabled @endif
                            class="js-add-to-cart absolute bottom-3 right-3 z-10 inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-lg @if($product->stock <= 0) opacity-60 cursor-not-allowed pointer-events-none @endif">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z" />
                            </svg>
                        </button>

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
                                <!-- cart button moved to absolute position inside card -->
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

    
    <script>
        (function () {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            window.isAuthenticated = @json(Auth::check());
            window.currentUser = @json(Auth::check() ? Auth::user()->only(['id','email']) : null);

            async function addToCart(options) {
                const url = options.url;
                const method = (options.method || 'POST').toUpperCase();
                const productId = options.productId;
                const quantity = options.quantity || 1;
                try {
                    if (method === 'GET') {
                        const res = await fetch(url, { method: 'GET', credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                        if (res.ok) { 
                            if (typeof window.showToast === 'function') {
                                window.showToast('✅ Đã thêm sản phẩm vào giỏ hàng!', 'success');
                            }
                            if (typeof window.updateCartCount === 'function') {
                                window.updateCartCount();
                            }
                            return true; 
                        }
                    } else {
                        const form = new FormData(); if (productId) form.append('product_id', productId); form.append('quantity', quantity);
                        const res = await fetch(url, { method: method, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf }, body: form });
                        if (res.ok) { 
                            if (typeof window.showToast === 'function') {
                                window.showToast('✅ Đã thêm sản phẩm vào giỏ hàng!', 'success');
                            }
                            if (typeof window.updateCartCount === 'function') {
                                window.updateCartCount();
                            }
                            return true; 
                        }
                    }
                } catch (e) {}
                if (typeof openLoginPopup === 'function') openLoginPopup();
                return false;
            }

            document.addEventListener('click', function (e) {
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
                if (!window.isAuthenticated) { if (typeof openLoginPopup === 'function') openLoginPopup(); return; }
                if (!window.currentUser || !window.currentUser.email) { if (typeof openLoginPopup === 'function') openLoginPopup(); return; }
                if (!url) { if (typeof openLoginPopup === 'function') openLoginPopup(); return; }
                addToCart({ url: url, method: method, productId: productId, quantity: quantity });
            });
        })();
    </script>
        <script>
            // Featured products pager: slide the .feature-track by page index
            (function () {
                const container = document.getElementById('featured-carousel');
                if (!container) return;
                const track = container.querySelector('.feature-track');
                if (!track) return;

                const pages = Array.from(container.querySelectorAll('.feature-page'));
                if (!pages.length) return;

                const dotsWrap = document.getElementById('featured-dots');
                const prevBtn = document.getElementById('featured-prev');
                const nextBtn = document.getElementById('featured-next');
                let index = 0;

                function updateDots(active) {
                    if (!dotsWrap) return;
                    dotsWrap.innerHTML = '';
                    pages.forEach((p, idx) => {
                        const b = document.createElement('button');
                        b.className = 'w-3 h-3 rounded-full ' + (idx === active ? 'bg-blue-600' : 'bg-gray-300');
                        b.setAttribute('aria-label', `Trang ${idx+1}`);
                        b.addEventListener('click', () => showPage(idx));
                        dotsWrap.appendChild(b);
                    });
                }

                function showPage(i) {
                    i = (i + pages.length) % pages.length;
                    // translate track
                    track.style.transform = `translateX(-${i * 100}%)`;
                    updateDots(i);
                    index = i;
                }

                if (prevBtn) prevBtn.addEventListener('click', () => showPage(index - 1));
                if (nextBtn) nextBtn.addEventListener('click', () => showPage(index + 1));

                // initialize
                updateDots(0);
                showPage(0);
            })();
        </script>
    @include('components.pop-up.required_login-popup')
    <script>
        (function () {
            function openLoginPopup(message) {
                // Only show popup if user is NOT authenticated
                if (window.isAuthenticated) {
                    return;
                }
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
            document.addEventListener('click', function (e) {
                const closeBtn = e.target.closest('[data-close-login-popup]');
                if (closeBtn) { e.preventDefault(); closeLoginPopup(); }
                const modal = document.getElementById('required-login-popup');
                if (modal && e.target === modal) closeLoginPopup();
            });
        })();
    </script>
    @include('partials.footer')
    @livewireScripts
</body>

</html>