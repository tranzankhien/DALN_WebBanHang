@extends('admin.layouts.app')

@section('title', 'Sửa Người dùng')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900" style="font-size: 1.875rem;">Sửa Người dùng</h1>
    <p class="mt-1 text-sm text-gray-600">Cập nhật thông tin người dùng</p>
</div>

<div class="bg-white shadow rounded-lg p-6">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 gap-6 max-w-2xl">
            <div>
                <label class="block text-sm font-medium text-gray-700">Tên</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Mật khẩu (Để trống nếu không đổi)</label>
                <input type="password" name="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Xác nhận Mật khẩu</label>
                <input type="password" name="password_confirmation"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Vai trò</label>
                <select name="role" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="flex justify-end pt-4">
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 mr-3">
                    Hủy
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Cập nhật
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
