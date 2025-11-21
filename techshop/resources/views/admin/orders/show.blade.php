@extends('admin.layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-3xl font-bold text-gray-900" style="font-size: 1.875rem;">Chi tiết đơn hàng #{{ $order->id }}</h1>
        <p class="mt-1 text-sm text-gray-600">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="flex space-x-3">
        <button onclick="window.print()" 
            class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-white" style="background-color: #000000d2;">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            In Hóa Đơn
        </button>
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-gray-700 hover:bg-gray-50">
            &larr; Quay lại
        </a>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #invoice-area, #invoice-area * {
            visibility: visible;
        }
        #invoice-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        /* Hide buttons when printing */
        button, a {
            display: none !important;
        }
    }
</style>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" id="invoice-area">
    <!-- Order Items -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Chi tiết đơn hàng #{{ $order->id }}</h3>
                <span class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Đơn giá</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">SL</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                    <div class="text-sm text-gray-500">SKU: {{ $item->product->inventoryItem->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right text-sm text-gray-500">
                            {{ number_format($item->price, 0, ',', '.') }}đ
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-500">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-medium text-gray-900">Tổng cộng:</td>
                        <td class="px-6 py-4 text-right font-bold text-blue-600 text-lg">
                            {{ number_format($order->total_amount, 0, ',', '.') }}đ
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Order Info -->
    <div class="lg:col-span-1">
        <!-- Status Update -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Trạng thái đơn hàng</h3>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Cập nhật trạng thái
                </button>
            </form>
        </div>

        <!-- Customer Info -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin giao hàng</h3>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Người nhận</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Số điện thoại</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_phone }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Địa chỉ</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</dd>
                </div>
                <div class="pt-3 border-t border-gray-200">
                    <dt class="text-sm font-medium text-gray-500">Tài khoản đặt hàng</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $order->user->name }} <br>
                        <span class="text-gray-500">{{ $order->user->email }}</span>
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
