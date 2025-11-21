@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900" style="font-size: 1.875rem;">Dashboard</h1>
    <p class="mt-1 text-sm text-gray-600">Tổng quan hệ thống quản lý TechShop</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Revenue Today -->
    <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-green-500">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Doanh thu hôm nay</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ number_format($stats['today_revenue'], 0, ',', '.') }}đ</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Today -->
    <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-blue-500">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Đơn hàng hôm nay</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $stats['today_orders'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-yellow-500">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Đơn chờ xử lý</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $stats['pending_orders'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock -->
    <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-red-500">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Sắp hết hàng</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $stats['low_stock'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Revenue Chart -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Doanh thu 7 ngày qua</h3>
        <div class="relative h-64">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Order Status Chart -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Tỷ lệ đơn hàng</h3>
        <div class="relative h-64">
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
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_stock']) }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <span class="text-gray-600">Số lượng sản phẩm</span>
            </div>
        </div>
    </div>

    <!-- Active Products -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Sản phẩm đang bán</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_products'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.products.index') }}" class="font-medium text-blue-600 hover:text-blue-500">Xem tất cả</a>
            </div>
        </div>
    </div>

    <!-- Low Stock Warning -->
    <div class="bg-white overflow-hidden shadow rounded-lg border-l-4 border-yellow-400">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Sắp hết hàng</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-yellow-600">{{ $stats['low_stock'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <span class="text-gray-600">Dưới 10 sản phẩm</span>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Danh mục hoạt động</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $stats['total_categories'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <a href="{{ route('admin.categories.index') }}" class="font-medium text-blue-600 hover:text-blue-500">Quản lý danh mục</a>
            </div>
        </div>
    </div>

    <!-- Today Orders -->
    <div class="bg-white overflow-hidden shadow rounded-lg">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-gray-500 truncate">Đơn hàng hôm nay</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-gray-900">{{ $stats['today_orders'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-5 py-3">
            <div class="text-sm">
                <span class="text-gray-600">{{ $stats['pending_orders'] }} đơn chờ xử lý</span>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-5 lg:grid-cols-2">
    <!-- Low Stock Items -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Sản phẩm sắp hết hàng</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            @if($low_stock_items->count() > 0)
                <div class="space-y-3">
                    @foreach($low_stock_items as $item)
                        <div class="flex items-center justify-between py-2 border-b last:border-b-0">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $item->name }}</p>
                                <p class="text-sm text-gray-500">SKU: {{ $item->sku }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->stock_quantity == 0 ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $item->stock_quantity }} trong kho
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Tất cả sản phẩm đều có đủ hàng</p>
            @endif
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Đơn hàng gần đây</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            @if($recent_orders->count() > 0)
                <div class="space-y-3">
                    @foreach($recent_orders as $order)
                        <div class="flex items-center justify-between py-2 border-b last:border-b-0">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">#{{ $order->id }} - {{ $order->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ number_format($order->total_amount) }}đ</p>
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
                <p class="text-gray-500 text-center py-4">Chưa có đơn hàng nào</p>
            @endif
        </div>
    </div>
</div>
@endsection
