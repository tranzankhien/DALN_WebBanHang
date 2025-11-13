<div class="w-full max-w-2xl mx-auto relative hidden md:flex flex-1 mx-8">

    {{-- Form GET để khi nhấn Enter hoặc bấm tìm kiếm sẽ chuyển trang kết quả đầy đủ --}}
    <form action="{{ route('products.search') }}" method="GET" class="w-full relative">
        <div class="relative">
            <input
                name="keyword"
                type="text"
                wire:model.debounce.300ms="search"
                placeholder="Tìm kiếm sản phẩm..."
                class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                autocomplete="off"
            >
            <button type="submit"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </form>

</div>
