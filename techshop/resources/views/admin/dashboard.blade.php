@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900" style="font-size: 1.875rem;">Dashboard</h1>
    <p class="mt-1 text-sm text-gray-600">Tổng quan hệ thống quản lý TechShop</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Revenue Today -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-green-50 text-green-600">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-green-100 text-green-800">
                    Hôm nay
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Doanh thu</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['today_revenue'], 0, ',', '.') }}đ</h3>
            </div>
        </div>
        <div class="bg-green-50 px-6 py-2">
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-medium text-green-700 hover:text-green-800 flex items-center">
                Xem chi tiết <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>

    <!-- Orders Today -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800">
                    Hôm nay
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Đơn hàng mới</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['today_orders'] }}</h3>
            </div>
        </div>
        <div class="bg-blue-50 px-6 py-2">
            <a href="{{ route('admin.orders.index') }}" class="text-xs font-medium text-blue-700 hover:text-blue-800 flex items-center">
                Quản lý đơn hàng <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-yellow-50 text-yellow-600">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-yellow-100 text-yellow-800">
                    Cần xử lý
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Đơn chờ duyệt</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['pending_orders'] }}</h3>
            </div>
        </div>
        <div class="bg-yellow-50 px-6 py-2">
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-xs font-medium text-yellow-700 hover:text-yellow-800 flex items-center">
                Xử lý ngay <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>

    <!-- Low Stock -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-xl bg-red-50 text-red-600">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <span class="text-xs font-medium px-2.5 py-0.5 rounded-full bg-red-100 text-red-800">
                    Cảnh báo
                </span>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Sắp hết hàng</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['low_stock'] }}</h3>
            </div>
        </div>
        <div class="bg-red-50 px-6 py-2">
            <a href="{{ route('admin.inventory.index') }}" class="text-xs font-medium text-red-700 hover:text-red-800 flex items-center">
                Kiểm tra kho <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Revenue Chart -->
    <div class="bg-white shadow-sm rounded-2xl p-6 hover:shadow-md transition-shadow duration-300">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Doanh thu 7 ngày qua</h3>
            <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">Biểu đồ đường</span>
        </div>
        <div class="relative h-72">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Order Status Chart -->
    <div class="bg-white shadow-sm rounded-2xl p-6 hover:shadow-md transition-shadow duration-300">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900">Tỷ lệ đơn hàng</h3>
            <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-lg">Biểu đồ tròn</span>
        </div>
        <div class="relative h-72">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Chart
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenue_labels) !!},
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: {!! json_encode($revenue_data) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(value);
                        }
                    }
                }
            }
        }
    });

    // Status Chart
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Hoàn thành', 'Chờ xử lý', 'Đã hủy', 'Đang giao'],
            datasets: [{
                data: {!! json_encode($order_status_counts) !!},
                backgroundColor: [
                    'rgb(34, 197, 94)', // Green
                    'rgb(234, 179, 8)', // Yellow
                    'rgb(239, 68, 68)', // Red
                    'rgb(168, 85, 247)' // Purple
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush

<!-- Recent Orders & Low Stock -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Low Stock Items -->
    <div class="bg-white shadow-sm rounded-2xl hover:shadow-md transition-shadow duration-300 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Sản phẩm sắp hết hàng</h3>
            <a href="{{ route('admin.inventory.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Xem kho</a>
        </div>
        <div class="p-6">
            @if($low_stock_items->count() > 0)
                <div class="space-y-4">
                    @foreach($low_stock_items as $item)
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 font-bold text-xs">
                                    {{ $item->stock_quantity }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $item->name }}</p>
                                    <p class="text-xs text-gray-500">SKU: {{ $item->sku }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Cảnh báo
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 mb-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-gray-500 font-medium">Kho hàng ổn định</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white shadow-sm rounded-2xl hover:shadow-md transition-shadow duration-300 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Đơn hàng gần đây</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Xem tất cả</a>
        </div>
        <div class="p-6">
            @if($recent_orders->count() > 0)
                <div class="space-y-4">
                    @foreach($recent_orders as $order)
                        <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                    #{{ $order->id }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900">{{ number_format($order->total_amount) }}đ</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Chưa có đơn hàng nào</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
