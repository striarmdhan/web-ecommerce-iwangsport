@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-[1400px] mx-auto px-6 lg:px-10 py-8">
    {{-- Back Button --}}
    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-[#013D29] transition-colors mb-8">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16">
        {{-- Left: Product Image --}}
        <div>
            <div class="aspect-square bg-[#F5F6F6] rounded-3xl overflow-hidden flex items-center justify-center p-8 relative group">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                @else
                    <svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                @endif

                @php
                    $isFavourited = auth()->check() ? auth()->user()->favourites()->where('product_id', $product->id)->exists() : false;
                @endphp
                @auth
                    <form method="POST" action="{{ route('favourites.toggle') }}" class="absolute top-5 right-5">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit"
                                class="w-11 h-11 bg-white rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-all {{ $isFavourited ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }}"
                                title="{{ $isFavourited ? 'Hapus dari Favourite' : 'Tambah ke Favourite' }}">
                            <svg class="w-5 h-5 {{ $isFavourited ? 'fill-current' : 'fill-none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="absolute top-5 right-5 w-11 h-11 bg-white rounded-full flex items-center justify-center shadow-md hover:scale-110 transition-all text-gray-400 hover:text-red-500"
                       title="Login untuk favourite">
                        <svg class="w-5 h-5 fill-none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </a>
                @endauth
            </div>

            {{-- Product Images Thumbnails (jika ada) --}}
            @if($product->images->count() > 0)
                <div class="flex gap-3 mt-4">
                    <div class="w-20 h-20 bg-[#F5F6F6] rounded-xl overflow-hidden border-2 border-[#013D29] p-2 flex items-center justify-center cursor-pointer">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain">
                    </div>
                    @foreach($product->images as $img)
                        <div class="w-20 h-20 bg-[#F5F6F6] rounded-xl overflow-hidden border border-gray-200 p-2 flex items-center justify-center cursor-pointer hover:border-gray-400 transition-colors">
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $product->name }}" class="max-w-full max-h-full object-contain">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Right: Product Info --}}
        <div class="flex flex-col py-2">
            {{-- Category --}}
            <p class="text-sm font-medium text-gray-400 mb-2">{{ $product->category->name ?? '-' }}</p>

            {{-- Product Name --}}
            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-3 leading-tight">{{ $product->name }}</h1>

            {{-- Price --}}
            <p class="text-2xl lg:text-3xl font-bold text-gray-900 mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

            {{-- Description --}}
            @if($product->description)
                <p class="text-sm text-gray-500 leading-relaxed mb-8">{{ $product->description }}</p>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('cart.add') }}" class="space-y-6" x-data="{
                selectedColor: '',
                selectedSize: '',
                variants: {{ $product->variants->toJson() }},
                get availableSizes() {
                    if (!this.selectedColor) {
                        return [...new Set(this.variants.filter(v => v.stock > 0).map(v => v.size).filter(Boolean))];
                    }
                    return [...new Set(this.variants.filter(v => v.color === this.selectedColor && v.stock > 0).map(v => v.size).filter(Boolean))];
                },
                get availableColors() {
                    if (!this.selectedSize) {
                        return [...new Set(this.variants.filter(v => v.stock > 0).map(v => v.color).filter(Boolean))];
                    }
                    return [...new Set(this.variants.filter(v => v.size === this.selectedSize && v.stock > 0).map(v => v.color).filter(Boolean))];
                },
                get allColors() {
                    return [...new Set(this.variants.map(v => v.color).filter(Boolean))];
                },
                get allSizes() {
                    return [...new Set(this.variants.map(v => v.size).filter(Boolean))];
                },
                get selectedVariant() {
                    return this.variants.find(v => v.color === this.selectedColor && v.size === this.selectedSize);
                },
                get selectedVariantId() {
                    return this.selectedVariant ? this.selectedVariant.id : null;
                },
                get inStock() {
                    return this.selectedVariant ? this.selectedVariant.stock > 0 : false;
                },
                get stockCount() {
                    return this.selectedVariant ? this.selectedVariant.stock : 0;
                },
                isColorAvailable(color) {
                    return this.availableColors.includes(color);
                },
                isSizeAvailable(size) {
                    return this.availableSizes.includes(size);
                }
            }">
                @csrf

                {{-- Color Selection --}}
                @if($product->variants->whereNotNull('color')->count() > 0)
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <h3 class="text-sm font-semibold text-gray-900">Color</h3>
                            <span x-show="selectedColor" class="text-sm text-gray-400" x-text="selectedColor"></span>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <template x-for="color in allColors" :key="color">
                                <button type="button"
                                    @click="selectedColor = (selectedColor === color ? '' : color)"
                                    class="w-10 h-10 rounded-full border-2 transition-all duration-200 cursor-pointer relative"
                                    :class="{
                                        'border-[#013D29] scale-110 shadow-md': selectedColor === color,
                                        'border-gray-200 hover:border-gray-400': selectedColor !== color && isColorAvailable(color),
                                        'border-gray-100 opacity-30 cursor-not-allowed': !isColorAvailable(color)
                                    }"
                                    :style="'background-color: ' + color.toLowerCase()"
                                    :title="color"
                                    :disabled="!isColorAvailable(color)">
                                    <span x-show="selectedColor === color" class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-4 h-4" :class="{'text-white': ['black','navy','darkblue','darkgreen','maroon','brown'].includes(color.toLowerCase()), 'text-gray-800': !['black','navy','darkblue','darkgreen','maroon','brown'].includes(color.toLowerCase())}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </span>
                                </button>
                            </template>
                        </div>
                    </div>
                @endif

                {{-- Size Selection --}}
                @if($product->variants->whereNotNull('size')->count() > 0)
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-semibold text-gray-900">Size</h3>
                            <a href="#" class="text-xs font-medium text-[#013D29] underline underline-offset-2">Size Guide</a>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="size in allSizes" :key="size">
                                <button type="button"
                                    @click="selectedSize = (selectedSize === size ? '' : size)"
                                    class="min-w-[48px] h-11 px-4 rounded-full text-sm font-semibold transition-all duration-200 cursor-pointer"
                                    :class="{
                                        'bg-[#013D29] text-white shadow-md': selectedSize === size,
                                        'bg-gray-100 text-gray-700 hover:bg-gray-200': selectedSize !== size && isSizeAvailable(size),
                                        'bg-gray-50 text-gray-300 cursor-not-allowed line-through': !isSizeAvailable(size)
                                    }"
                                    :disabled="!isSizeAvailable(size)"
                                    x-text="size">
                                </button>
                            </template>
                        </div>
                    </div>
                @endif

                {{-- Stock Info --}}
                <div x-show="selectedColor && selectedSize" x-transition>
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full" :class="inStock ? 'bg-emerald-500' : 'bg-red-500'"></span>
                        <span class="text-sm" :class="inStock ? 'text-emerald-600' : 'text-red-500'" x-text="inStock ? 'Stok tersedia: ' + stockCount : 'Stok habis'"></span>
                    </div>
                </div>

                {{-- Quantity --}}
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Jumlah</h3>
                    <div class="inline-flex items-center bg-gray-100 rounded-full overflow-hidden">
                        <button type="button" onclick="let input = this.parentElement.querySelector('input'); if(input.value > 1) input.value--"
                                class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-gray-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                        </button>
                        <input type="number" name="quantity" value="1" min="1"
                               class="w-12 h-10 text-center bg-transparent text-sm font-semibold text-gray-900 border-none focus:ring-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        <button type="button" onclick="let input = this.parentElement.querySelector('input'); input.value++"
                                class="w-10 h-10 flex items-center justify-center text-gray-600 hover:text-gray-900 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>

                {{-- Hidden Variant ID --}}
                <input type="hidden" name="product_variant_id" :value="selectedVariantId || '0'">

                {{-- Add to Cart Button --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 flex items-center justify-center gap-3 bg-[#013D29] text-white py-4 rounded-full font-semibold text-base hover:bg-[#025c3e] transition-all duration-300 shadow-lg hover:shadow-xl active:scale-[0.98]"
                        @if($product->total_stock == 0) disabled @endif>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        @if($product->total_stock == 0)
                            Stok Habis
                        @else
                            Tambah ke Keranjang
                        @endif
                    </button>
                </div>
            </form>

            {{-- Extra Info --}}
            <div class="grid grid-cols-2 gap-4 mt-8 pt-8 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-900">Pengiriman Gratis</p>
                        <p class="text-xs text-gray-400">Untuk pembelian di atas Rp 200K</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-900">Pengembalian Mudah</p>
                        <p class="text-xs text-gray-400">Garansi 7 hari pengembalian</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
