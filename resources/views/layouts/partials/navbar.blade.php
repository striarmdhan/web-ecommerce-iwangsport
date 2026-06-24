<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-10">
        <div class="flex justify-between items-center h-[76px] gap-4">
            
            <!-- 1. Brand Name (Kiri) -->
            <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight flex items-center gap-2 shrink-0" style="color: #013D29;">
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 3H5L6.6 12.4C6.7 13 7.2 13.5 7.8 13.5H17.2C17.8 13.5 18.3 13 18.4 12.4L19.8 5H6.5" stroke="#013D29" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="9" cy="19" r="2" fill="#013D29"/>
                    <circle cx="17" cy="19" r="2" fill="#013D29"/>
                </svg>
                Iwangsport
            </a>

            <!-- 2. Navigation Menu -->
            <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <a href="{{ route('home') }}" 
                   class="relative text-[15px] py-1 transition-colors {{ request()->routeIs('home') ? 'font-semibold text-gray-900' : 'font-medium text-gray-500 hover:text-gray-900' }}"
                   style="{{ request()->routeIs('home') ? 'border-bottom: 2px solid #013D29;' : '' }}">
                    Home
                </a>

                <a href="{{ route('products.index') }}" 
                   class="relative text-[15px] py-1 transition-colors {{ request()->routeIs('products.*') ? 'font-semibold text-gray-900' : 'font-medium text-gray-500 hover:text-gray-900' }}"
                   style="{{ request()->routeIs('products.*') ? 'border-bottom: 2px solid #013D29;' : '' }}">
                    Product
                </a>

                @auth
                <a href="{{ route('favourites.index') }}" 
                   class="relative text-[15px] py-1 transition-colors flex items-center gap-2 {{ request()->routeIs('favourites.*') ? 'font-semibold text-gray-900' : 'font-medium text-gray-500 hover:text-gray-900' }}"
                   style="{{ request()->routeIs('favourites.*') ? 'border-bottom: 2px solid #013D29;' : '' }}">
                    Favourite
                    @php $favCount = auth()->user()->favourites()->count(); @endphp
                    @if($favCount > 0)
                        <span class="bg-red-500 text-white text-[9px] font-bold rounded-full h-4 min-w-[16px] px-1 flex items-center justify-center leading-none">{{ $favCount }}</span>
                    @endif
                </a>
                @else
                <a href="{{ route('login') }}" 
                   class="relative text-[15px] font-medium text-gray-500 hover:text-gray-900 py-1 transition-colors">
                    Favourite
                </a>
                @endauth
            </div>

            <!-- 3. Search Bar & Icons Action (Kanan) -->
            <div class="flex items-center gap-4 lg:gap-6 flex-1 justify-end max-w-xl md:max-w-2xl">
                <!-- Search Input Box -->
                <form action="{{ route('products.index') }}" method="GET" class="relative w-full hidden sm:block max-w-xs md:max-w-sm lg:max-w-md">
                    <input type="text" name="search" placeholder="Search Product" class="w-full pl-4 pr-10 py-2 bg-gray-100 text-sm rounded-full border-none focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all text-gray-700">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>

                <!-- Icons Group (Account & Cart) -->
                <div class="flex items-center gap-3 shrink-0">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-1.5 px-2 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-full transition-colors">
                                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span class="hidden lg:inline text-xs font-semibold">{{ auth()->user()->name }}</span>
                            </button>
                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                                <div class="px-4 py-2 border-b border-gray-100 mb-1">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                </div>
                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">My Orders</a>
                                <a href="{{ route('favourites.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">My Favourites</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center gap-1.5 px-2 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-full transition-colors">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="text-xs">Account</span>
                        </a>
                    @endauth

                    <!-- Cart Link Button -->
                    <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1.5 px-2 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-full transition-colors">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="text-xs">Cart</span>
                        @auth
                            @php $cartCount = auth()->user()->cart ? auth()->user()->cart->items->count() : 0; @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold rounded-full h-4 w-4 flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        @endauth
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-data="{ mobileOpen: false }" class="md:hidden border-t border-gray-100">
        <button @click="mobileOpen = !mobileOpen" class="w-full flex items-center justify-center py-3 text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <div x-show="mobileOpen" class="px-6 pb-4 space-y-1">
            <a href="{{ route('home') }}" class="block py-2.5 text-sm {{ request()->routeIs('home') ? 'font-semibold text-[#013D29]' : 'font-medium text-gray-600' }}">Home</a>
            <a href="{{ route('products.index') }}" class="block py-2.5 text-sm {{ request()->routeIs('products.*') ? 'font-semibold text-[#013D29]' : 'font-medium text-gray-600' }}">Product</a>
            @auth
            <a href="{{ route('favourites.index') }}" class="block py-2.5 text-sm {{ request()->routeIs('favourites.*') ? 'font-semibold text-[#013D29]' : 'font-medium text-gray-600' }}">
                Favourite
                @if($favCount > 0)
                    <span class="ml-1 bg-red-500 text-white text-[9px] font-bold rounded-full h-4 min-w-[16px] px-1 inline-flex items-center justify-center">{{ $favCount }}</span>
                @endif
            </a>
            @else
            <a href="{{ route('login') }}" class="block py-2.5 text-sm font-medium text-gray-600">Favourite</a>
            @endauth
        </div>
    </div>
</nav>