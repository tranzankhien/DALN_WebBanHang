@extends('admin.layouts.app')

@section('title', 'Quản lý Danh mục')

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
<div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
    <div class="flex items-center">
        <svg class="w-6 h-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-green-700 font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
    <div class="flex items-center">
        <svg class="w-6 h-6 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <p class="text-red-700 font-medium">{{ session('error') }}</p>
    </div>
</div>
@endif

<!-- Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 flex items-center">
                <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
                Quản lý Danh mục
            </h1>
            <p class="mt-2 text-sm text-gray-600">Quản lý danh mục sản phẩm và cấu trúc phân cấp</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg font-semibold text-white hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5" style="border-radius: 30px; background-color: #000000ff;">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Thêm danh mục mới
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="flex gap-6 mb-8 w-full">
    <!-- Card 1: Tổng danh mục - Màu Xanh Dương -->
    <div class="flex-1 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h1 class="text-lg font-semibold text-black" style="font-size: 24px">TỔNG DANH MỤC</h1>
                <h2 class="text-5xl font-bold text-gray-800 mb-4">{{ $categories->count() }}</h2>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    <span class="text-green-500 font-semibold mr-1">{{ $categories->count() }}</span>
                    <span class="text-gray-400">danh mục hiện có</span>
                </div>
            </div>
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Card 2: Đang hoạt động - Màu Xanh Lá -->
    <div class="flex-1 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h1 class="text-lg font-semibold text-black" style="font-size: 24px">ĐANG HOẠT ĐỘNG</h1>
                <h2 class="text-5xl font-bold text-gray-800 mb-4">{{ $categories->where('status', 'active')->count() }}</h2>
                <div class="flex items-center text-sm">
                    @php
                        $activePercent = $categories->count() > 0 ? ($categories->where('status', 'active')->count() / $categories->count()) * 100 : 0;
                    @endphp
                    @if($activePercent >= 50)
                        <svg class="w-4 h-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        <span class="text-green-500 font-semibold mr-1">{{ number_format($activePercent, 0) }}%</span>
                    @else
                        <svg class="w-4 h-4 text-red-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        <span class="text-red-500 font-semibold mr-1">{{ number_format($activePercent, 0) }}%</span>
                    @endif
                    <span class="text-gray-400">đang kích hoạt</span>
                </div>
            </div>
            <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Card 3: Tổng thuộc tính - Màu Tím -->
    <div class="flex-1 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6">
        <div class="flex items-start justify-between mb-4">
            <div class="flex-1">
                <h1 class="text-lg font-semibold text-black" style="font-size: 24px">TỔNG THUỘC TÍNH</h1>
                <h2 class="text-5xl font-bold text-gray-800 mb-4">{{ $categories->sum(fn($cat) => $cat->productAttributes->count()) }}</h2>
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="text-blue-500 font-semibold mr-1">
                        {{ $categories->count() > 0 ? number_format($categories->sum(fn($cat) => $cat->productAttributes->count()) / $categories->count(), 1) : 0 }}
                    </span>
                    <span class="text-gray-400">trung bình/danh mục</span>
                </div>
            </div>
            <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex-1">
            <div class="relative">
                <input type="text" 
                       id="searchInput" 
                       placeholder="Tìm kiếm theo tên, slug..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
        <div class="flex gap-3">
            <select id="statusFilter" class="px-4 py-2 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 font-medium transition-all">
                <option value="">🔍 Tất cả trạng thái</option>
                <option value="active">✅ Hoạt động</option>
                <option value="inactive">⛔ Không hoạt động</option>
            </select>
        </div>
    </div>
</div>

<!-- Categories Table -->
<div class="bg-white shadow-2xl rounded-2xl overflow-hidden border-2 border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200" id="categoriesTable">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Tên danh mục
                        </div>
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-black text-gray-700 uppercase tracking-wider">Slug</th>
                    <th class="px-6 py-4 text-center text-xs font-black text-gray-700 uppercase tracking-wider">Thuộc tính</th>
                    <th class="px-6 py-4 text-center text-xs font-black text-gray-700 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-4 text-center text-xs font-black text-gray-700 uppercase tracking-wider">Thứ tự</th>
                    <th class="px-6 py-4 text-center text-xs font-black text-gray-700 uppercase tracking-wider">Sản phẩm</th>
                    <th class="px-6 py-4 text-right text-xs font-black text-gray-700 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($categories as $category)
                    <tr class="hover:bg-blue-50 transition-all duration-200 category-row transform hover:scale-[1.01]" 
                        data-status="{{ $category->status }}"
                        data-name="{{ strtolower($category->name) }}"
                        data-slug="{{ strtolower($category->slug) }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900">{{ $category->name }}</div>
                                    @if($category->description)
                                        <div class="text-xs text-gray-500 truncate max-w-xs mt-1">{{ Str::limit($category->description, 50) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <code class="text-xs bg-gray-100 text-gray-800 px-3 py-1.5 rounded-lg font-mono font-semibold">{{ $category->slug }}</code>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ $category->productAttributes->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-bold rounded-full 
                                {{ $category->status == 'active' ? 'bg-green-100 text-green-800 border-2 border-green-300' : 'bg-gray-100 text-gray-800 border-2 border-gray-300' }}">
                                {{ $category->status == 'active' ? '✓ Hoạt động' : '✗ Tắt' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 text-blue-700 text-sm font-black border-2 border-blue-200">
                                {{ $category->display_order }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                {{ $category->inventoryItems->count() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center space-x-2">
                                <a href="{{ route('admin.categories.show', $category->id) }}" 
                                   class="text-blue-600 hover:text-white p-2.5 hover:bg-blue-600 rounded-xl transition-all transform hover:scale-110 shadow-md hover:shadow-lg"
                                   title="Xem chi tiết">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                   class="text-indigo-600 hover:text-white p-2.5 hover:bg-indigo-600 rounded-xl transition-all transform hover:scale-110 shadow-md hover:shadow-lg"
                                   title="Chỉnh sửa">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này? Hành động này không thể hoàn tác!');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-white p-2.5 hover:bg-red-600 rounded-xl transition-all transform hover:scale-110 shadow-md hover:shadow-lg"
                                            title="Xóa">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="mt-4 text-gray-500 text-lg font-medium">Chưa có danh mục nào</p>
                            <p class="mt-2 text-gray-400 text-sm">Tạo danh mục đầu tiên để bắt đầu quản lý sản phẩm</p>
                            <a href="{{ route('admin.categories.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tạo danh mục mới
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- No results message -->
<div id="noResults" class="hidden bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-6 text-center">
    <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
    </svg>
    <p class="mt-2 text-gray-600 font-medium">Không tìm thấy danh mục nào phù hợp</p>
    <p class="text-gray-500 text-sm">Thử thay đổi bộ lọc hoặc từ khóa tìm kiếm</p>
</div>

@push('scripts')
<script>
// Search and filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const typeFilter = document.getElementById('typeFilter');
    const rows = document.querySelectorAll('.category-row');
    const noResults = document.getElementById('noResults');
    
    function filterRows() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        let visibleCount = 0;
        
        rows.forEach(row => {
            const name = row.dataset.name;
            const slug = row.dataset.slug;
            const status = row.dataset.status;
            
            const matchesSearch = name.includes(searchTerm) || slug.includes(searchTerm);
            const matchesStatus = !statusValue || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }
    
    searchInput.addEventListener('input', filterRows);
    statusFilter.addEventListener('change', filterRows);
});

// Auto-hide success/error messages after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>
@endpush
@endsection
