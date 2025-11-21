<div class="w-full max-w-sm md:max-w-lg relative" x-data="{ open: false }" @click.away="open = false">
    {{-- Small header search: submits to full-results page on Enter --}}
    <form action="{{ route('products.search') }}" method="GET" class="w-full relative">
        <div class="relative flex items-center">
            <input
                name="keyword"
                type="text"
                wire:model.live.debounce.300ms="search"
                @focus="open = true"
                @input="open = true"
                placeholder="Tìm kiếm sản phẩm..."
                class="w-full px-4 py-2 pr-10 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm"
                autocomplete="off"
            >
            <button type="submit"
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </form>

    {{-- Dropdown Results --}}
    @if(strlen($search) >= 1)
        <div x-show="open" 
             class="absolute z-50 w-full mt-1 bg-white rounded-md shadow-lg border border-gray-200 max-h-96 overflow-y-auto">
            
            @if($products->count() > 0)
                <div class="py-2">
                    @foreach($products as $product)
                        <a href="{{ route('productInformation', $product->id) }}" class="flex items-center px-4 py-2 hover:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="flex-shrink-0 h-10 w-10">
                                @php
                                    $image = $product->images->where('is_main', true)->first() ?? $product->images->first();
                                @endphp
                                <img class="h-10 w-10 rounded object-contain" 
                                     src="{{ $image ? $image->image_url : 'https://via.placeholder.com/40' }}" 
                                     alt="{{ $product->name }}">
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }}đ
                                </p>
                            </div>
                        </a>
                    @endforeach
                    
                    @if($totalProducts > 5)
                        <a href="{{ route('products.search', ['keyword' => $search]) }}" class="block px-4 py-2 text-sm text-center text-blue-600 font-medium hover:bg-gray-50 border-t border-gray-100">
                            Xem tất cả {{ $totalProducts }} kết quả
                        </a>
                    @endif
                </div>
            @else
                <div class="px-4 py-3 text-sm text-gray-500 text-center">
                    Không tìm thấy sản phẩm nào khớp với "{{ $search }}"
                </div>
            @endif
        </div>
    @endif

</div>
