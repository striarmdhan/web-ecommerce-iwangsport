@extends('layouts.app')

@section('title', 'Favourite')

@section('content')
<div class="max-w-[1400px] mx-auto px-6 lg:px-10 py-8">
    
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Favourite</h1>
        <p class="text-sm text-gray-500 mt-1">Produk yang kamu sukai</p>
    </div>

    @if($favourites->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($favourites as $fav)
                @php $product = $fav->product; @endphp
                @if($product)
                <div class="group bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    
                    <div class="w-full aspect-square bg-[#F5F6F6] relative flex items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out">
                        @else
                            <div class="text-gray-300">No Image</div>
                        @endif

                        {{-- Favourite Button (sudah difavourite = merah) --}}
                        <form method="POST" action="{{ route('favourites.toggle') }}" class="absolute top-4 right-4">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit"
                                    class="w-9 h-9 bg-white/80 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm hover:scale-110 transition-all text-red-500"
                                    title="Hapus dari Favourite">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </button>
                        </form>
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
                @endif
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <svg class="w-20 h-20 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <p class="text-gray-400 text-lg font-medium">Belum ada produk favourite</p>
            <p class="text-gray-300 text-sm mt-1">Klik icon love pada produk untuk menambahkannya</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 text-sm font-semibold text-[#013D29] bg-[#013D29]/5 hover:bg-[#013D29]/10 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Jelajahi Produk
            </a>
        </div>
    @endif
</div>
@endsection
