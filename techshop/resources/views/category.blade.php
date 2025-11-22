@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <nav class="text-sm text-gray-600 mb-4">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Trang chủ</a>
        <span class="mx-2">/</span>
        <span class="font-semibold">{{ $category->name ?? 'Danh mục' }}</span>
    </nav>
    <!-- Banner under breadcrumb -->
    <div class="my-6">
        <a href="#" class="block">
            <img src="https://file.hstatic.net/200000722513/file/thang_06_banner_collections_1920x420_-_web_header.png"
                alt="Banner" class="w-full rounded-lg shadow-sm object-cover">
        </a>
    </div>

    <h1 class="text-2xl font-bold mb-6">{{ $category->name ?? 'Danh mục' }}</h1>


    @if(isset($products) && $products->count())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach($products as $product)
        @php $img = $product->images->where('is_main', true)->first() ?? $product->images->first(); @endphp
        <div class="relative bg-white rounded-lg p-4 shadow hover:shadow-md overflow-hidden flex flex-col">
            @if($product->discount_price && $product->price)
            @php $pct = round(100 - ($product->discount_price / max($product->price,1) * 100)); @endphp
            <div class="absolute top-3 left-3 z-20 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-lg">
                -{{ $pct }}%</div>
            @endif

            <div class="flex-1 flex items-center justify-center mb-3">
                <div class="bg-white rounded-lg p-3 w-full h-32 flex items-center justify-center">
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
                            <img src="https://cdn-icons-png.flaticon.com/512/679/679720.png"
                                class="max-h-full max-w-full" alt="no image">
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="text-xs text-gray-500">{{ optional($product->inventoryItem->category)->name ?? '' }}</div>
            <a href="{{ route('productInformation', $product->id) }}"
                class="text-sm font-semibold text-gray-900 block my-1 line-clamp-2">{{ $product->name }}</a>

            <div class="mb-2">
                @if($product->discount_price)
                <div class="text-red-600 text-xl font-extrabold">{{ number_format($product->discount_price) }}đ</div>
                <div class="text-sm text-gray-400 line-through">{{ number_format($product->price) }}đ</div>
                @else
                <div class="text-gray-900 text-lg font-bold">{{ number_format($product->price) }}đ</div>
                @endif
            </div>

            <button type="button" data-url="{{ route('cart.add') }}" data-product-id="{{ $product->id }}"
                data-method="post" @if($product->stock <= 0) disabled @endif
                    class="js-add-to-cart absolute bottom-3 right-3 z-10 inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-xl hover:bg-blue-700 shadow-lg @if($product->stock <= 0) opacity-60 cursor-not-allowed pointer-events-none @endif">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>
            </button>
            <div class="mt-1 flex items-center text-yellow-400 text-sm">
                                ★★★★★
                                <span class="text-gray-500 text-xs ml-1">(0 đánh giá)</span>
                                <!-- cart button moved to absolute position inside card -->
                            </div>


        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
    @else
    <div class="text-gray-500">Không có sản phẩm trong danh mục này.</div>
    @endif
</div>
@endsection