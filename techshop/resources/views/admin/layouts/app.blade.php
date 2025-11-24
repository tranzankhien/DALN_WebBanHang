<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'TechShop') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col ml-64">
            <!-- Navigation -->
            @include('admin.layouts.navigation')

            <!-- Page Content -->
            <main class="flex-1 p-6 lg:p-8 overflow-y-auto">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-6 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-r-lg shadow-md animate-fade-in-down" role="alert">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 text-red-800 px-6 py-4 rounded-r-lg shadow-md animate-fade-in-down" role="alert">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- New Order Notification Modal -->
    <div id="newOrderModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10 animate-bounce">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Có đơn hàng mới!
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Hệ thống vừa ghi nhận đơn hàng mới. Vui lòng kiểm tra và xử lý ngay.
                                </p>
                                <p class="text-sm font-bold text-blue-600 mt-1" id="pendingOrderCount">
                                    Hiện có 0 đơn chờ xử lý.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <a href="{{ route('admin.orders.index') }}" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Xem danh sách đơn hàng
                    </a>
                    <button type="button" onclick="closeNewOrderModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Audio for notification sound -->
    <audio id="notificationSound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3" preload="auto"></audio>

    <script>
        let lastOrderId = 0;
        let isFirstLoad = true;

        function checkNewOrders() {
            fetch('{{ route('admin.orders.check-new') }}')
                .then(response => response.json())
                .then(data => {
                    if (isFirstLoad) {
                        lastOrderId = data.latest_id;
                        isFirstLoad = false;
                    } else {
                        if (data.latest_id > lastOrderId) {
                            // New order detected
                            lastOrderId = data.latest_id;
                            showNewOrderModal(data.pending_count);
                            playNotificationSound();
                        }
                    }
                })
                .catch(error => console.error('Error checking orders:', error));
        }

        function showNewOrderModal(count) {
            document.getElementById('pendingOrderCount').innerText = `Hiện có ${count} đơn chờ xử lý.`;
            document.getElementById('newOrderModal').classList.remove('hidden');
        }

        function closeNewOrderModal() {
            document.getElementById('newOrderModal').classList.add('hidden');
        }

        function playNotificationSound() {
            const audio = document.getElementById('notificationSound');
            audio.play().catch(e => console.log('Audio play failed (user interaction required first):', e));
        }

        // Poll every 10 seconds
        setInterval(checkNewOrders, 10000);
    </script>

    @stack('scripts')
</body>
</html>
