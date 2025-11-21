<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xác nhận đơn hàng - TechShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <!-- Simple Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                    TechShop
                </a>
                <span class="mx-4 text-gray-300">→</span>
                <span class="text-gray-600 font-medium">Xác nhận đơn hàng</span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="ml-2 text-green-600 font-medium">Thông tin giao hàng</span>
                </div>
                <div class="w-16 h-1 bg-blue-600"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        2
                    </div>
                    <span class="ml-2 text-blue-600 font-medium">Xác nhận đơn hàng</span>
                </div>
                <div class="w-16 h-1 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold">
                        3
                    </div>
                    <span class="ml-2 text-gray-500">Hoàn thành</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Shipping Information -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">Thông tin giao hàng</h2>
                        <a href="{{ route('checkout.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Chỉnh sửa
                        </a>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                        <div class="flex">
                            <span class="w-32 text-gray-600">Người nhận:</span>
                            <span class="font-medium text-gray-900">{{ $validated['shipping_name'] }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-600">Số điện thoại:</span>
                            <span class="font-medium text-gray-900">{{ $validated['shipping_phone'] }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-600">Địa chỉ:</span>
                            <span class="font-medium text-gray-900">
                                {{ $validated['shipping_address'] }}
                                @if($validated['shipping_ward']), {{ $validated['shipping_ward'] }}@endif
                                @if($validated['shipping_district']), {{ $validated['shipping_district'] }}@endif
                                @if($validated['shipping_city']), {{ $validated['shipping_city'] }}@endif
                            </span>
                        </div>
                        @if($validated['customer_note'])
                        <div class="flex">
                            <span class="w-32 text-gray-600">Ghi chú:</span>
                            <span class="font-medium text-gray-900">{{ $validated['customer_note'] }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Phương thức thanh toán</h2>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        @if($validated['payment_method'] === 'cod')
                        <div class="flex items-center">
                            <svg class="w-12 h-12 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Thanh toán khi nhận hàng (COD)</p>
                                <p class="text-sm text-gray-600">Thanh toán bằng tiền mặt khi nhận hàng</p>
                            </div>
                        </div>
                        @else
                        <div class="flex items-center">
                            <svg class="w-12 h-12 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">Chuyển khoản ngân hàng</p>
                                <p class="text-sm text-gray-600">Chuyển khoản qua ngân hàng</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Sản phẩm đã chọn</h2>
                    
                    @if(isset($isBuyNow) && $isBuyNow)
                    <div class="mb-4 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                        <div class="flex items-center gap-2 text-orange-700 text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Đơn hàng Mua Ngay - Sản phẩm không nằm trong giỏ hàng
                        </div>
                    </div>
                    @endif
                    
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                        @php
                            $mainImage = $item->product->images->where('is_main', true)->first() ?? $item->product->images->first();
                            $price = $item->product->discount_price ?? $item->product->price;
                        @endphp
                        <div class="flex items-center space-x-4 pb-4 border-b last:border-b-0">
                            @if($mainImage)
                            <img src="{{ $mainImage->image_url }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                            @else
                            <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500">Số lượng: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">{{ number_format($price) }}đ × {{ $item->quantity }}</p>
                                <p class="font-semibold text-blue-600">{{ number_format($price * $item->quantity) }}đ</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary & Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Tổng đơn hàng</h2>

                    <!-- Price Summary -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($subtotal) }}đ</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Phí vận chuyển:</span>
                            <span>{{ number_format($shippingFee) }}đ</span>
                        </div>
                        <div class="flex justify-between text-2xl font-bold text-gray-900 pt-3 border-t">
                            <span>Tổng cộng:</span>
                            <span class="text-red-600">{{ number_format($total) }}đ</span>
                        </div>
                    </div>

                    <!-- Confirm Order Button -->
                    <form action="{{ route('checkout.place-order') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 from-red-600 to-red-700 text-white font-bold py-3 px-6 rounded-lg hover:shadow-lg transition duration-300 mb-3">
                            ✓ Xác nhận đặt hàng
                        </button>
                    </form>

                    <a href="{{ route('checkout.index') }}" class="block text-center text-blue-600 hover:text-blue-700 font-medium">
                        ← Quay lại
                    </a>

                    <!-- Terms -->
                    <div class="mt-6 pt-6 border-t text-xs text-gray-500 space-y-2">
                        <p>Bằng việc đặt hàng, bạn đồng ý với:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Điều khoản sử dụng</li>
                            <li>Chính sách bảo mật</li>
                            <li>Chính sách đổi trả hàng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
