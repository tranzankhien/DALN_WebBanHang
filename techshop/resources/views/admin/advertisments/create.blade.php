@extends('admin.layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Thêm quảng cáo</h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.advertisments.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Link quảng cáo</label>
            <input type="url" name="link_url" value="{{ old('link_url') }}" class="w-full border rounded px-3 py-2" placeholder="https://example.com">
        </div>

        <div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Lưu</button>
            <a href="{{ route('admin.advertisments.index') }}" class="ml-2 text-gray-600">Hủy</a>
        </div>
    </form>
</div>
@endsection
