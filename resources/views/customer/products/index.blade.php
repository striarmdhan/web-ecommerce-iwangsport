@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="max-w-[1400px] mx-auto px-6 lg:px-10 py-8">
    
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Semua Produk</h1>
        <p class="text-sm text-gray-500 mt-1">Temukan koleksi celana sport terbaik kami</p>
    </div>

    {{-- Filter & Sort Bar --}}
    <form method="GET" action="{{ route('products.index') }}" id="filterForm" class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-6 mb-8">
        
        <div class="flex flex-wrap items-center gap-3">
            {{-- Search --}}
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full sm:w-56 px-4 py-2 pl-10 bg-gray-100 border-none rounded-full text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                       placeholder="Cari produk...">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            {{-- Filter Kategori --}}
            <x-dropdown 
                name="category"
                placeholder="Kategori"
                :options="array_merge(
                    [['value' => '', 'label' => 'Semua Kategori']],
                    $categories->map(fn($cat) => ['value' => $cat->id, 'label' => $cat->name])->toArray()
                )"
                :selected="request('category')"
                variant="pill"
                formId="filterForm"
            />

            {{-- Filter Harga --}}
            <x-dropdown 
                name="price_range"
                placeholder="Harga"
                :options="[
                    ['value' => '', 'label' => 'Semua Harga'],
                    ['value' => '0-100000', 'label' => 'Dibawah Rp 100K'],
                    ['value' => '100000-200000', 'label' => 'Rp 100K - 200K'],
                    ['value' => '200000-500000', 'label' => 'Rp 200K - 500K'],
                    ['value' => '500000-99999999', 'label' => 'Diatas Rp 500K'],
                ]"
                :selected="request('price_range')"
                variant="pill"
                formId="filterForm"
            />

            {{-- Hapus Filter --}}
            @if(request('search') || request('category') || request('price_range') || request('min_price') || request('max_price'))
                <a href="{{ route('products.index') }}" class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-full bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            @endif
        </div>

        <div class="flex items-center gap-3">
            <p class="text-sm text-gray-400">{{ $products->total() }} produk</p>
            <x-dropdown 
                name="sort"
                placeholder="Urutkan"
                :options="[
                    ['value' => 'latest', 'label' => 'Terbaru'],
                    ['value' => 'cheapest', 'label' => 'Harga: Rendah ke Tinggi'],
                    ['value' => 'expensive', 'label' => 'Harga: Tinggi ke Rendah'],
                ]"
                :selected="request('sort', 'latest')"
                variant="pill"
                formId="filterForm"
            />
        </div>
    </form>

    {{-- Products Grid --}}
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    
                    <div class="w-full aspect-square bg-[#F5F6F6] relative flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out">
                        @else
                            <div class="text-gray-300">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif

                        {{-- Wishlist Button --}}
                        @php
                            $isFavourited = auth()->check() ? auth()->user()->favourites()->where('product_id', $product->id)->exists() : false;
                        @endphp
                        @auth
                            <form method="POST" action="{{ route('favourites.toggle') }}" class="absolute top-4 right-4 z-10">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit"
                                        class="w-9 h-9 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm hover:scale-110 transition-all {{ $isFavourited ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}"
                                        title="{{ $isFavourited ? 'Hapus dari Favourite' : 'Tambah ke Favourite' }}">
                                    <svg class="w-5 h-5 {{ $isFavourited ? 'fill-current' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="absolute top-4 right-4 z-10 w-9 h-9 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm hover:scale-110 transition-all text-gray-400 hover:text-red-500"
                               title="Login untuk favourite">
                                <svg class="w-5 h-5 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </a>
                        @endauth
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-bold text-gray-900 text-[15px] line-clamp-1 mb-1">
                            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-[#013D29] transition-colors">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <p class="text-xs text-gray-400 line-clamp-1 mb-3">
                            {{ $product->category->name ?? '' }}
                        </p>

                        <div class="mt-auto flex items-center justify-between">
                            <span class="font-bold text-gray-900 text-base">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('products.show', $product->slug) }}" 
                               class="flex items-center gap-2 px-4 py-2 rounded-full border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-[#013D29] hover:text-white hover:border-[#013D29] transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Add to Cart
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <svg class="w-20 h-20 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <p class="text-gray-400 text-lg font-medium">Produk tidak ditemukan</p>
            <p class="text-gray-300 text-sm mt-1">Coba ubah filter atau kata kunci pencarian</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 text-sm font-semibold text-[#013D29] bg-[#013D29]/5 hover:bg-[#013D29]/10 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Reset Filter
            </a>
        </div>
    @endif
</div>
@endsection
