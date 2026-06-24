@extends('layouts.app')

@section('title', 'Home')

@section('content')

<section class="max-w-[1400px] mx-auto px-6 lg:px-10 mt-6">
    <div class="w-full rounded-2xl flex flex-col md:flex-row items-center relative overflow-hidden px-8 py-10 md:py-0 md:px-16 h-auto md:h-[340px]" style="background-color: #FBF0E4;">
        <div class="flex-1 text-center md:text-left z-10 max-w-lg">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold tracking-tight mb-4 leading-tight" style="color: #013D29;">
                Sport Collection
            </h1>
            <p class="text-base lg:text-md mb-6 max-w-md leading-relaxed" style="color: #013D29; opacity: 0.7;">
                Koleksi celana sport premium dengan bahan berkualitas tinggi dan desain modern untuk gaya hidup aktif Anda.
            </p>
            <a href="{{ route('products.index') }}" 
               class="inline-block px-8 py-3.5 text-white font-semibold rounded-full text-sm transition-all duration-300 bg-[#013D29] hover:bg-[#025c3e] shadow-sm">
                Buy Now
            </a>
        </div>

        <div class="flex-1 w-full h-full flex justify-center md:justify-end items-end relative mt-6 md:mt-0">
            <img src="{{ asset('images/dashboard/home.png') }}" alt="Model Banner" 
                 class="w-[260px] md:w-[320px] lg:w-[360px] h-full object-contain object-bottom md:absolute md:bottom-0 md:right-10">
        </div>
    </div>
</section>

<section class="max-w-[1400px] mx-auto px-6 lg:px-10 mt-10">
    <form method="GET" action="{{ route('home') }}" id="filterForm" class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 pb-6">
        
        <div class="flex flex-wrap items-center gap-3">
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

            {{-- Filter Ukuran --}}
            <x-dropdown 
                name="size"
                placeholder="Ukuran"
                :options="[
                    ['value' => '', 'label' => 'Semua Ukuran'],
                    ['value' => 'S', 'label' => 'S'],
                    ['value' => 'M', 'label' => 'M'],
                    ['value' => 'L', 'label' => 'L'],
                    ['value' => 'XL', 'label' => 'XL'],
                ]"
                :selected="request('size')"
                variant="pill"
                formId="filterForm"
            />

            {{-- Tombol Hapus Filter --}}
            @if(request('category') || request('price_range') || request('size') || request('sort') !== 'latest')
                <a href="{{ route('home') }}" class="flex items-center gap-1.5 px-4 py-2 text-sm font-medium rounded-full bg-red-50 text-red-600 hover:bg-red-100 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            @endif
        </div>

        <div class="flex items-center gap-2">
            {{-- Sort Dropdown --}}
            <x-dropdown 
                name="sort"
                placeholder="Urutkan"
                :options="[
                    ['value' => 'latest', 'label' => 'Terbaru'],
                    ['value' => 'cheapest', 'label' => 'Harga: Rendah ke Tinggi'],
                    ['value' => 'expensive', 'label' => 'Harga: Tinggi ke Rendah'],
                    ['value' => 'popular', 'label' => 'Paling Populer'],
                ]"
                :selected="request('sort', 'latest')"
                variant="pill"
                formId="filterForm"
            />
        </div>

    </form>
</section>

<section class="max-w-[1400px] mx-auto px-6 lg:px-10 py-10">
    <h2 class="text-2xl font-bold text-gray-900 mb-8">Celana sports untukmu!</h2>

    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    
                    <div class="w-full aspect-square bg-[#F5F6F6] p-6 relative flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out">
                        @else
                            <div class="text-gray-300">No Image</div>
                        @endif

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
    @else
        <div class="text-center py-20">
            <p class="text-gray-400 text-lg">Belum ada produk tersedia.</p>
        </div>
    @endif
</section>

@endsection