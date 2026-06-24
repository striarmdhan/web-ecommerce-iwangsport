@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.orders.index') }}" 
           class="p-2 rounded-xl text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Pesanan</h1>
            <p class="text-sm text-gray-500 mt-0.5">Invoice #{{ $order->invoice_number }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Left: Order Info --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- Order Items --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Item Pesanan
                </h2>
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-50 text-amber-700',
                        'shipping_confirmed' => 'bg-orange-50 text-orange-700',
                        'waiting_verification' => 'bg-blue-50 text-blue-700',
                        'verified' => 'bg-emerald-50 text-emerald-700',
                        'rejected' => 'bg-red-50 text-red-700',
                        'processing' => 'bg-indigo-50 text-indigo-700',
                        'shipped' => 'bg-purple-50 text-purple-700',
                        'completed' => 'bg-emerald-50 text-emerald-700',
                        'cancelled' => 'bg-gray-100 text-gray-600',
                    ];
                @endphp
                <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium {{ $statusColors[$order->status->value] ?? 'bg-gray-100 text-gray-600' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-60"></span>
                    {{ $order->status->label() }}
                </span>
            </div>

            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $item->product_name }}</p>
                            @if($item->variant_info)
                                <p class="text-xs text-gray-400 mt-0.5">{{ $item->variant_info }}</p>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <p class="text-sm font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Shipping Address --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6">
            <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2 mb-4">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Alamat Pengiriman
            </h2>
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-sm font-semibold text-gray-900">{{ $order->recipient_name }}</p>
                <p class="text-sm text-gray-500 mt-0.5">{{ $order->recipient_phone }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $order->shipping_address }}</p>
                @if($order->tracking_number)
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <p class="text-xs font-medium text-gray-400 mb-1">No. Resi</p>
                        <p class="text-sm font-semibold text-[#013D29]">{{ $order->tracking_number }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Right: Summary Sidebar --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-24 space-y-5">
            <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Ringkasan Pembayaran
            </h2>
            
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Ongkir</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-100">
                    <span class="text-gray-900 font-semibold">Total</span>
                    <span class="text-lg font-bold text-[#013D29]">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Payment Proof --}}
            @if($order->payment && $order->payment->proof_path)
                <div class="border-t border-gray-100 pt-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Bukti Pembayaran</h3>
                    <div class="rounded-xl overflow-hidden border border-gray-100">
                        <img src="{{ asset('storage/' . $order->payment->proof_path) }}" alt="Bukti Pembayaran"
                             class="w-full">
                    </div>
                    
                    @if($order->status->value === 'waiting_verification')
                        <div class="flex gap-2 mt-4">
                            <form method="POST" action="{{ route('admin.orders.verify', $order->id) }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" 
                                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-[#013D29] text-white text-xs font-semibold rounded-xl hover:bg-[#025c3e] transition-all duration-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Verifikasi
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.orders.verify', $order->id) }}" class="flex-1">
                                @csrf
                                <input type="hidden" name="action" value="reject">
                                <button type="submit" 
                                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500 text-white text-xs font-semibold rounded-xl hover:bg-red-600 transition-all duration-200">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Tolak
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Update Shipping Cost --}}
            @if(in_array($order->status->value, ['pending', 'shipping_confirmed', 'verified', 'processing']))
                <div class="border-t border-gray-100 pt-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Update Ongkir</h3>
                    <form method="POST" action="{{ route('admin.orders.shipping', $order->id) }}" class="space-y-3">
                        @csrf
                        <input type="number" name="shipping_cost" value="{{ $order->shipping_cost }}" 
                               class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all" 
                               placeholder="Masukkan ongkir">
                        <button type="submit" 
                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-gray-200 text-gray-700 text-xs font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200">
                            Update Ongkir
                        </button>
                    </form>
                </div>
            @endif

            {{-- Ship Order --}}
            @if($order->status->value === 'verified' || $order->status->value === 'processing')
                <div class="border-t border-gray-100 pt-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-3">Kirim Pesanan</h3>
                    <form method="POST" action="{{ route('admin.orders.ship', $order->id) }}" class="space-y-3">
                        @csrf
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" 
                               class="w-full px-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all" 
                               placeholder="Nomor resi (opsional)">
                        <button type="submit" 
                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-[#013D29] text-white text-xs font-semibold rounded-xl hover:bg-[#025c3e] transition-all duration-200">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            Tandai Dikirim
                        </button>
                    </form>
                </div>
            @endif

            {{-- Complete Order --}}
            @if($order->status->value === 'shipped')
                <div class="border-t border-gray-100 pt-5">
                    <form method="POST" action="{{ route('admin.orders.complete', $order->id) }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#013D29] text-white text-sm font-semibold rounded-xl hover:bg-[#025c3e] transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Tandai Selesai
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
