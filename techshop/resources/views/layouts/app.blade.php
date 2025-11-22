<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tech Shop') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot ?? '' }}
            @endif
        </main>
    </div>
    <!-- Footer -->
    @include('partials.footer')

    <!-- Sticky side banners (visible on large screens) -->
    <a href="#" class="hidden lg:block fixed top-24 left-6 z-40" style="transform: translateY(0);">
        <img src="https://cdn.hstatic.net/files/200000722513/file/gearvn-pc-gvn-t11-sticky-banner.jpg" alt="Left Banner" class="h-72 w-auto rounded-lg shadow-lg object-cover">
    </a>
    <a href="#" class="hidden lg:block fixed top-24 right-6 z-40" style="transform: translateY(0);">
        <img src="https://cdn.hstatic.net/files/200000722513/file/gearvn-laptop-t11-sticky-banner.jpg" alt="Right Banner" class="h-72 w-auto rounded-lg shadow-lg object-cover">
    </a>

    <!-- Toast container -->
    <div id="toast-container" class="fixed top-6 right-6 z-50"></div>
    <!-- Required login popup (used for auth/failure notices) -->
    @include('components.pop-up.required_login-popup')
    <script>
        // Cart add-to-cart handler + toast UI
        (function () {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            window.isAuthenticated = @json(Auth::check());
            window.currentUser = @json(Auth::check() ? Auth::user()->only(['id','email']) : null);

            function showToast(message, type = 'success', duration = 3000) {
                const container = document.getElementById('toast-container');
                if (!container) return;
                const id = 'toast-' + Date.now();
                const bg = type === 'error' ? 'bg-red-500' : 'bg-green-600';
                const el = document.createElement('div');
                el.id = id;
                el.className = `${bg} text-white px-4 py-3 rounded shadow-lg mb-2 max-w-sm flex items-center gap-3`;
                el.style.opacity = '0';
                el.innerHTML = `<div class="flex-1 text-sm">${message}</div>`;
                container.appendChild(el);
                // fade in
                requestAnimationFrame(() => { el.style.transition = 'opacity 200ms'; el.style.opacity = '1'; });
                // remove after duration
                setTimeout(() => {
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 250);
                }, duration);
            }

            async function addToCart(options) {
                // options: { url, method, productId, quantity }
                const url = options.url;
                const method = (options.method || 'POST').toUpperCase();
                const productId = options.productId;
                const quantity = options.quantity || 1;
                try {
                    if (method === 'GET') {
                        const res = await fetch(url, { method: 'GET', credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                        if (res.ok) {
                            showToast('Bạn đã thêm sản phẩm vào giỏ hàng', 'success');
                            return true;
                        }
                    } else {
                        const form = new FormData();
                        if (productId) form.append('product_id', productId);
                        form.append('quantity', quantity);
                        const res = await fetch(url, { method: method, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrf }, body: form });
                        if (res.ok) {
                            showToast('Bạn đã thêm sản phẩm vào giỏ hàng', 'success');
                            return true;
                        }
                    }
                } catch (e) {
                    // ignore
                }
                // Show login/failure modal instead of error toast
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
                // quantity prefer dataset then page input
                const qtyFromBtn = btn.dataset.quantity || btn.getAttribute('data-quantity');
                let quantity = qtyFromBtn ? parseInt(qtyFromBtn, 10) : null;
                if (!quantity) {
                    const qEl = document.getElementById('cart-quantity');
                    if (qEl) quantity = parseInt(qEl.value || qEl.getAttribute('value') || 1, 10);
                }
                if (!window.isAuthenticated) {
                    // Show modal prompting the user to login/register
                    openLoginPopup();
                    return;
                }
                // ensure current user has an email
                if (!window.currentUser || !window.currentUser.email) {
                    openLoginPopup();
                    return;
                }
                if (!url) {
                    openLoginPopup();
                    return;
                }
                addToCart({ url: url, method: method, productId: productId, quantity: quantity });
            });
        })();
    </script>
    <script>
        // Controls for the required-login modal
        (function () {
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

            // expose for other scripts to call (e.g., pages that still call openLoginPopup)
            window.openLoginPopup = openLoginPopup;
            window.closeLoginPopup = closeLoginPopup;

            document.addEventListener('click', function (e) {
                const closeBtn = e.target.closest('[data-close-login-popup]');
                if (closeBtn) {
                    e.preventDefault();
                    closeLoginPopup();
                }
                // click on backdrop should close
                const modal = document.getElementById('required-login-popup');
                if (modal && e.target === modal) {
                    closeLoginPopup();
                }
            });
        })();
    </script>
    <script>
        // Handle Buy Now buttons site-wide: submit form when authenticated, otherwise show login popup with specific message
        (function () {
            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.js-buy-now');
                if (!btn) return;
                e.preventDefault();
                if (!window.isAuthenticated) {
                    if (typeof openLoginPopup === 'function') openLoginPopup('Bạn cần đăng nhập để mua ngay');
                    return;
                }
                // find containing form and submit it (falls back to navigate if no form)
                const form = btn.closest('form');
                if (form) {
                    // ensure hidden quantity field is synced
                    const qEl = document.getElementById('order-quantity');
                    const cartQ = document.getElementById('cart-quantity');
                    if (qEl && cartQ) qEl.value = cartQ.value || qEl.value || 1;
                    form.submit();
                    return;
                }
                const url = btn.dataset.url || btn.getAttribute('href');
                if (url) location.href = url;
            });
        })();
    </script>
    <script>
        // Ensure product images are fully visible (object-contain) and replace very tall images with a fallback icon.
        (function () {
            const FALLBACK = 'https://cdn-icons-png.flaticon.com/512/679/679720.png';
            function handleImg(img) {
                if (!img) return;
                // Keep object-fit contain
                img.style.objectFit = 'contain';

                // If image fails to load, replace with fallback
                img.addEventListener('error', function () {
                    if (img.src !== FALLBACK) img.src = img.datasetFallback || FALLBACK;
                });

                // After load check aspect ratio; if very tall, swap to fallback
                function onLoad() {
                    try {
                        const w = img.naturalWidth || img.width;
                        const h = img.naturalHeight || img.height;
                        if (w && h) {
                            // if height is more than 2.5x width, consider it too tall
                            if (h / w > 2.5) {
                                const fb = img.datasetFallback || FALLBACK;
                                if (img.src !== fb) img.src = fb;
                            }
                        }
                    } catch (e) {
                        // ignore
                    }
                }

                if (img.complete) {
                    onLoad();
                } else {
                    img.addEventListener('load', onLoad);
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('img.product-auto-fit').forEach(function (img) {
                    // expose dataFallback property for older browsers
                    if (!img.datasetFallback) img.datasetFallback = img.getAttribute('data-fallback') || FALLBACK;
                    handleImg(img);
                });
            });
        })();
    </script>
</body>

</html>