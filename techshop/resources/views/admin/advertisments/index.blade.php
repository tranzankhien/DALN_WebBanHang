@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Quản lý Quảng cáo</h1>
        <a href="{{ route('admin.advertisments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Thêm quảng cáo</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded">
        <table class="w-full table-auto">
            <thead>
                <tr class="text-left border-b">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Link</th>
                    <th class="px-4 py-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($adverts as $ad)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $ad->id_advert }}</td>
                    <td class="px-4 py-2 break-words"><a href="{{ $ad->link_url }}" target="_blank">{{ $ad->link_url }}</a></td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.advertisments.edit', $ad->id_advert) }}" class="mr-2 text-blue-600">Sửa</a>
                        <form action="{{ route('admin.advertisments.destroy', $ad->id_advert) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Xóa quảng cáo này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">Chưa có quảng cáo nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
