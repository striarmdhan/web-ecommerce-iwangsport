<aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-100 transform transition-transform lg:translate-x-0 z-40">
    {{-- Brand --}}
    <div class="h-16 flex items-center gap-2.5 px-6 border-b border-gray-100">
        <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 3H5L6.6 12.4C6.7 13 7.2 13.5 7.8 13.5H17.2C17.8 13.5 18.3 13 18.4 12.4L19.8 5H6.5" stroke="#013D29" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="9" cy="19" r="2" fill="#013D29"/>
            <circle cx="17" cy="19" r="2" fill="#013D29"/>
        </svg>
        <h1 class="text-lg font-bold" style="color: #013D29;">Iwangsport</h1>
    </div>

    {{-- Navigation --}}
    <nav class="p-4 space-y-1">
        <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-300 px-4 mb-3">Menu</p>

        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-[#013D29] text-white shadow-md shadow-[#013D29]/20' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('admin.orders.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-[#013D29] text-white shadow-md shadow-[#013D29]/20' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <span>Pesanan</span>
        </a>
        
        <a href="{{ route('admin.products.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-[#013D29] text-white shadow-md shadow-[#013D29]/20' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <span>Produk</span>
        </a>
        
        <a href="{{ route('admin.categories.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-[#013D29] text-white shadow-md shadow-[#013D29]/20' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <span>Kategori</span>
        </a>
        
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-[#013D29] text-white shadow-md shadow-[#013D29]/20' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span>Pelanggan</span>
        </a>
    </nav>
</aside>
