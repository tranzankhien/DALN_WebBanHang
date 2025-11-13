<div class="w-full max-w-sm md:max-w-lg relative">

    {{-- Small header search: submits to full-results page on Enter --}}
   <form action="{{ route('products.search') }}" method="GET" class="w-full relative">
        <div class="relative">
            <input
                name="keyword"
                type="text"
                wire:model.debounce.300ms="search"
                placeholder="Tìm sản phẩm..."
                class="w-full px-3 py-1.5 pr-9 text-sm border border-gray-200 rounded-md focus:ring-2 focus:ring-blue-400 focus:border-transparent bg-white"
                autocomplete="off"
            >
            <button type="submit"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-blue-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </form>

</div>
