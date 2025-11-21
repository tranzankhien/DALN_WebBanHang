@extends('admin.layouts.app')

@section('title', 'Thêm Người dùng')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900" style="font-size: 1.875rem;">Thêm Người dùng</h1>
    <p class="mt-1 text-sm text-gray-600">Tạo tài khoản người dùng mới</p>
</div>

<div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6 max-w-2xl">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tên</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                <input type="password" name="password" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Xác nhận Mật khẩu</label>
                <input type="password" name="password_confirmation" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Vai trò</label>
                <select name="role" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="flex justify-end pt-4">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 mr-3">
                    Hủy
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Tạo người dùng
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
