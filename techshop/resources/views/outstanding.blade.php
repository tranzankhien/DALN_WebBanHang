@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="text-sm text-gray-600 mb-4">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Trang chủ</a>
        <span class="mx-2">/</span>
        <span class="font-semibold">Sản phẩm nổi bật</span>
    </nav>

    <h1 class="text-2xl font-bold mb-6">Sản phẩm nổi bật</h1>

    @if(isset($products) && $products->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach($products as $product)
        @php $img = $product->images->where('is_main', true)->first() ?? $product->images->first(); @endphp
        <a href="{{ route('productInformation', $product->id) }}" class="block bg-white rounded-lg p-3 shadow hover:shadow-md">
            <div class="h-40 bg-gray-100 flex items-center justify-center mb-3 overflow-hidden">
                @if($img)
                <img src="{{ $img->image_url }}" alt="{{ $product->name }}"
                     class="product-auto-fit max-h-full max-w-full object-contain"
                     data-fallback="https://cdn-icons-png.flaticon.com/512/679/679720.png">
                @else
                <div class="text-gray-300">No image</div>
                @endif
            </div>
            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
            <div class="text-sm text-gray-600">{{ $product->discount_price ? number_format($product->discount_price) : number_format($product->price) }}đ</div>
        </a>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
    @else
    <div class="text-gray-500">Không có sản phẩm nổi bật.</div>
    @endif
</div>
@endsection
