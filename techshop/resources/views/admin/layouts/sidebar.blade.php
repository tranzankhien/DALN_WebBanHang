<aside class="w-64 bg-white border-r border-slate-200 text-slate-600 fixed inset-y-0 left-0 h-screen flex flex-col shadow-xl transition-all duration-300 z-20">
    <!-- Logo / Brand -->
    <div class="h-16 flex items-center justify-center border-b border-slate-200 bg-white">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-500/30">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span class="text-xl font-bold text-slate-800 tracking-tight">
                TechShop
            </span>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto custom-scrollbar">
        <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Tổng quan</p>
        
        <a href="{{ route('admin.dashboard') }}" 
           class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                  {{ request()->routeIs('admin.dashboard') 
                     ? 'bg-blue-50 text-blue-700' 
                     : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Dashboard
        </a>

        <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider mt-6 mb-2">Quản lý sản phẩm</p>

        <a href="{{ route('admin.inventory.index') }}" 
           class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                  {{ request()->routeIs('admin.inventory.*') 
                     ? 'bg-blue-50 text-blue-700' 
                     : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.inventory.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Kho hàng
        </a>

        <a href="{{ route('admin.categories.index') }}" 
           class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                  {{ request()->routeIs('admin.categories.*') 
                     ? 'bg-blue-50 text-blue-700' 
                     : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.categories.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            Danh mục
        </a>

        <a href="{{ route('admin.products.index') }}" 
           class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                  {{ request()->routeIs('admin.products.*') 
                     ? 'bg-blue-50 text-blue-700' 
                     : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.products.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            Sản phẩm bán
        </a>

        <p class="px-3 text-xs font-bold text-slate-400 uppercase tracking-wider mt-6 mb-2">Kinh doanh</p>

        <a href="{{ route('admin.orders.index') }}" 
           class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                  {{ request()->routeIs('admin.orders.*') 
                     ? 'bg-blue-50 text-blue-700' 
                     : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.orders.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            Đơn hàng
        </a>

        <a href="{{ route('admin.advertisments.index') }}" 
           class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                  {{ request()->routeIs('admin.advertisments.*') 
                     ? 'bg-blue-50 text-blue-700' 
                     : 'text-slate-600 hover:bg-slate-50 hover:text-blue-600' }}">
            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.advertisments.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            Quảng cáo
        </a>


    </nav>

    <!-- User Profile / Logout (Optional Footer) -->
    <div class="border-t border-slate-200 p-4 bg-slate-50">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                    {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-slate-700">{{ Auth::user()->name ?? 'Admin' }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-slate-500 hover:text-red-600 transition-colors" style="background-color: red; color: white; padding: 2px 6px; border-radius: 4px; ">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
