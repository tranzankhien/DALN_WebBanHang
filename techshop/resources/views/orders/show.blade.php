<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chi tiết đơn hàng #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} — TechShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <!-- Header -->
    @include('layouts.navigation')

    <!-- Breadcrumb -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('orders.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">
                                Đơn hàng
                            </a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <!-- Order Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Đơn hàng #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-sm text-gray-600 mt-1">Đặt ngày {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-blue-100 text-blue-800',
                            'shipped' => 'bg-purple-100 text-purple-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $colorClass = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $colorClass }}">
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>

            @if($order->isCancellable())
            <div class="flex justify-end">
                <button type="button"
                        data-order-id="{{ $order->id }}"
                        class="cancel-order-btn px-6 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    Hủy đơn hàng
                </button>
            </div>
            @endif

            @if($order->status === 'cancelled' && $order->cancel_reason)
            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-sm font-medium text-red-800">Lý do hủy:</p>
                <p class="text-sm text-red-700 mt-1">{{ $order->cancel_reason }}</p>
                <p class="text-xs text-red-600 mt-1">Hủy lúc: {{ $order->cancelled_at->format('d/m/Y H:i') }}</p>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Sản phẩm ({{ $order->items->count() }})</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            @foreach($order->items as $item)
                            <div class="flex gap-4 pb-6 border-b border-gray-200 last:border-0 last:pb-0">
                                <img src="{{ $item->product->images->first()?->image_url ?? 'https://via.placeholder.com/100' }}" 
                                     alt="{{ $item->product->name }}"
                                     class="w-24 h-24 object-cover rounded-lg">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Danh mục: {{ $item->inventoryItem?->category?->name ?? 'N/A' }}
                                    </p>
                                    
                                    @if($item->inventoryItem && $item->inventoryItem->attributeValues->count() > 0)
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @foreach($item->inventoryItem->attributeValues as $attrValue)
                                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded">
                                            {{ $attrValue->attribute->name }}: {{ $attrValue->value }}{{ $attrValue->attribute->unit ? ' ' . $attrValue->attribute->unit : '' }}
                                        </span>
                                        @endforeach
                                    </div>
                                    @endif
                                    
                                    <div class="mt-3 flex items-center justify-between">
                                        <p class="text-sm text-gray-600">Số lượng: <span class="font-medium text-gray-900">{{ $item->quantity }}</span></p>
                                        <p class="text-lg font-bold text-blue-600">{{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary & Shipping Info -->
            <div class="space-y-6">
                <!-- Payment & Summary -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Thanh toán</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tạm tính:</span>
                            <span class="font-medium text-gray-900">{{ number_format($order->total_amount - 30000, 0, ',', '.') }}₫</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Phí vận chuyển:</span>
                            <span class="font-medium text-gray-900">30.000₫</span>
                        </div>
                        <div class="pt-3 border-t border-gray-200 flex justify-between">
                            <span class="text-base font-semibold text-gray-900">Tổng cộng:</span>
                            <span class="text-xl font-bold text-blue-600">{{ number_format($order->total_amount, 0, ',', '.') }}₫</span>
                        </div>
                        
                        @if($order->payment)
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-sm text-gray-600">Phương thức thanh toán:</p>
                            <p class="font-medium text-gray-900 mt-1">
                                @if($order->payment->method === 'cod')
                                    Thanh toán khi nhận hàng (COD)
                                @elseif($order->payment->method === 'bank_transfer')
                                    Chuyển khoản ngân hàng
                                @else
                                    {{ ucfirst($order->payment->method) }}
                                @endif
                            </p>
                            <p class="text-sm text-gray-600 mt-2">Trạng thái thanh toán:</p>
                            @php
                                $paymentStatusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'paid' => 'bg-green-100 text-green-800',
                                    'failed' => 'bg-red-100 text-red-800',
                                ];
                                $paymentStatusLabels = [
                                    'pending' => 'Chưa thanh toán',
                                    'paid' => 'Đã thanh toán',
                                    'failed' => 'Thất bại',
                                ];
                            @endphp
                            <span class="inline-block mt-1 px-2 py-1 text-xs rounded {{ $paymentStatusColors[$order->payment->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $paymentStatusLabels[$order->payment->status] ?? $order->payment->status }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Shipping Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Thông tin giao hàng</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Người nhận:</p>
                            <p class="font-medium text-gray-900">{{ $order->shipping_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Số điện thoại:</p>
                            <p class="font-medium text-gray-900">{{ $order->shipping_phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Địa chỉ:</p>
                            <p class="font-medium text-gray-900">
                                {{ $order->shipping_address }}
                                @if($order->shipping_ward), {{ $order->shipping_ward }}@endif
                                @if($order->shipping_district), {{ $order->shipping_district }}@endif
                                @if($order->shipping_city), {{ $order->shipping_city }}@endif
                            </p>
                        </div>
                        @if($order->customer_note)
                        <div class="pt-3 border-t border-gray-200">
                            <p class="text-sm text-gray-600">Ghi chú:</p>
                            <p class="text-sm text-gray-900 mt-1">{{ $order->customer_note }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Cancel Order Popup -->
    @include('orders.notification.cancel_order_popup')

    <footer class="bg-gray-900 text-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} TechShop. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
