@extends('admin.layouts.app')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900" style="font-size: 1.875rem;">Quản lý Đơn hàng</h1>
        <p class="mt-1 text-sm text-gray-600">Danh sách đơn hàng từ khách hàng</p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white shadow rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Tìm kiếm</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Mã đơn, tên, SĐT..."
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Trạng thái</label>
            <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Tất cả</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đang giao</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Lọc</button>
        </div>
    </form>
</div>

<!-- Orders Table -->
<div class="bg-white shadow rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng tiền</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày đặt</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($orders as $order)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    #{{ $order->id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <div class="font-medium text-gray-900">{{ $order->shipping_name }}</div>
                    <div class="text-gray-500">{{ $order->shipping_phone }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ number_format($order->total_amount, 0, ',', '.') }}đ
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'confirmed' => 'bg-blue-100 text-blue-800',
                            'shipped' => 'bg-purple-100 text-purple-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                        $statusLabels = [
                            'pending' => 'Chờ xử lý',
                            'confirmed' => 'Đã xác nhận',
                            'shipped' => 'Đang giao',
                            'completed' => 'Hoàn thành',
                            'cancelled' => 'Đã hủy',
                        ];
                    @endphp
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $statusLabels[$order->status] ?? $order->status }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $order->created_at->format('d/m/Y H:i') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">Chi tiết</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                    Không tìm thấy đơn hàng nào.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $orders->links() }}
    </div>
</div>
@endsection
