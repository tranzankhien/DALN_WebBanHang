<aside class="w-64 bg-gradient-to-b from-gray-800 to-gray-900 text-white min-h-screen flex flex-col shadow-xl" style="background-color: #1e293b;">
    <!-- Logo / Brand -->
    <div class="px-6 py-6 bg-gray-900" style="background-color: #2a4100ff;">
        <h1 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">
            TechShop Admin
        </h1>
        <p class="text-xs text-gray-400 mt-1">Quản trị hệ thống</p>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" 
           class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
                  {{ request()->routeIs('admin.dashboard') 
                     ? 'bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg shadow-blue-500/50' 
                     : 'hover:bg-gray-700 hover:shadow-md' }}">
            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>

        <a href="{{ route('admin.inventory.index') }}" 
           class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
                  {{ request()->routeIs('admin.inventory.*') 
                     ? 'bg-gradient-to-r from-green-600 to-green-700 shadow-lg shadow-green-500/50' 
                     : 'hover:bg-gray-700 hover:shadow-md' }}">
            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Quản lý Kho
        </a>

        <a href="{{ route('admin.categories.index') }}" 
           class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
                  {{ request()->routeIs('admin.categories.*') 
                     ? 'bg-gradient-to-r from-purple-600 to-purple-700 shadow-lg shadow-purple-500/50' 
                     : 'hover:bg-gray-700 hover:shadow-md' }}">
            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            Quản lý Danh mục
        </a>

        <a href="{{ route('admin.products.index') }}" 
           class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200
                  {{ request()->routeIs('admin.products.*') 
                     ? 'bg-gradient-to-r from-orange-600 to-orange-700 shadow-lg shadow-orange-500/50' 
                     : 'hover:bg-gray-700 hover:shadow-md' }}">
            <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            Quản lý Sản phẩm
        </a>

        <div class="pt-4 mt-4 border-t border-gray-700">
            <a href="{{ url('/') }}" 
               class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-gray-700 transition-all duration-200 hover:shadow-md">
                <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Về Trang chủ
            </a>
        </div>
    </nav>

    <!-- User Profile Section (Bottom) -->
    <div class="px-4 py-4 bg-gray-900 border-t border-gray-700">
        <div class="flex items-center space-x-3 mb-3">
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-10 h-10 rounded-full ring-2 ring-blue-500" style="object-fit: cover; margin-right: 0.5rem;">
            @else
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm ring-2 ring-blue-500">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            <div class="flex-1 min-w-0" style="margin-left: 0.5rem;">
                <p class="text-sm font-medium text-white truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-gray-400 truncate">
                    {{ auth()->user()->email }}
                </p>
            </div>
        </div>
        
        <!-- Logout Button -->
        <div style="margin-top: 0.5rem;"> </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-red-600 to-red-700 rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Đăng xuất
            </button>
        </form>
    </div>
</aside>
