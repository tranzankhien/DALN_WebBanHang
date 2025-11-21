@extends('admin.layouts.app')

@section('title', 'Chi tiết Người dùng')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900" style="font-size: 1.875rem;">Chi tiết Người dùng</h1>
        <p class="mt-1 text-sm text-gray-600">Thông tin chi tiết và lịch sử hoạt động</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Chỉnh sửa
        </a>
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            Quay lại
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- User Info Card -->
    <div class="lg:col-span-1">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-center mb-6">
                    @if($user->avatar)
                        <img class="h-32 w-32 rounded-full object-cover border-4 border-gray-100" src="{{ $user->avatar }}" alt="{{ $user->name }}">
                    @else
                        <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-4xl font-bold border-4 border-gray-100">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-center text-gray-900 mb-1">{{ $user->name }}</h2>
                <p class="text-sm text-center text-gray-500 mb-4">{{ $user->email }}</p>
                
                <div class="flex justify-center mb-6">
                    @if($user->role === 'admin')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-purple-100 text-purple-800">
                            Admin
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Khách hàng
                        </span>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Ngày tham gia:</span>
                        <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Cập nhật cuối:</span>
                        <span class="font-medium">{{ $user->updated_at->format('d/m/Y') }}</span>
                    </div>
                    @if($user->provider)
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Đăng nhập qua:</span>
                        <span class="font-medium capitalize">{{ $user->provider }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="bg-white shadow rounded-lg overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Thống kê</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['total_orders'] }}</div>
                        <div class="text-sm text-blue-800">Đơn hàng</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">{{ number_format($stats['total_spent'], 0, ',', '.') }}đ</div>
                        <div class="text-sm text-green-800">Đã chi tiêu</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Recent Orders -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Đơn hàng gần đây</h3>
                @if($stats['total_orders'] > 0)
                <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" class="text-sm text-blue-600 hover:text-blue-800">
                    Xem tất cả
                </a>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mã đơn</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ngày đặt</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tổng tiền</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trạng thái</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($user->orders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($order->total_amount, 0, ',', '.') }}đ
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 
                                       'bg-yellow-100 text-yellow-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">Xem</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Chưa có đơn hàng nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Addresses -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Sổ địa chỉ</h3>
            </div>
            <div class="p-6">
                @if($user->addresses->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($user->addresses as $address)
                        <div class="border rounded-lg p-4 {{ $address->is_default ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-medium text-gray-900">{{ $address->name }}</span>
                                @if($address->is_default)
                                    <span class="px-2 py-0.5 text-xs bg-blue-100 text-blue-800 rounded">Mặc định</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600">{{ $address->phone }}</p>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $address->address }}, {{ $address->ward }}, {{ $address->district }}, {{ $address->city }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center">Chưa có địa chỉ nào được lưu.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
