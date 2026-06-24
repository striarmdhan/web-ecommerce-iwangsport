@extends('layouts.app')

@section('title', 'Keranjang')

@section('content')
<div class="max-w-[1400px] mx-auto px-6 lg:px-10 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Keranjang Belanja</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $cart->items->count() }} produk di keranjang Anda</p>
    </div>

    @if($cart->items->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Cart Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="group bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-md transition-all duration-300">
                        <div class="flex items-start gap-5">

                            {{-- Product Image --}}
                            <a href="{{ route('products.show', $item->productVariant->product->slug) }}" class="w-28 h-28 bg-[#F5F6F6] rounded-2xl overflow-hidden shrink-0 flex items-center justify-center">
                                @if($item->productVariant->product->image)
                                    <img src="{{ asset('storage/' . $item->productVariant->product->image) }}" 
                                         alt="{{ $item->productVariant->product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 ease-out">
                                @else
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </a>

                            {{-- Product Info --}}
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('products.show', $item->productVariant->product->slug) }}" class="font-bold text-gray-900 text-[15px] hover:text-[#013D29] transition-colors line-clamp-1">
                                    {{ $item->productVariant->product->name }}
                                </a>
                                <p class="text-xs text-gray-400 mt-1">{{ $item->productVariant->variant_label }}</p>
                                <p class="text-base font-bold text-gray-900 mt-2">
                                    Rp {{ number_format($item->productVariant->product->price, 0, ',', '.') }}
                                </p>

                                {{-- Actions --}}
                                <div class="flex items-center gap-4 mt-4">
                                    {{-- Quantity Stepper --}}
                                    <form method="POST" action="{{ route('cart.update', $item->id) }}" class="inline-flex items-center bg-gray-100 rounded-full overflow-hidden">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" onclick="let input = this.parentElement.querySelector('input'); if(input.value > 1) { input.value--; this.parentElement.submit(); }"
                                                class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-gray-900 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                        </button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                               class="w-10 h-9 text-center bg-transparent text-sm font-semibold text-gray-900 border-none focus:ring-0 focus:outline-none [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                               onchange="this.form.submit()">
                                        <button type="button" onclick="let input = this.parentElement.querySelector('input'); input.value++; this.parentElement.submit();"
                                                class="w-9 h-9 flex items-center justify-center text-gray-500 hover:text-gray-900 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </form>

                                    {{-- Remove Button --}}
                                    <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center gap-1.5 text-xs font-medium text-gray-400 hover:text-red-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Subtotal --}}
                            <div class="text-right shrink-0">
                                <p class="text-base font-bold text-gray-900">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Continue Shopping --}}
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-[#013D29] transition-colors mt-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Lanjut Belanja
                </a>
            </div>

            {{-- Right: Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-6">Ringkasan Belanja</h2>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Subtotal ({{ $cart->items->count() }} item)</span>
                            <span class="text-sm font-semibold text-gray-900">
                                Rp {{ number_format($cart->total, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Ongkos Kirim</span>
                            <span class="text-xs font-medium text-gray-400 bg-gray-50 px-3 py-1 rounded-full">Ditentukan admin</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-bold text-gray-900">Total</span>
                            <span class="text-xl font-bold text-gray-900">
                                Rp {{ number_format($cart->total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('checkout.index') }}" 
                       class="w-full flex items-center justify-center gap-3 bg-[#013D29] text-white py-4 rounded-full font-semibold text-base hover:bg-[#025c3e] transition-all duration-300 shadow-lg hover:shadow-xl active:scale-[0.98]">
                        Lanjut ke Checkout
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    {{-- Trust Badges --}}
                    <div class="grid grid-cols-2 gap-3 mt-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <p class="text-[11px] text-gray-400 leading-tight">Pembayaran<br>Aman</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <p class="text-[11px] text-gray-400 leading-tight">Garansi<br>Produk</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @else
        {{-- Empty Cart --}}
        <div class="text-center py-20">
            <div class="w-24 h-24 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Keranjang Kosong</h2>
            <p class="text-sm text-gray-400 mb-8 max-w-sm mx-auto">Belum ada produk di keranjang belanja Anda. Mulai jelajahi koleksi kami!</p>
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center justify-center gap-2 bg-[#013D29] text-white px-8 py-3.5 rounded-full font-semibold text-sm hover:bg-[#025c3e] transition-all duration-300 shadow-lg hover:shadow-xl active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Belanja Sekarang
            </a>
        </div>
    @endif

</div>
@endsection
