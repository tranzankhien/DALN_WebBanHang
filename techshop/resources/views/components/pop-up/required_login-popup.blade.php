<div id="required-login-popup" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 px-4" aria-hidden="true" role="dialog" aria-modal="true">
    <div class="relative w-full max-w-md rounded-2xl bg-white p-6 shadow-xl" role="document">
        <button type="button" class="absolute right-3 top-3 rounded-full bg-gray-100 p-2 text-gray-500 hover:text-gray-700" data-close-login-popup aria-label="Đóng">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="flex flex-col items-center text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h2 class="mt-4 text-xl font-semibold text-gray-900">Vui lòng đăng nhập</h2>
            <p id="required-login-popup-message" class="mt-2 text-sm text-gray-600">Bạn cần đăng nhập để sử dụng tính năng giỏ hàng và theo dõi đơn hàng.</p>
            <div class="mt-6 flex w-full flex-col gap-3">
                <a href="{{ route('login') }}" class="w-full rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 px-5 py-3 text-sm font-semibold text-white hover:from-blue-600 hover:to-blue-700" data-close-login-popup>
                    Đăng nhập
                </a>
                <a href="{{ route('register') }}" class="w-full rounded-lg border border-blue-500 px-5 py-3 text-sm font-semibold text-blue-600 hover:bg-blue-50" data-close-login-popup>
                    Tạo tài khoản
                </a>
            </div>
        </div>
    </div>
</div>
