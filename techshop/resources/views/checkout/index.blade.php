<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thanh toán - TechShop</title>
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
                <span class="text-gray-600 font-medium">Thanh toán</span>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        1
                    </div>
                    <span class="ml-2 text-blue-600 font-medium">Thông tin giao hàng</span>
                </div>
                <div class="w-16 h-1 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold">
                        2
                    </div>
                    <span class="ml-2 text-gray-500">Xác nhận đơn hàng</span>
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

        <form action="{{ route('checkout.review') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <!-- Left Column: Shipping Information -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Thông tin giao hàng</h2>

                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Họ và tên người nhận <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name ?? '') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Số điện thoại <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="shipping_phone" value="{{ old('shipping_phone', $defaultAddress->phone ?? '') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="0912345678">
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Địa chỉ chi tiết <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="shipping_address" value="{{ old('shipping_address', $defaultAddress->address ?? '') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Số nhà, tên đường">
                        </div>

                        <!-- City/Province -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tỉnh/Thành phố
                                </label>
                                <input type="text" name="shipping_city" value="{{ old('shipping_city', $defaultAddress->city ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Hồ Chí Minh">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Quận/Huyện
                                </label>
                                <input type="text" name="shipping_district" value="{{ old('shipping_district', $defaultAddress->district ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Quận 1">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Phường/Xã
                                </label>
                                <input type="text" name="shipping_ward" value="{{ old('shipping_ward', $defaultAddress->ward ?? '') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Phường Bến Nghé">
                            </div>
                        </div>

                        <!-- Note -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Ghi chú (không bắt buộc)
                            </label>
                            <textarea name="customer_note" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Ghi chú cho đơn hàng...">{{ old('customer_note') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Phương thức thanh toán</h2>

                    <div class="space-y-3">
                        <!-- COD -->
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <input type="radio" name="payment_method" value="cod" checked
                                class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                            <div class="ml-4 flex-1">
                                <div class="font-semibold text-gray-900">Thanh toán khi nhận hàng (COD)</div>
                                <div class="text-sm text-gray-500">Thanh toán bằng tiền mặt khi nhận hàng</div>
                            </div>
                            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </label>

                        <!-- Bank Transfer -->
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <input type="radio" name="payment_method" value="bank_transfer"
                                class="w-5 h-5 text-blue-600 focus:ring-blue-500">
                            <div class="ml-4 flex-1">
                                <div class="font-semibold text-gray-900">Chuyển khoản ngân hàng</div>
                                <div class="text-sm text-gray-500">Chuyển khoản qua ngân hàng</div>
                            </div>
                            <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Đơn hàng của bạn</h2>

                    @if(isset($isBuyNow) && $isBuyNow)
                    <div class="mb-4 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                        <div class="flex items-center gap-2 text-orange-700 text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Đơn hàng Mua Ngay
                        </div>
                    </div>
                    @endif

                    <!-- Cart Items -->
                    <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                        @foreach($cartItems as $item)
                        @php
                            $mainImage = $item->product->images->where('is_main', true)->first() ?? $item->product->images->first();
                            $price = $item->product->discount_price ?? $item->product->price;
                        @endphp
                        <div class="flex items-center space-x-3 pb-3 border-b">
                            @if($mainImage)
                            <img src="{{ $mainImage->image_url }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded">
                            @else
                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name }}</p>
                                <p class="text-xs text-gray-500">Số lượng: {{ $item->quantity }}</p>
                                <p class="text-sm font-semibold text-blue-600">{{ number_format($price * $item->quantity) }}đ</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Price Summary -->
                    <div class="space-y-2 pt-4 border-t">
                        <div class="flex justify-between text-gray-600">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($subtotal) }}đ</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Phí vận chuyển:</span>
                            <span>{{ number_format($shippingFee) }}đ</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-gray-900 pt-2 border-t">
                            <span>Tổng cộng:</span>
                            <span class="text-red-600">{{ number_format($total) }}đ</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full mt-6 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-3 px-6 rounded-lg hover:shadow-lg transition duration-300">
                        Tiếp tục →
                    </button>

                    <a href="{{ route('cart.index') }}" class="block text-center text-blue-600 hover:text-blue-700 font-medium mt-4">
                        ← Quay lại giỏ hàng
                    </a>
                </div>
            </div>
        </form>
    </main>
</body>
</html>
