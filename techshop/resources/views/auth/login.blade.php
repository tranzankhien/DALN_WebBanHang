<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Quên mật khẩu?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Đăng nhập') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Social Login Divider -->
    <div
        class="my-4 mb-3 flex items-center text-xs uppercase text-gray-400 before:me-6 before:flex-1 before:border-t before:border-gray-200 after:ms-6 after:flex-1 after:border-t after:border-gray-200">
        Hoặc đăng nhập bằng
    </div>

    <!-- Social Login Buttons -->
    @if ((env('GOOGLE_CLIENT_ID') && env('GOOGLE_CLIENT_SECRET')) || (env('FACEBOOK_CLIENT_ID') && env('FACEBOOK_CLIENT_SECRET')))
        <div class="space-y-3">
            @if (env('GOOGLE_CLIENT_ID') && env('GOOGLE_CLIENT_SECRET'))
                <a class="bg-white text-gray-700 flex w-full items-center justify-center space-x-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-50"
                    href="{{ route('social.redirect', 'google') }}">
                    <svg class="h-auto w-5" viewBox="0 0 46 47" fill="none">
                        <path
                            d="M46 24.0287C46 22.09 45.8533 20.68 45.5013 19.2112H23.4694V27.9356H36.4069C36.1429 30.1094 34.7347 33.37 31.5957 35.5731L31.5663 35.8669L38.5191 41.2719L38.9885 41.3306C43.4477 37.2181 46 31.1669 46 24.0287Z"
                            fill="#4285F4" />
                        <path
                            d="M23.4694 47C29.8061 47 35.1161 44.9144 39.0179 41.3012L31.625 35.5437C29.6301 36.9244 26.9898 37.8937 23.4987 37.8937C17.2793 37.8937 12.0281 33.7812 10.1505 28.1412L9.88649 28.1706L2.61097 33.7812L2.52296 34.0456C6.36608 41.7125 14.287 47 23.4694 47Z"
                            fill="#34A853" />
                        <path
                            d="M10.1212 28.1413C9.62245 26.6725 9.32908 25.1156 9.32908 23.5C9.32908 21.8844 9.62245 20.3275 10.0918 18.8588V18.5356L2.75765 12.8369L2.52296 12.9544C0.909439 16.1269 0 19.7106 0 23.5C0 27.2894 0.909439 30.8731 2.49362 34.0456L10.1212 28.1413Z"
                            fill="#FBBC05" />
                        <path
                            d="M23.4694 9.07688C27.8699 9.07688 30.8622 10.9863 32.5344 12.5725L39.1645 6.11C35.0867 2.32063 29.8061 0 23.4694 0C14.287 0 6.36607 5.2875 2.49362 12.9544L10.0918 18.8588C11.9987 13.1894 17.25 9.07688 23.4694 9.07688Z"
                            fill="#EB4335" />
                    </svg>
                    <span>Continue with Google</span>
                </a>
            @endif

            @if (env('FACEBOOK_CLIENT_ID') && env('FACEBOOK_CLIENT_SECRET'))
                <a class="bg-white text-gray-700 flex w-full items-center justify-center space-x-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium transition-colors duration-200 hover:bg-gray-50"
                    href="{{ route('social.redirect', 'facebook') }}">
                    <svg class="w-5 h-auto" viewBox="-204.79995 -341.33325 1774.9329 2047.9995">
                        <path
                            d="M1365.333 682.667C1365.333 305.64 1059.693 0 682.667 0 305.64 0 0 305.64 0 682.667c0 340.738 249.641 623.16 576 674.373V880H402.667V682.667H576v-150.4c0-171.094 101.917-265.6 257.853-265.6 74.69 0 152.814 13.333 152.814 13.333v168h-86.083c-84.804 0-111.25 52.623-111.25 106.61v128.057h189.333L948.4 880H789.333v477.04c326.359-51.213 576-333.635 576-674.373"
                            fill="#1877f2" />
                        <path
                            d="M948.4 880l30.267-197.333H789.333V554.609C789.333 500.623 815.78 448 900.584 448h86.083V280s-78.124-13.333-152.814-13.333c-155.936 0-257.853 94.506-257.853 265.6v150.4H402.667V880H576v477.04a687.805 687.805 0 00106.667 8.293c36.288 0 71.91-2.84 106.666-8.293V880H948.4"
                            fill="#fff" />
                    </svg>
                    <span>Continue with Facebook</span>
                </a>
            @endif
        </div>
    @else
        <!-- Warning when credentials not configured -->
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-yellow-800">Social Login chưa được cấu hình</h3>
                    <p class="mt-1 text-xs text-yellow-700">
                        Để sử dụng đăng nhập bằng Google/Facebook, vui lòng tạo OAuth credentials mới cho TechShop.
                        <br>
                        <a href="{{ asset('SETUP_GOOGLE_OAUTH.md') }}" class="underline font-medium" target="_blank">
                            📖 Xem hướng dẫn setup
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif
    {{-- chuyển hướng đến trang đăng ký nếu người dùng chưa có tài khoản --}}

    <div class="mt-4 text-center">
        <div class="text-sm">
            Bạn chưa có tài khoản?
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500 underline">Đăng
                ký ngay</a>
        </div>
    </div>

</x-guest-layout>