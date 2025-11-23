<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Xác nhận đơn hàng - TechShop</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>
<body class="antialiased bg-gray-50">
    <!-- Navigation Header -->
    @include('layouts.navigation')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center space-x-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="ml-2 text-green-600 font-medium">Thông tin giao hàng</span>
                </div>
                <div class="w-16 h-1 bg-blue-600"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                        2
                    </div>
                    <span class="ml-2 text-blue-600 font-medium">Xác nhận đơn hàng</span>
                </div>
                <div class="w-16 h-1 bg-gray-300"></div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold">
                        3
                    </div>
                    <span class="ml-2 text-gray-500">Hoàn thành</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Order Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Shipping Information -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">Thông tin giao hàng</h2>
                        <button type="button" id="edit-shipping-btn" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                            Chỉnh sửa
                        </button>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4 space-y-2" id="shipping-info-display">
                        <div class="flex">
                            <span class="w-32 text-gray-600">Người nhận:</span>
                            <span class="font-medium text-gray-900" id="display-name">{{ $validated['shipping_name'] }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-600">Số điện thoại:</span>
                            <span class="font-medium text-gray-900" id="display-phone">{{ $validated['shipping_phone'] }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 text-gray-600">Địa chỉ:</span>
                            <span class="font-medium text-gray-900" id="display-address">
                                {{ $validated['shipping_address'] }}
                                @if($validated['shipping_ward'])<span id="display-ward">, {{ $validated['shipping_ward'] }}</span>@endif
                                @if($validated['shipping_district'])<span id="display-district">, {{ $validated['shipping_district'] }}</span>@endif
                                @if($validated['shipping_city'])<span id="display-city">, {{ $validated['shipping_city'] }}</span>@endif
                            </span>
                        </div>
                        @if($validated['customer_note'])
                        <div class="flex">
                            <span class="w-32 text-gray-600">Ghi chú:</span>
                            <span class="font-medium text-gray-900" id="display-note">{{ $validated['customer_note'] }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Edit Form (Hidden) -->
                    <div id="shipping-edit-form" class="hidden mt-4">
                        <form id="update-shipping-form" class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Họ và tên</label>
                                <input type="text" name="shipping_name" value="{{ $validated['shipping_name'] }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                                <input type="tel" name="shipping_phone" value="{{ $validated['shipping_phone'] }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Địa chỉ</label>
                                <input type="text" name="shipping_address" value="{{ $validated['shipping_address'] }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            <div class="grid grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phường/Xã</label>
                                    <input type="text" name="shipping_ward" value="{{ $validated['shipping_ward'] ?? '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Quận/Huyện</label>
                                    <input type="text" name="shipping_district" value="{{ $validated['shipping_district'] ?? '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tỉnh/Thành</label>
                                    <input type="text" name="shipping_city" value="{{ $validated['shipping_city'] ?? '' }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ghi chú</label>
                                <textarea name="customer_note" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $validated['customer_note'] ?? '' }}</textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="submit" class="flex-1 bg-blue-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-700 transition">
                                    Lưu thay đổi
                                </button>
                                <button type="button" id="cancel-edit-btn" class="flex-1 bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg hover:bg-gray-300 transition">
                                    Hủy
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Sản phẩm đã chọn</h2>
                    
                    @if(isset($isBuyNow) && $isBuyNow)
                    <div class="mb-4 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                        <div class="flex items-center gap-2 text-orange-700 text-sm font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Đơn hàng Mua Ngay - Sản phẩm không nằm trong giỏ hàng
                        </div>
                    </div>
                    @endif
                    
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                        @php
                            $mainImage = $item->product->images->where('is_main', true)->first() ?? $item->product->images->first();
                            $price = $item->product->discount_price ?? $item->product->price;
                        @endphp
                        <div class="flex items-center space-x-4 pb-4 border-b last:border-b-0">
                            @if($mainImage)
                            <img src="{{ $mainImage->image_url }}" alt="{{ $item->product->name }}" class="w-20 h-20 object-cover rounded">
                            @else
                            <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500">Số lượng: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">{{ number_format($price) }}đ × {{ $item->quantity }}</p>
                                <p class="font-semibold text-blue-600">{{ number_format($price * $item->quantity) }}đ</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary & Actions -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Tổng đơn hàng</h2>

                    <!-- Price Summary -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Tạm tính:</span>
                            <span>{{ number_format($subtotal) }}đ</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Phí vận chuyển:</span>
                            <span>{{ number_format($shippingFee) }}đ</span>
                        </div>
                        <div class="flex justify-between text-gray-600 text-sm">
                            <span>Thanh toán:</span>
                            <span class="font-medium">
                                @if($validated['payment_method'] === 'cod')
                                    COD
                                @else
                                    VNPay
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between text-2xl font-bold text-gray-900 pt-3 border-t">
                            <span>Tổng cộng:</span>
                            <span class="text-red-600">{{ number_format($total) }}đ</span>
                        </div>
                    </div>

                    <!-- Confirm Order Button -->
                    <form action="{{ route('checkout.place-order') }}" method="POST" id="order-form">
                        @csrf
                        @if($validated['payment_method'] === 'cod')
                            <!-- COD: Direct order placement -->
                            <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white font-bold py-3 px-6 rounded-lg hover:shadow-lg transition duration-300 mb-3">
                                ✓ Xác nhận đặt hàng
                            </button>
                        @else
                            <!-- Bank Transfer: Show VNPay payment option -->
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3 px-6 rounded-lg hover:shadow-lg transition duration-300 mb-3">
                                💳 Thanh toán qua VNPay
                            </button>
                            
                            <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-xs text-blue-700 text-center">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Bạn sẽ được chuyển đến trang thanh toán VNPay
                                </p>
                            </div>
                        @endif
                    </form>

                    <a href="{{ route('checkout.index') }}" class="block text-center text-blue-600 hover:text-blue-700 font-medium">
                        ← Quay lại
                    </a>

                    <!-- Terms -->
                    <div class="mt-6 pt-6 border-t text-xs text-gray-500 space-y-2">
                        <p>Bằng việc đặt hàng, bạn đồng ý với:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Điều khoản sử dụng</li>
                            <li>Chính sách bảo mật</li>
                            <li>Chính sách đổi trả hàng</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const editBtn = document.getElementById('edit-shipping-btn');
        const cancelBtn = document.getElementById('cancel-edit-btn');
        const displayDiv = document.getElementById('shipping-info-display');
        const editForm = document.getElementById('shipping-edit-form');
        const updateForm = document.getElementById('update-shipping-form');
        
        // Show edit form
        editBtn.addEventListener('click', function() {
            displayDiv.classList.add('hidden');
            editForm.classList.remove('hidden');
        });
        
        // Cancel edit
        cancelBtn.addEventListener('click', function() {
            editForm.classList.add('hidden');
            displayDiv.classList.remove('hidden');
        });
        
        // Handle form submission
        updateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(updateForm);
            
            // Update display values
            document.getElementById('display-name').textContent = formData.get('shipping_name');
            document.getElementById('display-phone').textContent = formData.get('shipping_phone');
            
            let addressText = formData.get('shipping_address');
            if (formData.get('shipping_ward')) {
                addressText += ', ' + formData.get('shipping_ward');
            }
            if (formData.get('shipping_district')) {
                addressText += ', ' + formData.get('shipping_district');
            }
            if (formData.get('shipping_city')) {
                addressText += ', ' + formData.get('shipping_city');
            }
            document.getElementById('display-address').textContent = addressText;
            
            const noteDisplay = document.getElementById('display-note');
            if (noteDisplay && formData.get('customer_note')) {
                noteDisplay.textContent = formData.get('customer_note');
            }
            
            // Update session via AJAX
            fetch('{{ route("checkout.review") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    shipping_name: formData.get('shipping_name'),
                    shipping_phone: formData.get('shipping_phone'),
                    shipping_address: formData.get('shipping_address'),
                    shipping_ward: formData.get('shipping_ward'),
                    shipping_district: formData.get('shipping_district'),
                    shipping_city: formData.get('shipping_city'),
                    customer_note: formData.get('customer_note'),
                    payment_method: '{{ $validated["payment_method"] }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                // Hide form, show display
                editForm.classList.add('hidden');
                displayDiv.classList.remove('hidden');
                
                // Show success message
                const successDiv = document.createElement('div');
                successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                successDiv.textContent = '✓ Đã cập nhật thông tin giao hàng';
                document.body.appendChild(successDiv);
                
                setTimeout(() => {
                    successDiv.remove();
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi cập nhật thông tin!');
            });
        });
    });
    </script>
    @livewireScripts
</body>
</html>
