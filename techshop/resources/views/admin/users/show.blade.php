<!-- @extends('admin.layouts.app')

@section('title', 'Chi tiết Người dùng')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900" style="font-size: 1.875rem;">Chi tiết Người dùng</h1>
        <p class="mt-1 text-sm text-gray-600">Xem thông tin chi tiết, địa chỉ và lịch sử đơn hàng</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
            Quay lại
        </a>
        <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Chỉnh sửa
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-1">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="flex flex-col items-center">
                    @if($user->avatar)
                        <img src="{{ $user->avatar }}" alt="Avatar" class="h-32 w-32 rounded-full object-cover mb-4 ring-4 ring-gray-100">
                    @else
                        <div class="h-32 w-32 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-4xl mb-4 ring-4 ring-gray-100">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                    <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    
                    <div class="mt-4 flex space-x-2">
                        @if($user->role === 'admin')
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Administrator
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Khách hàng
                            </span>
                        @endif

                        @if($user->provider)
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 flex items-center">
                                {{ ucfirst($user->provider) }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-100 pt-6">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">ID:</span>
                            <span class="text-sm font-medium text-gray-900">#{{ $user->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Ngày tham gia:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Cập nhật lần cuối:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($user->email_verified_at)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Xác thực Email:</span>
                            <span class="text-sm font-medium text-green-600">Đã xác thực</span>
                        </div>
                        @else
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Xác thực Email:</span>
                            <span class="text-sm font-medium text-yellow-600">Chưa xác thực</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden mt-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Sổ địa chỉ</h3>
            </div>
            <div class="p-6">
                @if($user->addresses && $user->addresses->count() > 0)
                    <div class="space-y-4">
                        @foreach($user->addresses as $address)
                            <div class="border rounded-lg p-3 {{ $address->is_default ? 'border-blue-300 bg-blue-50' : 'border-gray-200' }}">
                                <div class="flex justify-between items-start">
                                    <span class="font-medium text-gray-900">{{ $address->name }}</span>
                                    @if($address->is_default)
                                        <span class="text-xs bg-blue-200 text-blue-800 px-2 py-0.5 rounded">Mặc định</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $address->phone }}</p>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $address->address }}, {{ $address->ward }}, {{ $address->district }}, {{ $address->city }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 text-center py-4">Người dùng chưa có địa chỉ nào.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Đơn hàng gần đây</h3>
                @if($user->orders && $user->orders->count() > 0)
                    <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" class="text-sm text-blue-600 hover:text-blue-800">Xem tất cả</a>
                @endif
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày đặt</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng tiền</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if($user->orders && $user->orders->count() > 0)
                            @foreach($user->orders as $order)
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
                                    @php
                                        $statusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processing' => 'bg-blue-100 text-blue-800',
                                            'shipping' => 'bg-indigo-100 text-indigo-800',
                                            'completed' => 'bg-green-100 text-green-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Chờ xử lý',
                                            'processing' => 'Đang xử lý',
                                            'shipping' => 'Đang giao',
                                            'completed' => 'Hoàn thành',
                                            'cancelled' => 'Đã hủy',
                                        ];
                                        $status = $order->status ?? 'pending';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">Xem</a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    Chưa có đơn hàng nào.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection -->
