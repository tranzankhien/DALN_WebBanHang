<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đặt hàng thành công - TechShop</title>
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
                <span class="text-gray-600 font-medium">Đặt hàng thành công</span>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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
                <div class="w-16 h-1 bg-green-500"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="ml-2 text-green-600 font-medium">Xác nhận đơn hàng</span>
                </div>
                <div class="w-16 h-1 bg-green-500"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="ml-2 text-green-600 font-medium">Hoàn thành</span>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <div class="bg-white rounded-xl shadow-lg p-8 text-center mb-6">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Đặt hàng thành công!</h1>
            <p class="text-gray-600 mb-6">Cảm ơn bạn đã tin tưởng và mua sắm tại TechShop</p>
            
            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-4 inline-block">
                <p class="text-sm text-gray-600 mb-1">Mã đơn hàng của bạn</p>
                <p class="text-3xl font-bold text-blue-600">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Chi tiết đơn hàng</h2>
            
            <!-- Shipping Info -->
            <div class="mb-6 pb-6 border-b">
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
            <div class="mb-6 pb-6 border-b">
                <h3 class="font-semibold text-gray-900 mb-3">Phương thức thanh toán</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    @if($order->payment->method === 'cod')
                    <div class="flex items-center">
                        <svg class="w-10 h-10 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold text-gray-900">Thanh toán khi nhận hàng (COD)</p>
                            <p class="text-sm text-gray-600">Vui lòng chuẩn bị {{ number_format($order->total_amount) }}đ khi nhận hàng</p>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center">
                        <svg class="w-10 h-10 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Chuyển khoản ngân hàng</p>
                            <p class="text-sm text-gray-600 mb-3">Vui lòng chuyển khoản theo thông tin sau:</p>
                            <div class="bg-white border border-blue-200 rounded p-3 text-sm space-y-1">
                                <p><strong>Ngân hàng:</strong> Vietcombank (VCB)</p>
                                <p><strong>Số tài khoản:</strong> 1234567890</p>
                                <p><strong>Chủ tài khoản:</strong> CONG TY TECHSHOP</p>
                                <p><strong>Số tiền:</strong> <span class="text-red-600 font-bold">{{ number_format($order->total_amount) }}đ</span></p>
                                <p><strong>Nội dung:</strong> <span class="text-blue-600 font-mono">TECHSHOP {{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span></p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h3 class="font-semibold text-gray-900 mb-3">Sản phẩm</h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                    @php
                        $mainImage = $item->product->images->where('is_main', true)->first() ?? $item->product->images->first();
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
                            <p class="font-semibold text-blue-600">{{ number_format($item->price * $item->quantity) }}đ</p>
                        </div>
                    </div>
                    @endforeach
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
            <a href="#" class="flex-1 bg-white border-2 border-gray-300 text-gray-700 font-bold py-3 px-6 rounded-lg hover:border-blue-500 hover:text-blue-600 transition duration-300 text-center">
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
