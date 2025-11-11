<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giỏ hàng — TechShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <!-- Header / Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}"
                        class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                        TechShop
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                        Trang chủ
                    </a>
                    @auth
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100">
                            @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full">
                            @else
                            <div
                                class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            @endif
                            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50"
                            style="display: none;">
                            @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                Quản trị
                            </a>
                            @endif
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50">
                                Tài khoản
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                        Đăng nhập
                    </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-32">
        <!-- Page Title -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                    <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Giỏ Hàng
                </h1>
            </div>
            @if($cartItems->count() > 0)
            <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Xóa toàn bộ giỏ hàng?')"
                    class="text-red-600 hover:text-red-800 font-medium text-sm flex items-center gap-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Xóa tất cả
                </button>
            </form>
            @endif
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        @if($cartItems->count() > 0)
        <!-- Cart Header -->
        <div class="bg-white rounded-t-lg shadow-sm p-4 mb-2">
            <div class="flex items-center">
                <div class="flex items-center flex-1">
                    <input type="checkbox" id="select-all" onchange="toggleSelectAll(this)" 
                        class="w-5 h-5 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                    <label for="select-all" class="ml-3 text-sm font-medium text-gray-700">Chọn Tất Cả ({{ $cartItems->count() }})</label>
                </div>
                <div class="hidden md:flex items-center gap-8 text-sm text-gray-600">
                    <span class="w-32 text-center">Đơn Giá</span>
                    <span class="w-24 text-center">Số Lượng</span>
                    <span class="w-32 text-center">Số Tiền</span>
                    <span class="w-16 text-center">Thao Tác</span>
                </div>
            </div>
        </div>

        <!-- Cart Items -->
        <div class="space-y-2">
            @foreach($cartItems as $item)
            @php
                $mainImage = $item->product->images->where('is_main', true)->first() ?? $item->product->images->first();
                $price = $item->product->discount_price ?? $item->product->price;
                $itemTotal = $price * $item->quantity;
            @endphp
            <div class="bg-white rounded-lg shadow-sm p-4 hover:shadow-md transition">
                <div class="flex items-start gap-4">
                    <!-- Checkbox -->
                    <div class="flex items-center pt-2">
                        <input type="checkbox" class="item-checkbox w-5 h-5 text-orange-500 border-gray-300 rounded focus:ring-orange-500"
                            data-item-id="{{ $item->id }}"
                            data-price="{{ $price }}" 
                            data-quantity="{{ $item->quantity }}" 
                            onchange="updateTotal()">
                    </div>

                    <!-- Product Image -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('productInformation', $item->product->id) }}">
                            @if($mainImage)
                            <img src="{{ $mainImage->image_url }}" alt="{{ $item->product->name }}"
                                class="w-20 h-20 object-contain rounded border border-gray-200">
                            @else
                            <div class="w-20 h-20 bg-gray-100 rounded flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </a>
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1 flex items-center gap-4">
                        <!-- Name -->
                        <div class="flex-1">
                            <a href="{{ route('productInformation', $item->product->id) }}"
                                class="text-sm text-gray-900 hover:text-orange-500 line-clamp-2">
                                {{ $item->product->name }}
                            </a>
                            
                            <!-- Product Attributes -->
                            @if($item->product->inventoryItem && $item->product->inventoryItem->attributeValues->count() > 0)
                            <div class="mt-1 flex flex-wrap gap-x-3 gap-y-1">
                                @foreach($item->product->inventoryItem->attributeValues->take(3) as $av)
                                <span class="text-xs text-gray-500">
                                    {{ $av->attribute->name }}: <span class="text-gray-700 font-medium">{{ $av->value }}</span>
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <!-- Price -->
                        <div class="w-32 text-center hidden md:block">
                            <div class="text-base font-semibold text-gray-900">
                                ₫{{ number_format($price, 0, ',', '.') }}
                            </div>
                            @if($item->product->discount_price)
                            <div class="text-xs text-gray-400 line-through">
                                ₫{{ number_format($item->product->price, 0, ',', '.') }}
                            </div>
                            @endif
                        </div>

                        <!-- Quantity -->
                        <div class="w-24 hidden md:block">
                            <div class="flex items-center justify-center">
                                <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                                    <button type="button" onclick="updateQuantity(this, -1, {{ $item->id }}, {{ $item->product->stock }})" 
                                        class="px-3 py-2 hover:bg-gray-100 text-gray-600 border-r border-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="text" 
                                        id="qty-{{ $item->id }}"
                                        data-item-id="{{ $item->id }}"
                                        value="{{ $item->quantity }}" 
                                        class="w-16 text-center text-base font-medium py-2 border-0 focus:ring-0 bg-white"
                                        readonly
                                        style="pointer-events: none;">
                                    <button type="button" onclick="updateQuantity(this, 1, {{ $item->id }}, {{ $item->product->stock }})" 
                                        class="px-3 py-2 hover:bg-gray-100 text-gray-600 border-l border-gray-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <form id="update-form-{{ $item->id }}" action="{{ route('cart.update', $item->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                            </form>
                        </div>

                        <!-- Total -->
                        <div class="w-32 text-center hidden md:block">
                            <div id="item-total-{{ $item->id }}" class="text-base font-bold text-orange-500">
                                ₫{{ number_format($itemTotal, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Delete -->
                        <div class="w-16 text-center hidden md:block">
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Xóa sản phẩm này?')"
                                    class="text-gray-400 hover:text-red-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <!-- Mobile Actions -->
                        <div class="md:hidden flex flex-col gap-2">
                            <div class="text-base font-semibold text-orange-500">
                                ₫{{ number_format($price, 0, ',', '.') }}
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                                    <button type="button" onclick="updateQuantity(this, -1, {{ $item->id }}, {{ $item->product->stock }})" class="px-2 py-1 hover:bg-gray-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="text" 
                                        id="qty-mobile-{{ $item->id }}"
                                        value="{{ $item->quantity }}" 
                                        class="w-12 text-center text-base font-medium py-1 border-0 focus:ring-0 bg-white"
                                        readonly
                                        style="pointer-events: none;">
                                    <button type="button" onclick="updateQuantity(this, 1, {{ $item->id }}, {{ $item->product->stock }})" class="px-2 py-1 hover:bg-gray-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                                <!-- Mobile Delete Button -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Xóa sản phẩm này?')"
                                        class="text-gray-400 hover:text-red-500 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <!-- Mobile Item Total -->
                            <div id="item-total-mobile-{{ $item->id }}" class="text-sm font-bold text-orange-500">
                                Tổng: ₫{{ number_format($itemTotal, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty Cart -->
        <div class="bg-white rounded-lg shadow-lg p-12 text-center">
            <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Giỏ hàng trống</h2>
            <p class="text-gray-600 mb-6">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
            <a href="{{ route('home') }}" 
                class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-lg hover:shadow-lg transition">
                Khám phá sản phẩm
            </a>
        </div>
        @endif
    </div>

    <!-- Fixed Bottom Bar - Shopee Style (Outside main container) -->
    @if($cartItems->count() > 0)
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t-2 border-gray-200 shadow-2xl z-50" style="position: fixed !important; bottom: 0 !important; left: 0 !important; right: 0 !important; background-color: #00000010 !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Left Side: Select All & Delete -->
                <div class="flex items-center gap-4 sm:gap-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="select-all-bottom" onchange="toggleSelectAll(this)" 
                            class="w-5 h-5 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                        <label for="select-all-bottom" class="ml-2 text-sm font-medium text-gray-700">Chọn Tất Cả</label>
                    </div>
                    <!-- <button onclick="deleteSelected()" class="text-sm text-gray-600 hover:text-red-500 font-medium">
                        Xóa
                    </button> -->
                </div>

                <!-- Right Side: Total & Checkout -->
                <div class="flex items-center gap-4 sm:gap-6" style="background-color: #ffffffff; padding: 10px; border-radius: 8px;">
                    <div class="text-right">
                        <div class="text-xs sm:text-sm text-gray-600">
                            Tổng thanh toán (<span id="selected-count">0</span> Sản phẩm):
                        </div>
                        <div class="text-xl sm:text-2xl font-bold text-orange-500">
                            ₫<span id="total-amount">0</span>
                        </div>
                    </div>
                    <button onclick="checkout()" 
                        class="px-8 sm:px-12 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded text-sm sm:text-base shadow-lg transition-all uppercase" style="background-color: #dd3704ff !important;">
                        Mua Hàng
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script>
        // Toggle select all checkboxes
        function toggleSelectAll(checkbox) {
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            const selectAllTop = document.getElementById('select-all');
            const selectAllBottom = document.getElementById('select-all-bottom');
            
            itemCheckboxes.forEach(cb => cb.checked = checkbox.checked);
            selectAllTop.checked = checkbox.checked;
            selectAllBottom.checked = checkbox.checked;
            
            updateTotal();
        }

        // Update total amount
        function updateTotal() {
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');
            let total = 0;
            let count = 0;

            checkboxes.forEach(cb => {
                const price = parseFloat(cb.getAttribute('data-price'));
                const quantity = parseInt(cb.getAttribute('data-quantity'));
                total += price * quantity;
                count++;
            });

            document.getElementById('total-amount').textContent = total.toLocaleString('vi-VN');
            document.getElementById('selected-count').textContent = count;

            // Update select all checkboxes
            const allCheckboxes = document.querySelectorAll('.item-checkbox');
            const allChecked = allCheckboxes.length > 0 && checkboxes.length === allCheckboxes.length;
            document.getElementById('select-all').checked = allChecked;
            document.getElementById('select-all-bottom').checked = allChecked;
        }

        // Update quantity (new function for +/- buttons)
        function updateQuantity(button, delta, itemId, maxStock) {
            // Get current quantity from display inputs
            const displayInput = document.getElementById('qty-' + itemId);
            const displayInputMobile = document.getElementById('qty-mobile-' + itemId);
            let currentQty = parseInt(displayInput.value);
            
            // Calculate new quantity
            let newQty = currentQty + delta;
            
            // Enforce bounds (min: 1, max: stock)
            if (newQty < 1) {
                alert('Số lượng tối thiểu là 1');
                return;
            }
            if (newQty > maxStock) {
                alert('Không đủ hàng trong kho. Số lượng tối đa: ' + maxStock);
                return;
            }
            
            // Disable button to prevent double-click
            button.disabled = true;
            
            // Update display inputs
            displayInput.value = newQty;
            if (displayInputMobile) {
                displayInputMobile.value = newQty;
            }
            
            // Update hidden form input
            const hiddenInput = document.querySelector('#update-form-' + itemId + ' input[name="quantity"]');
            hiddenInput.value = newQty;
            
            // Update checkbox data-quantity attribute
            const checkbox = document.querySelector('input[data-item-id="' + itemId + '"]');
            if (checkbox) {
                checkbox.setAttribute('data-quantity', newQty);
            }
            
            // Recalculate total
            updateTotal();
            
            // Submit form to update database
            const form = document.getElementById('update-form-' + itemId);
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update item total display (desktop)
                    const itemTotalElement = document.getElementById('item-total-' + itemId);
                    if (itemTotalElement && data.item) {
                        itemTotalElement.textContent = '₫' + (data.item.price * data.item.quantity).toLocaleString('vi-VN');
                    }
                    // Update item total display (mobile)
                    const itemTotalMobileElement = document.getElementById('item-total-mobile-' + itemId);
                    if (itemTotalMobileElement && data.item) {
                        itemTotalMobileElement.textContent = 'Tổng: ₫' + (data.item.price * data.item.quantity).toLocaleString('vi-VN');
                    }
                    // Re-enable button
                    button.disabled = false;
                } else {
                    alert(data.message || 'Có lỗi xảy ra');
                    // Revert on error
                    displayInput.value = currentQty;
                    if (displayInputMobile) {
                        displayInputMobile.value = currentQty;
                    }
                    checkbox.setAttribute('data-quantity', currentQty);
                    updateTotal();
                    button.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi cập nhật số lượng');
                // Revert on error
                displayInput.value = currentQty;
                if (displayInputMobile) {
                    displayInputMobile.value = currentQty;
                }
                checkbox.setAttribute('data-quantity', currentQty);
                updateTotal();
                button.disabled = false;
            });
        }

        // Delete selected items
        function deleteSelected() {
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Vui lòng chọn sản phẩm cần xóa!');
                return;
            }
            
            if (confirm(`Xóa ${checkboxes.length} sản phẩm đã chọn?`)) {
                // In a real implementation, you would send a request to delete multiple items
                // For now, we'll reload the page
                checkboxes.forEach((cb, index) => {
                    setTimeout(() => {
                        const deleteBtn = cb.closest('.bg-white').querySelector('form[method="POST"] button[type="submit"]');
                        if (deleteBtn) deleteBtn.click();
                    }, index * 100);
                });
            }
        }

        // Checkout
        function checkout() {
            const checkboxes = document.querySelectorAll('.item-checkbox:checked');
            if (checkboxes.length === 0) {
                alert('Vui lòng chọn sản phẩm cần mua!');
                return;
            }
            
            // Redirect to checkout page
            window.location.href = '{{ route("checkout.index") }}';
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateTotal();
        });
    </script>
</body>

</html>
