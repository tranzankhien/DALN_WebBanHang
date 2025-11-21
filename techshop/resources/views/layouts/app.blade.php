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