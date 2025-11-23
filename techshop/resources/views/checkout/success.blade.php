<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đặt hàng thành công - TechShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="antialiased bg-gray-50">
     <!-- Navigation Header -->
    @include('layouts.navigation')

    <!-- Success Popup -->
    <div x-data="{ show: true }" 
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
         style="display: none;">
        
        <div @click.away="show = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-90"
             class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 relative">
            
            <!-- Close Button -->
            <button @click="show = false" 
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Success Icon -->
            <div class="flex flex-col items-center text-center mb-6">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-4 animate-bounce">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Đặt hàng thành công!</h2>
                <p class="text-gray-600 mb-4">Cảm ơn bạn đã tin tưởng TechShop</p>
                
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-3 w-full">
                    <p class="text-sm text-gray-600 mb-1">Mã đơn hàng</p>
                    <p class="text-2xl font-bold text-blue-600">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6 space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Tổng tiền:</span>
                    <span class="font-bold text-gray-900">{{ number_format($order->total_amount) }}đ</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Thanh toán:</span>
                    <span class="font-medium text-gray-900">
                        @if($order->payment->method === 'cod')
                            COD
                        @else
                            VNPay
                        @endif
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Trạng thái:</span>
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full font-medium">
                        Đang xử lý
                    </span>
                </div>
            </div>

            <!-- Action Button -->
            <button @click="show = false" 
                    class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:shadow-lg transition duration-300">
                Xem chi tiết đơn hàng
            </button>
        </div>
    </div>

        </div>
    </div>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Order Details -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Chi tiết đơn hàng</h2>
                    <p class="text-sm text-gray-500 mt-1">Mã đơn hàng: <span class="font-semibold text-blue-600">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span></p>
                </div>
                <span class="px-4 py-2 bg-yellow-100 text-yellow-700 text-sm rounded-full font-medium">
                    Đang xử lý
                </span>
            </div>
            
            <!-- Shipping Info & Payment Method -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pb-6 border-b">
                <!-- Shipping Info -->
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Thông tin giao hàng</h3>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex">
                            <span class="w-32 text-gray-600">Người nhận:</span>
                            <span class="font-medium text-gray-900">{{ $order->shipping_name }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-600">Số điện thoại:</span>
                            <span class="font-medium text-gray-900">{{ $order->shipping_phone }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-600">Địa chỉ:</span>
                            <span class="font-medium text-gray-900">
                                {{ $order->shipping_address }}
                                @if($order->shipping_ward), {{ $order->shipping_ward }}@endif
                                @if($order->shipping_district), {{ $order->shipping_district }}@endif
                                @if($order->shipping_city), {{ $order->shipping_city }}@endif
                            </span>
                        </div>
                        @if($order->customer_note)
                        <div class="flex">
                            <span class="w-32 text-gray-600">Ghi chú:</span>
                            <span class="font-medium text-gray-900">{{ $order->customer_note }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Info -->
                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Phương thức thanh toán</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        @if($order->payment->method === 'cod')
                        <div class="flex items-start">
                            <svg class="w-10 h-10 text-green-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">COD</p>
                                <p class="text-sm text-gray-600">Thanh toán khi nhận hàng</p>
                                <p class="text-sm text-gray-600 mt-1">Chuẩn bị {{ number_format($order->total_amount) }}đ</p>
                            </div>
                        </div>
                        @else
                        <div class="flex items-start">
                            <svg class="w-10 h-10 text-blue-500 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">VNPay</p>
                                <p class="text-sm text-gray-600">Đã thanh toán qua VNPay</p>
                                <p class="text-sm text-green-600 mt-1 font-medium">✓ Đã xác nhận</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="font-semibold text-gray-900 mb-3">Sản phẩm</h3>
                <div class="space-y-3">
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach($order->items as $item)
                    @php
                        $mainImage = $item->product->images->where('is_main', true)->first() ?? $item->product->images->first();
                        $itemTotal = $item->price * $item->quantity;
                        $subtotal += $itemTotal;
                    @endphp
                    <div class="flex items-center space-x-4 bg-gray-50 rounded-lg p-3">
                        @if($mainImage)
                        <img src="{{ $mainImage->image_url }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                        @else
                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                            <p class="text-sm text-gray-500">Số lượng: {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-blue-600">{{ number_format($itemTotal) }}đ</p>
                        </div>
                    </div>
                    @endforeach
                    
                    @php
                        $shippingFee = $order->total_amount - $subtotal;
                    @endphp
                    
                    <!-- Shipping Fee -->
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3 border-t-2 border-gray-200">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                            </svg>
                            <span class="text-gray-600">Phí vận chuyển:</span>
                        </div>
                        <span class="font-semibold text-gray-900">{{ number_format($shippingFee) }}đ</span>
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="bg-blue-50 rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900">Tổng thanh toán:</span>
                    <span class="text-2xl font-bold text-red-600">{{ number_format($order->total_amount) }}đ</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('home') }}" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:shadow-lg transition duration-300 text-center">
                Tiếp tục mua sắm
            </a>
            @auth
            <a href="{{ route('orders.index') }}" class="flex-1 bg-white border-2 border-gray-300 text-gray-700 font-bold py-3 px-6 rounded-lg hover:border-blue-500 hover:text-blue-600 transition duration-300 text-center">
                Xem đơn hàng của tôi
            </a>
            @endauth
        </div>

        <!-- Additional Info -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="font-semibold text-gray-900 mb-3 flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Lưu ý
            </h3>
            <ul class="space-y-2 text-sm text-gray-600">
                <li>• Đơn hàng sẽ được xử lý trong vòng 24 giờ</li>
                <li>• Thời gian giao hàng dự kiến: 2-3 ngày làm việc</li>
                <li>• Bạn có thể liên hệ hotline: <strong class="text-blue-600">1900 xxxx</strong> để được hỗ trợ</li>
                @if($order->payment->method === 'bank_transfer')
                <li>• Đơn hàng sẽ được xử lý sau khi chúng tôi xác nhận thanh toán</li>
                @endif
            </ul>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
