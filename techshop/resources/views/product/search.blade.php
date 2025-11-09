@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Kết quả tìm kiếm</h1>
        @if(!empty($keyword))
        <p class="text-sm text-gray-600">Từ khóa: <strong>{{ $keyword }}</strong></p>
        @endif
    </div>

    @if($products->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($products as $product)
        @php $img = $product->images->where('is_main', true)->first() ?? $product->images->first(); @endphp
        <a href="{{ route('productInformation', $product->id) }}" class="block bg-white rounded-lg p-3 shadow hover:shadow-md">
            <div class="h-36 bg-gray-100 flex items-center justify-center overflow-hidden mb-2">
                @if($img)
                <img src="{{ $img->image_url }}" class="w-full h-full object-contain" alt="{{ $product->name }}">
                @else
                <div class="text-gray-300">No image</div>
                @endif
            </div>
            <div class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</div>
            <div class="text-sm text-gray-600">{{ number_format($product->price) }}đ</div>
        </a>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg p-6 text-center text-gray-600">
        Không tìm thấy sản phẩm nào.
    </div>
    @endif
</div>
@endsection
