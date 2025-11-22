@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('content')
<div class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-blue-600">Trang chủ</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-400">{{ $keyword }}</span>
        </div>
    </div>
</div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Kết quả tìm kiếm</h1>
        @if(!empty($keyword))
        <p class="text-sm text-gray-600">Từ khóa: <strong class="text-red-600"><em>{{ $keyword }} </em></strong></p>
        @endif
    </div>

    @if($products->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($products as $product)
        @php $img = $product->images->where('is_main', true)->first() ?? $product->images->first(); @endphp
        <div class="relative bg-white rounded-lg p-3 shadow hover:shadow-md overflow-hidden">
            @if($product->discount_price && $product->price)
            @php $pct = round(100 - ($product->discount_price / max($product->price,1) * 100)); @endphp
            <div class="absolute top-3 left-3 z-20 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-md">
                -{{ $pct }}%</div>
            @endif

            <div class="h-40 bg-gray-50 flex items-center justify-center p-4">
                @if($img)
                <a href="{{ route('productInformation', $product->id) }}"
                    class="block w-full h-full flex items-center justify-center">
                    <img src="{{ $img->image_url }}" alt="{{ $product->name }}"
                        class="max-h-full max-w-full object-contain"
                        data-fallback="https://cdn-icons-png.flaticon.com/512/679/679720.png"
                        onerror="this.src=this.dataset.fallback">
                </a>
                @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <img src="https://cdn-icons-png.flaticon.com/512/679/679720.png" class="max-h-full max-w-full"
                        alt="no image">
                </div>
                @endif
            </div>


            <a href="{{ route('productInformation', $product->id) }}"
                class="text-sm font-semibold text-gray-900 truncate block mb-1">{{ $product->name }}</a>
            <div class="mb-2">
                @if($product->discount_price)
                <div class="text-red-600 text-lg font-extrabold">{{ number_format($product->discount_price) }}đ</div>
                <div class="text-sm text-gray-400 line-through">{{ number_format($product->price) }}đ</div>
                @else
                <div class="text-gray-900 text-lg font-bold">{{ number_format($product->price) }}đ</div>
                @endif
            </div>
            <div class="mt-1 flex items-center text-yellow-400 text-sm">
                ★★★★★
                <span class="text-gray-500 text-xs ml-1">(0 đánh giá)</span>
                <!-- cart button moved to absolute position inside card -->
            </div>

            <button type="button" data-url="{{ route('cart.add') }}" data-product-id="{{ $product->id }}"
                data-method="post" @if($product->stock <= 0) disabled @endif
                    class="js-add-to-cart absolute bottom-3 right-3 z-10 inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-lg @if($product->stock <= 0) opacity-60 cursor-not-allowed pointer-events-none @endif">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
            </button>

        </div>
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