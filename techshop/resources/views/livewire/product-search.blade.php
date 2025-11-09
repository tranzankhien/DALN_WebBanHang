<div class="w-full max-w-lg mx-auto relative">

    {{-- Form GET để khi nhấn Enter hoặc bấm tìm kiếm sẽ chuyển trang kết quả đầy đủ --}}
    <form action="{{ route('products.search') }}" method="GET" class="relative">
        <input
            name="keyword"
            type="text"
            wire:model.debounce.300ms="search"
            placeholder="Tìm kiếm sản phẩm..."
            class="w-full p-2 border rounded"
            autocomplete="off"
        >

        <button type="submit" class="absolute right-1 top-1/2 -translate-y-1/2 px-3 py-1 text-sm text-white bg-blue-600 rounded">Tìm</button>
    </form>

    {{-- Dropdown gợi ý (hiển thị khi có từ khóa hoặc có kết quả) --}}
    @if(!empty($search) || (isset($products) && $products->count() > 0))
        <ul class="absolute bg-white border rounded w-full mt-1 shadow z-50 max-h-64 overflow-auto">
            @forelse($products as $product)
                <li class="px-3 py-2 hover:bg-gray-100">
                    <a href="{{ route('productInformation', $product->id) }}" class="block">
                        <div class="flex items-center gap-3">
                            @php $img = $product->images->where('is_main', true)->first() ?? $product->images->first(); @endphp
                            @if($img)
                                <img src="{{ $img->image_url }}" class="w-10 h-10 object-cover rounded" alt="">
                            @else
                                <div class="w-10 h-10 bg-gray-100 rounded"></div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</div>
                                <div class="text-xs text-gray-600">{{ number_format($product->price) }}đ</div>
                            </div>
                        </div>
                    </a>
                </li>
            @empty
                <li class="px-3 py-2 text-gray-500">Không tìm thấy sản phẩm nào.</li>
            @endforelse

            @if(isset($totalProducts) && $totalProducts > count($products))
                <li class="px-3 py-2 bg-gray-50 text-center">
                    <a href="{{ route('products.search', ['keyword' => $search]) }}" class="text-sm text-blue-600 font-medium">Xem tất cả {{ $totalProducts }} kết quả</a>
                </li>
            @endif
        </ul>
    @endif

</div>
