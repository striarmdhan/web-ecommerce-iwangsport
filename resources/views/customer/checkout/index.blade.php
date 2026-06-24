@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-[1400px] mx-auto px-6 lg:px-10 py-8" x-data="checkoutApp()">

    {{-- Header --}}
    <div class="mb-8">
        <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-[#013D29] transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Keranjang
        </a>
        <h1 class="text-2xl font-bold text-gray-900">Checkout</h1>
        <p class="text-sm text-gray-500 mt-1">Lengkapi informasi pengiriman dan pembayaran Anda</p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-100 rounded-2xl p-4 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-red-700 mb-1">Terjadi kesalahan</p>
                    <ul class="text-sm text-red-600 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.store') }}" id="checkoutForm">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Left: Form Sections --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Shipping Address --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#013D29]/5 flex items-center justify-center">
                                <svg class="w-4 h-4 text-[#013D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h2 class="text-base font-bold text-gray-900">Alamat Pengiriman</h2>
                        </div>
                        <button type="button" @click="showAddressModal = true"
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold text-[#013D29] bg-[#013D29]/5 hover:bg-[#013D29]/10 rounded-full transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Alamat
                        </button>
                    </div>

                    <div class="p-6">
                        @if($addresses->count() > 0)
                            <div class="space-y-3">
                                @foreach($addresses as $address)
                                    <label class="flex items-start gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200 {{ $address->is_default ? 'border-[#013D29] bg-[#013D29]/[0.02]' : 'border-gray-100 hover:border-gray-200 bg-white' }}">
                                        <input type="radio" name="address_id" value="{{ $address->id }}" 
                                               {{ $address->is_default ? 'checked' : '' }}
                                               class="mt-1 accent-[#013D29]">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <p class="text-sm font-bold text-gray-900">{{ $address->label }}</p>
                                                @if($address->is_default)
                                                    <span class="text-[10px] font-semibold bg-[#013D29] text-white px-2 py-0.5 rounded-full">Utama</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-500">{{ $address->recipient }} &middot; {{ $address->phone }}</p>
                                            <p class="text-xs text-gray-400 mt-1 leading-relaxed">{{ $address->full_address }}</p>
                                        </div>
                                        <div class="flex items-center gap-1 shrink-0">
                                            {{-- Edit --}}
                                            <button type="button"
                                                    @click="editAddress({{ $address->toJson() }})"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-[#013D29] hover:bg-[#013D29]/5 transition-colors"
                                                    title="Edit Alamat">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </button>
                                            {{-- Delete --}}
                                            <button type="button"
                                                    onclick="if(confirm('Yakin ingin menghapus alamat ini?')){ fetch('{{ route('addresses.destroy', $address->id) }}', { method: 'DELETE', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'} }).then(r => { if(r.ok) window.location.reload(); else alert('Gagal menghapus alamat'); }); }"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                                                    title="Hapus Alamat">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10">
                                <div class="w-14 h-14 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 mb-4">Belum ada alamat terdaftar.</p>
                                <button type="button" @click="showAddressModal = true"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-[#013D29] bg-[#013D29]/5 hover:bg-[#013D29]/10 px-5 py-2.5 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Alamat
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-50">
                        <div class="w-8 h-8 rounded-full bg-[#013D29]/5 flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#013D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <h2 class="text-base font-bold text-gray-900">Metode Pembayaran</h2>
                    </div>

                    <div class="p-6 space-y-3">
                        {{-- QRIS --}}
                        <label class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                               :class="paymentMethod === 'qris' ? 'border-[#013D29] bg-[#013D29]/[0.02]' : 'border-gray-100 hover:border-gray-200'">
                            <input type="radio" name="payment_method" value="qris" x-model="paymentMethod"
                                   class="accent-[#013D29]">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">QRIS</p>
                                    <p class="text-xs text-gray-400">Bayar dengan scan QR Code</p>
                                </div>
                            </div>
                        </label>

                        {{-- Transfer Bank --}}
                        <label class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                               :class="paymentMethod === 'transfer' ? 'border-[#013D29] bg-[#013D29]/[0.02]' : 'border-gray-100 hover:border-gray-200'">
                            <input type="radio" name="payment_method" value="transfer" x-model="paymentMethod"
                                   class="accent-[#013D29]">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">Transfer Bank</p>
                                    <p class="text-xs text-gray-400">Transfer ke rekening bank kami</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-50">
                        <div class="w-8 h-8 rounded-full bg-[#013D29]/5 flex items-center justify-center">
                            <svg class="w-4 h-4 text-[#013D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                        </div>
                        <h2 class="text-base font-bold text-gray-900">Catatan Pesanan</h2>
                    </div>
                    <div class="p-6">
                        <textarea name="notes" rows="3" 
                                  class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 focus:bg-white transition-all resize-none"
                                  placeholder="Tambahkan catatan untuk pesanan ini (opsional)">{{ old('notes') }}</textarea>
                    </div>
                </div>

            </div>

            {{-- Right: Order Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-gray-900 mb-5">Ringkasan Pesanan</h2>

                    {{-- Items --}}
                    <div class="space-y-4 mb-6">
                        @foreach($cart->items as $item)
                            <div class="flex items-center gap-3">
                                <div class="w-14 h-14 bg-[#F5F6F6] rounded-xl overflow-hidden shrink-0 flex items-center justify-center">
                                    @if($item->productVariant->product->image)
                                        <img src="{{ asset('storage/' . $item->productVariant->product->image) }}" 
                                             alt="{{ $item->productVariant->product->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-gray-900 line-clamp-1">{{ $item->productVariant->product->name }}</p>
                                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $item->productVariant->variant_label }} &middot; x{{ $item->quantity }}</p>
                                </div>
                                <span class="text-xs font-bold text-gray-900 shrink-0">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Totals --}}
                    <div class="border-t border-gray-100 pt-4 space-y-3 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Subtotal</span>
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

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full flex items-center justify-center gap-3 bg-[#013D29] text-white py-4 rounded-full font-semibold text-base hover:bg-[#025c3e] transition-all duration-300 shadow-lg hover:shadow-xl active:scale-[0.98]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Buat Pesanan
                    </button>

                    {{-- Info --}}
                    <p class="text-[11px] text-gray-400 text-center mt-4 leading-relaxed">
                        Dengan membuat pesanan, Anda menyetujui 
                        <a href="#" class="text-[#013D29] underline underline-offset-2">Syarat & Ketentuan</a> kami.
                    </p>

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
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            </div>
                            <p class="text-[11px] text-gray-400 leading-tight">Pengiriman<br>Cepat</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>

    {{-- ==================== ADDRESS MODAL ==================== --}}
    <div x-show="showAddressModal" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="closeAddressModal()"></div>

        {{-- Modal --}}
        <div x-show="showAddressModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-gray-900" x-text="editingAddress ? 'Edit Alamat' : 'Tambah Alamat Baru'"></h3>
                    <p class="text-xs text-gray-400 mt-0.5" x-text="editingAddress ? 'Perbarui informasi alamat pengiriman' : 'Simpan alamat untuk pengiriman yang lebih cepat'"></p>
                </div>
                <button type="button" @click="closeAddressModal()"
                        class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-50 hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Modal Form --}}
            <form :action="editingAddress ? '{{ url('/addresses') }}/' + editingAddress.id : '{{ route('addresses.store') }}'" 
                  method="POST" class="p-6 space-y-5">
                @csrf
                <template x-if="editingAddress">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                {{-- Label --}}
                <div>
                    <label for="modal-label" class="block text-sm font-semibold text-gray-900 mb-2">Label Alamat</label>
                    <div class="flex gap-2">
                        <template x-for="lbl in ['Rumah', 'Kantor', 'Kos']" :key="lbl">
                            <button type="button"
                                    @click="formData.label = lbl"
                                    :class="formData.label === lbl ? 'bg-[#013D29] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'"
                                    class="px-4 py-2 rounded-full text-xs font-semibold transition-all duration-200"
                                    x-text="lbl"></button>
                        </template>
                    </div>
                    <input type="text" name="label" id="modal-label" x-model="formData.label"
                           placeholder="Atau ketik label lain..."
                           class="w-full mt-2 px-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 focus:bg-white transition-all">
                </div>

                {{-- Recipient --}}
                <div>
                    <label for="modal-recipient" class="block text-sm font-semibold text-gray-900 mb-2">Nama Penerima</label>
                    <input type="text" name="recipient" id="modal-recipient" x-model="formData.recipient"
                           placeholder="Nama lengkap penerima"
                           class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 focus:bg-white transition-all"
                           required>
                </div>

                {{-- Phone --}}
                <div>
                    <label for="modal-phone" class="block text-sm font-semibold text-gray-900 mb-2">Nomor Telepon</label>
                    <input type="text" name="phone" id="modal-phone" x-model="formData.phone"
                           placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 focus:bg-white transition-all"
                           required>
                </div>

                {{-- Full Address --}}
                <div>
                    <label for="modal-full_address" class="block text-sm font-semibold text-gray-900 mb-2">Alamat Lengkap</label>
                    <textarea name="full_address" id="modal-full_address" rows="3" x-model="formData.full_address"
                              placeholder="Jl. Contoh No. 123, RT/RW, Kelurahan, Kecamatan, Kota, Provinsi, Kodepos"
                              class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 focus:bg-white transition-all resize-none"
                              required></textarea>
                </div>

                {{-- Set as Default --}}
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_default" value="1" x-model="formData.is_default"
                           class="w-4 h-4 rounded border-gray-300 accent-[#013D29]">
                    <span class="text-sm text-gray-600">Jadikan alamat utama</span>
                </label>

                {{-- Submit --}}
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="closeAddressModal()"
                            class="flex-1 py-3 rounded-full border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-3 rounded-full bg-[#013D29] text-white text-sm font-semibold hover:bg-[#025c3e] transition-all shadow-lg hover:shadow-xl active:scale-[0.98]">
                        <span x-text="editingAddress ? 'Perbarui Alamat' : 'Simpan Alamat'"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>

<script>
function checkoutApp() {
    return {
        showAddressModal: false,
        editingAddress: null,
        paymentMethod: 'qris',
        formData: {
            label: '',
            recipient: '',
            phone: '',
            full_address: '',
            is_default: false,
        },

        editAddress(address) {
            this.editingAddress = address;
            this.formData = {
                label: address.label || '',
                recipient: address.recipient || '',
                phone: address.phone || '',
                full_address: address.full_address || '',
                is_default: address.is_default || false,
            };
            this.showAddressModal = true;
        },

        closeAddressModal() {
            this.showAddressModal = false;
            this.editingAddress = null;
            this.formData = {
                label: '',
                recipient: '',
                phone: '',
                full_address: '',
                is_default: false,
            };
        }
    };
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
