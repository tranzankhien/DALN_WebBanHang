<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Giỏ hàng — TechShop</title>
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 min-h-screen">
	@include('layouts.navigation')

	<main class="py-10">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="mb-8">
				<h1 class="text-3xl font-bold text-gray-900">Giỏ hàng của bạn</h1>
				<p class="text-sm text-gray-500 mt-1">Quản lý sản phẩm đã thêm và tiến hành thanh toán.</p>
			</div>

			@if(session('status'))
				<div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
					{{ session('status') }}
				</div>
			@endif

			@if(session('warning'))
				<div class="mb-6 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-sm text-yellow-800">
					{{ session('warning') }}
				</div>
			@endif

			@if($cartItems->isEmpty())
				<div class="rounded-2xl bg-white p-8 text-center shadow">
					<div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-50 text-blue-500">
						<svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
						</svg>
					</div>
					<h2 class="mt-6 text-xl font-semibold text-gray-900">Giỏ hàng trống</h2>
					<p class="mt-2 text-sm text-gray-600">Tiếp tục khám phá sản phẩm và thêm vào giỏ hàng để mua sắm.</p>
					<a href="{{ route('home') }}" class="mt-6 inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-3 text-sm font-semibold text-white shadow hover:from-blue-600 hover:to-blue-700">
						Tiếp tục mua sắm
					</a>
				</div>
			@else
				<div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
					<div class="lg:col-span-2 space-y-4">
						@foreach($cartItems as $item)
							@php
								$product = $item->product;
								if (!$product) {
									continue;
								}
								$unitPrice = (float) ($product->discount_price ?? $product->price);
								$lineTotal = $unitPrice * $item->quantity;
								$mainImage = $product->images->where('is_main', true)->first() ?? $product->images->first();
							@endphp

							<div class="rounded-2xl bg-white p-4 shadow">
								<div class="flex flex-col gap-4 md:flex-row md:items-center">
									<div class="h-28 w-28 flex-shrink-0 overflow-hidden rounded-xl bg-gray-100">
										@if($mainImage)
											<img src="{{ $mainImage->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-contain">
										@else
											<div class="flex h-full w-full items-center justify-center text-gray-300">No image</div>
										@endif
									</div>

									<div class="flex-1 space-y-2">
										<div class="flex items-start justify-between gap-4">
											<div>
												<a href="{{ route('productInformation', $product->id) }}" class="text-lg font-semibold text-gray-900 hover:text-blue-600">
													{{ $product->name }}
												</a>
												<div class="mt-1 text-sm text-gray-500">Kho còn: {{ max($product->stock, 0) }}</div>
											</div>
											<div class="text-right">
												<div class="text-lg font-semibold text-gray-900">{{ number_format($unitPrice, 0, ',', '.') }}₫</div>
												<div class="text-sm text-gray-500">Đơn giá</div>
											</div>
										</div>

										<div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
											<form method="POST" action="{{ route('cart.items.update', $item) }}" class="flex items-center gap-3">
												@csrf
												@method('PATCH')
												<label for="item-qty-{{ $item->id }}" class="text-sm font-medium text-gray-700">Số lượng</label>
												<div class="flex items-center rounded-lg border border-gray-300">
													<button type="button" class="px-3 py-2 text-gray-500 hover:text-blue-600" onclick="const input=document.getElementById('item-qty-{{ $item->id }}'); if(input.value>1){input.stepDown();}">
														<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
															<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
														</svg>
													</button>
													<input id="item-qty-{{ $item->id }}" name="quantity" type="number" min="1" max="{{ max($product->stock, 1) }}" value="{{ $item->quantity }}" class="w-16 border-0 text-center text-sm font-semibold focus:ring-0">
													<button type="button" class="px-3 py-2 text-gray-500 hover:text-blue-600" onclick="const input=document.getElementById('item-qty-{{ $item->id }}'); if(parseInt(input.value)<{{ max($product->stock, 1) }}){input.stepUp();}">
														<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
															<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
														</svg>
													</button>
												</div>
												<button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-600">Cập nhật</button>
											</form>

											<div class="flex items-center justify-between gap-4">
												<div class="text-right">
													<div class="text-xl font-semibold text-gray-900">{{ number_format($lineTotal, 0, ',', '.') }}₫</div>
													<div class="text-sm text-gray-500">Thành tiền</div>
												</div>
												<form method="POST" action="{{ route('cart.items.destroy', $item) }}">
													@csrf
													@method('DELETE')
													<button type="submit" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-600 hover:border-red-500 hover:text-red-500">
														Xóa
													</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach
					</div>

					<aside class="space-y-4">
						<div class="rounded-2xl bg-white p-6 shadow">
							<h2 class="text-xl font-semibold text-gray-900">Tóm tắt đơn hàng</h2>
							<dl class="mt-4 space-y-3 text-sm text-gray-600">
								<div class="flex items-center justify-between">
									<dt>Tổng sản phẩm</dt>
									<dd class="font-medium text-gray-900">{{ $totalQuantity }}</dd>
								</div>
								<div class="flex items-center justify-between">
									<dt>Tạm tính</dt>
									<dd class="font-medium text-gray-900">{{ number_format($subtotal, 0, ',', '.') }}₫</dd>
								</div>
								<div class="flex items-center justify-between">
									<dt>Phí vận chuyển</dt>
									<dd>Miễn phí</dd>
								</div>
							</dl>
							<div class="mt-6 border-t border-gray-200 pt-4">
								<div class="flex items-center justify-between text-lg font-semibold text-gray-900">
									<span>Tổng cộng</span>
									<span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
								</div>
							</div>
							<button type="button" class="mt-6 w-full rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-3 text-sm font-semibold text-white shadow hover:from-blue-600 hover:to-blue-700">
								Tiến hành thanh toán
							</button>
						</div>

						<div class="rounded-2xl border border-gray-200 bg-white p-6 text-sm text-gray-600 shadow-sm">
							<h3 class="text-base font-semibold text-gray-900">Ưu đãi dành cho bạn</h3>
							<ul class="mt-3 space-y-2">
								<li>• Miễn phí vận chuyển cho đơn hàng từ 500.000₫</li>
								<li>• Bảo hành chính hãng 12 tháng</li>
								<li>• Hỗ trợ đổi trả trong 7 ngày nếu có lỗi</li>
							</ul>
						</div>
					</aside>
				</div>
			@endif
		</div>
	</main>

	@if(($forceLoginPopup ?? false) === true)
		<script>
			window.addEventListener('load', function () {
				if (typeof window.showRequiredLoginPopup === 'function') {
					window.showRequiredLoginPopup();
				}
			});
		</script>
	@endif
</body>

</html>
