<x-guest-layout>
    <!-- Success Message -->
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-green-800">
                    🎉 Đăng ký thành công!
                </h3>
                <div class="mt-2 text-sm text-green-700">
                    <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>TechShop</strong>!</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Instructions -->
    <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-medium text-blue-800">
                    📧 Vui lòng kiểm tra email để kích hoạt tài khoản
                </h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p class="mb-2">Chúng tôi đã gửi một email xác thực đến địa chỉ email của bạn. Vui lòng:</p>
                    <ol class="list-decimal list-inside space-y-1 ml-2">
                        <li>Mở hộp thư email của bạn</li>
                        <li>Tìm email từ <strong>TechShop</strong></li>
                        <li>Nhấn vào nút <strong>"Xác thực Email"</strong> trong email</li>
                        <li>Tài khoản của bạn sẽ được kích hoạt ngay lập tức</li>
                    </ol>
                    <p class="mt-3 text-xs text-blue-600">
                        ⏱️ <strong>Lưu ý:</strong> Link xác thực có hiệu lực trong 15 phút.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Resend Link Notice -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        ✅ Email xác thực mới đã được gửi!
                    </p>
                    <p class="mt-1 text-sm text-green-700">
                        Vui lòng kiểm tra hộp thư của bạn. Nếu không thấy email, hãy kiểm tra trong thư mục <strong>Spam</strong> hoặc <strong>Junk</strong>.
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Didn't Receive Email? -->
    <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
        <p class="text-sm text-gray-700 mb-2">
            <strong>❓ Không nhận được email?</strong>
        </p>
        <ul class="text-sm text-gray-600 space-y-1 list-disc list-inside ml-2">
            <li>Kiểm tra thư mục <strong>Spam</strong> hoặc <strong>Junk Mail</strong></li>
            <li>Đảm bảo bạn nhập đúng địa chỉ email khi đăng ký</li>
            <li>Đợi vài phút để email được gửi đến</li>
            <li>Nhấn nút bên dưới để gửi lại email xác thực</li>
        </ul>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf
            <x-primary-button class="w-full sm:w-auto justify-center">
                📨 Gửi lại email xác thực
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
            @csrf
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                🚪 Đăng xuất
            </button>
        </form>
    </div>

    <!-- Help Text -->
    <div class="mt-6 pt-6 border-t border-gray-200">
        <p class="text-center text-xs text-gray-500">
            Cần hỗ trợ? Liên hệ: <a href="mailto:support@techshop.vn" class="text-blue-600 hover:text-blue-800 underline">support@techshop.vn</a>
        </p>
    </div>
</x-guest-layout>
