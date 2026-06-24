@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-[1400px] mx-auto px-6 lg:px-10 py-8" x-data="orderShowApp()">

    {{-- Back Button --}}
    <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-[#013D29] transition-colors mb-8">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Pesanan
    </a>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
            <div class="flex items-center gap-3 mt-1.5">
                <p class="text-sm text-gray-500">{{ $order->invoice_number }}</p>
                <span class="text-gray-300">&middot;</span>
                <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
        </div>
        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-semibold {{ $order->status->badgeColor() }}">
            {{ $order->status->label() }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left: Order Details --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Order Items --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-50">
                    <div class="w-8 h-8 rounded-full bg-[#013D29]/5 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#013D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-gray-900">Item Pesanan</h2>
                    <span class="text-xs text-gray-400 ml-auto">{{ $order->items->count() }} item</span>
                </div>

                <div class="p-6 space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-[#F5F6F6] rounded-xl overflow-hidden shrink-0 flex items-center justify-center">
                                @if($item->productVariant && $item->productVariant->product->image)
                                    <img src="{{ asset('storage/' . $item->productVariant->product->image) }}" 
                                         alt="{{ $item->product_name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $item->variant_info }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $item->quantity }} &times; Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-sm font-bold text-gray-900 shrink-0">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Shipping Address --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-50">
                    <div class="w-8 h-8 rounded-full bg-[#013D29]/5 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#013D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-base font-bold text-gray-900">Alamat Pengiriman</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $order->recipient_name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $order->recipient_phone }}</p>
                            <p class="text-xs text-gray-400 mt-1.5 leading-relaxed">{{ $order->shipping_address }}</p>
                            @if($order->shipping_note)
                                <p class="text-xs text-gray-400 mt-2 italic">Catatan: {{ $order->shipping_note }}</p>
                            @endif
                        </div>
                    </div>
                    @if($order->tracking_number)
                        <div class="mt-4 p-3 bg-[#013D29]/5 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#013D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-gray-900">No. Resi</p>
                                <p class="text-sm font-bold text-[#013D29]">{{ $order->tracking_number }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- Right: Payment & Summary --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Order Summary --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 mb-5">Ringkasan Pembayaran</h2>

                <div class="space-y-3 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Subtotal</span>
                        <span class="text-sm font-semibold text-gray-900">
                            Rp {{ number_format($order->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Ongkos Kirim</span>
                        @if($order->shipping_cost > 0)
                            <span class="text-sm font-semibold text-gray-900">
                                Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="text-xs font-medium text-gray-400 bg-gray-50 px-3 py-1 rounded-full">Belum ditentukan</span>
                        @endif
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="text-base font-bold text-gray-900">Total</span>
                        <span class="text-xl font-bold text-gray-900">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">Metode Pembayaran</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $order->payment->method->label() }}</span>
                    </div>

                    {{-- ============ STATUS: PENDING (Menunggu Konfirmasi Ongkir) ============ --}}
                    @if($order->status->value === 'pending')
                        <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-amber-800">Menunggu Konfirmasi Ongkir</p>
                                    <p class="text-xs text-amber-600 mt-1 leading-relaxed">Pesanan Anda sedang menunggu admin mengkonfirmasi ongkos kirim. Tombol pembayaran akan muncul setelah ongkir dikonfirmasi.</p>
                                </div>
                            </div>
                        </div>

                    {{-- ============ STATUS: SHIPPING_CONFIRMED (Siap Dibayar) ============ --}}
                    @elseif($order->status->value === 'shipping_confirmed')
                        {{-- Payment Info Button --}}
                        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 mb-2">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-emerald-800">Ongkir Dikonfirmasi</p>
                                    <p class="text-xs text-emerald-600 mt-1">Ongkos kirim sebesar <span class="font-semibold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>. Silakan lakukan pembayaran.</p>
                                </div>
                            </div>
                        </div>

                        <button type="button" @click="showPaymentInfo = true"
                                class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl border-2 border-gray-100 text-sm font-semibold text-gray-700 hover:border-[#013D29] hover:text-[#013D29] transition-all">
                            @if($order->payment->method->value === 'qris')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                                Lihat QRIS
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                                Lihat Rekening
                            @endif
                        </button>

                        {{-- Change Payment Method --}}
                        <button type="button" @click="showChangePayment = true"
                                class="w-full flex items-center justify-center gap-2 py-3 rounded-xl bg-gray-50 text-sm font-semibold text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Ubah Metode Pembayaran
                        </button>

                        {{-- Upload Payment Proof --}}
                        <div class="border-t border-gray-100 pt-4 mt-2">
                            <h3 class="text-sm font-bold text-gray-900 mb-3">Upload Bukti Pembayaran</h3>
                            <form method="POST" action="{{ route('orders.payment', $order->id) }}" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <div class="relative">
                                    <input type="file" name="payment_proof" accept="image/*" id="payment_proof" required
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                           onchange="document.getElementById('file-label').textContent = this.files[0]?.name || 'Pilih foto bukti pembayaran'">
                                    <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 hover:border-[#013D29]/30 transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm text-gray-500" id="file-label">Pilih foto bukti pembayaran</span>
                                    </div>
                                </div>
                                <button type="submit" 
                                        class="w-full flex items-center justify-center gap-2 bg-[#013D29] text-white py-3.5 rounded-full text-sm font-semibold hover:bg-[#025c3e] transition-all shadow-lg hover:shadow-xl active:scale-[0.98]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Upload Bukti Pembayaran
                                </button>
                            </form>
                        </div>

                    {{-- ============ STATUS: WAITING VERIFICATION ============ --}}
                    @elseif($order->status->value === 'waiting_verification')
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-blue-800">Menunggu Verifikasi</p>
                                    <p class="text-xs text-blue-600 mt-1 leading-relaxed">Bukti pembayaran sudah diupload. Menunggu verifikasi dari admin.</p>
                                </div>
                            </div>
                        </div>

                    {{-- ============ STATUS: REJECTED ============ --}}
                    @elseif($order->status->value === 'rejected')
                        <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-2">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-red-800">Pembayaran Ditolak</p>
                                    <p class="text-xs text-red-600 mt-1 leading-relaxed">Bukti pembayaran ditolak oleh admin. Silakan upload ulang bukti pembayaran yang valid.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Re-upload button --}}
                        <button type="button" @click="showPaymentInfo = true"
                                class="w-full flex items-center justify-center gap-2 py-3.5 rounded-xl border-2 border-gray-100 text-sm font-semibold text-gray-700 hover:border-[#013D29] hover:text-[#013D29] transition-all mb-2">
                            @if($order->payment->method->value === 'qris')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                                Lihat QRIS
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                                Lihat Rekening
                            @endif
                        </button>

                        <div class="border-t border-gray-100 pt-4 mt-2">
                            <h3 class="text-sm font-bold text-gray-900 mb-3">Upload Ulang Bukti Pembayaran</h3>
                            <form method="POST" action="{{ route('orders.payment', $order->id) }}" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <div class="relative">
                                    <input type="file" name="payment_proof" accept="image/*" id="payment_proof_re" required
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                           onchange="document.getElementById('file-label-re').textContent = this.files[0]?.name || 'Pilih foto bukti pembayaran'">
                                    <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 hover:border-[#013D29]/30 transition-colors">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm text-gray-500" id="file-label-re">Pilih foto bukti pembayaran baru</span>
                                    </div>
                                </div>
                                <button type="submit" 
                                        class="w-full flex items-center justify-center gap-2 bg-[#013D29] text-white py-3.5 rounded-full text-sm font-semibold hover:bg-[#025c3e] transition-all shadow-lg hover:shadow-xl active:scale-[0.98]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Upload Ulang Bukti
                                </button>
                            </form>
                        </div>

                    @endif

                    {{-- Show Existing Proof (for waiting_verification, verified, processing, shipped, completed) --}}
                    @if($order->payment->proof_path && !in_array($order->status->value, ['pending', 'shipping_confirmed', 'rejected']))
                        <div class="border-t border-gray-100 pt-4 mt-4">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-bold text-gray-900">Bukti Pembayaran</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold
                                    @if($order->payment->status->value === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->payment->status->value === 'verified') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ $order->payment->status->label() }}
                                </span>
                            </div>
                            <div class="rounded-xl overflow-hidden border border-gray-100">
                                <img src="{{ asset('storage/' . $order->payment->proof_path) }}" alt="Bukti Pembayaran"
                                     class="w-full">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- ============ PAYMENT INFO MODAL (QRIS / Bank) ============ --}}
    <div x-show="showPaymentInfo" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4">

        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showPaymentInfo = false"></div>

        <div x-show="showPaymentInfo"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">
                        @if($order->payment->method->value === 'qris')
                            Pembayaran QRIS
                        @else
                            Transfer Bank
                        @endif
                    </h3>
                    <p class="text-xs text-gray-400 mt-0.5">Selesaikan pembayaran Anda</p>
                </div>
                <button type="button" @click="showPaymentInfo = false"
                        class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-50 hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Content --}}
            <div class="p-6">
                @if($order->payment->method->value === 'qris')
                    <div class="text-center">
                        @if($storeSettings->qris_image)
                            <div class="bg-white rounded-2xl border border-gray-100 p-4 mb-4 inline-block">
                                <img src="{{ asset('storage/' . $storeSettings->qris_image) }}" alt="QRIS Payment"
                                     class="w-64 h-64 object-contain mx-auto">
                            </div>
                        @else
                            <div class="w-64 h-64 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                    <p class="text-sm text-gray-400">QRIS belum tersedia</p>
                                </div>
                            </div>
                        @endif
                        <p class="text-sm text-gray-500">Scan QR Code di atas menggunakan aplikasi pembayaran Anda</p>
                        <p class="text-xs text-gray-400 mt-2">Total: <span class="font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span></p>
                    </div>
                @else
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-xl p-5 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">Bank</span>
                                <span class="text-sm font-bold text-gray-900">{{ $storeSettings->bank_name ?? '-' }}</span>
                            </div>
                            <div class="border-t border-gray-100 pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">No. Rekening</span>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-gray-900 font-mono tracking-wide">{{ $storeSettings->account_number ?? '-' }}</span>
                                        <button type="button" 
                                                onclick="navigator.clipboard.writeText('{{ $storeSettings->account_number }}').then(() => { this.innerHTML = '<svg class=\'w-4 h-4 text-green-500\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'></path></svg>'; setTimeout(() => this.innerHTML = '<svg class=\'w-4 h-4 text-gray-400\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3\'></path></svg>', 2000) })"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-[#013D29] hover:bg-[#013D29]/5 transition-colors"
                                                title="Salin nomor rekening">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 pt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Atas Nama</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $storeSettings->account_holder ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-500">Transfer sejumlah</p>
                            <p class="text-2xl font-bold text-[#013D29] mt-1">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ============ CHANGE PAYMENT METHOD MODAL ============ --}}
    <div x-show="showChangePayment" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center p-4">

        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="showChangePayment = false"></div>

        <div x-show="showChangePayment"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Ubah Metode Pembayaran</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Pilih metode pembayaran baru</p>
                </div>
                <button type="button" @click="showChangePayment = false"
                        class="w-9 h-9 flex items-center justify-center rounded-full bg-gray-50 hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Content --}}
            <form method="POST" action="{{ route('orders.changePaymentMethod', $order->id) }}" class="p-6 space-y-3">
                @csrf
                @method('PUT')

                <div class="bg-gray-50 rounded-xl p-3 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-xs text-gray-500">Saat ini: <span class="font-semibold text-gray-700">{{ $order->payment->method->label() }}</span></p>
                </div>

                <label class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                       :class="newPaymentMethod === 'qris' ? 'border-[#013D29] bg-[#013D29]/[0.02]' : 'border-gray-100 hover:border-gray-200'">
                    <input type="radio" name="payment_method" value="qris" x-model="newPaymentMethod"
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

                <label class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                       :class="newPaymentMethod === 'transfer' ? 'border-[#013D29] bg-[#013D29]/[0.02]' : 'border-gray-100 hover:border-gray-200'">
                    <input type="radio" name="payment_method" value="transfer" x-model="newPaymentMethod"
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

                <div class="flex gap-3 pt-4">
                    <button type="button" @click="showChangePayment = false"
                            class="flex-1 py-3 rounded-full border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-3 rounded-full bg-[#013D29] text-white text-sm font-semibold hover:bg-[#025c3e] transition-all shadow-lg hover:shadow-xl active:scale-[0.98]">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function orderShowApp() {
    return {
        showPaymentInfo: false,
        showChangePayment: false,
        newPaymentMethod: '{{ $order->payment->method->value }}',
    };
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
