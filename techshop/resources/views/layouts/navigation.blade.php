<!-- Unified header/navigation to match home.blade.php -->
<header class="bg-white shadow-md sticky top-0 z-50" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}"
                    class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                    TechShop
                </a>
            </div>

            <!-- Search Bar (Desktop) -->
            @livewire('product-search')

            <!-- Navigation Links / Auth -->
            <nav class="flex items-center space-x-4">
                <!-- Order history -->
                @auth
                <a href="{{ route('orders.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600"
                    aria-label="Đơn hàng">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </a>
                @else
                <button type="button" class="relative p-2 text-gray-600 hover:text-blue-600" data-trigger-login-popup
                    aria-label="Đơn hàng">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </button>
                @endauth

                @auth
                <!-- cart count logic -->
                @php
                $cartRelation = auth()->user()->cart;
                $cartItemCount = $cartRelation ? $cartRelation->items()->sum('quantity') : 0;
                @endphp
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 hover:text-blue-600"
                    aria-label="Giỏ hàng">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span
                        class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-semibold text-white">
                        {{ $cartItemCount }}
                    </span>
                </a>

                <!-- User Dropdown -->
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
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50"
                        style="display: none;">
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Quản trị
                        </a>
                        @endif
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            Tài khoản
                        </a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                            Cài đặt
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
                <button type="button" class="relative p-2 text-gray-600 hover:text-blue-600" data-trigger-login-popup
                    aria-label="Giỏ hàng">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </button>
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                    Đăng nhập
                </a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg hover:shadow-lg transition">
                    Đăng ký
                </a>
                @endauth
            </nav>

            <!-- Mobile hamburger (optional if you add mobile menu later) -->
            <div class="md:hidden">
                <button @click="mobileOpen = !mobileOpen" class="p-2 rounded-md text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': mobileOpen, 'inline-flex': ! mobileOpen }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! mobileOpen, 'inline-flex': mobileOpen }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile collapsed content placeholder (not implemented) -->
    <div class="md:hidden" x-show="mobileOpen" style="display:none;">
        <div class="px-4 pb-3 space-y-2">
            <a href="{{ route('home') }}" class="block py-2 text-gray-700">Trang chủ</a>
            @auth
            <a href="{{ route('profile.edit') }}" class="block py-2 text-gray-700">Tài khoản</a>
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-700">Quản trị</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block py-2 text-red-600">Đăng xuất</button>
            </form>
            @else
            <a href="{{ route('login') }}" class="block py-2 text-gray-700">Đăng nhập</a>
            <a href="{{ route('register') }}" class="block py-2 text-gray-700">Đăng ký</a>
            @endauth
        </div>
    </div>
</header>

@include('components.pop-up.required_login-popup')