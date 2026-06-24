@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-[1400px] mx-auto px-6 lg:px-10 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Pesanan Saya</h1>
        <p class="text-sm text-gray-500 mt-1">Lacak status pesanan dan pembayaran Anda</p>
    </div>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order->id) }}" 
                   class="group block bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        
                        {{-- Left --}}
                        <div class="flex items-start gap-4">
                            {{-- Icon --}}
                            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <p class="text-sm font-bold text-gray-900">{{ $order->invoice_number }}</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $order->status->badgeColor() }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-xs text-gray-500">{{ $order->items->count() }} item</span>
                                    <span class="text-[10px] text-gray-300">|</span>
                                    <span class="text-xs text-gray-500">{{ $order->payment->method->label() }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Right --}}
                        <div class="flex items-center gap-4 sm:text-right">
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Total Pembayaran</p>
                                <p class="text-lg font-bold text-gray-900">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-gray-300 group-hover:text-[#013D29] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $orders->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-20">
            <div class="w-24 h-24 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h2>
            <p class="text-sm text-gray-400 mb-8 max-w-sm mx-auto">Anda belum membuat pesanan apapun. Mulai jelajahi koleksi kami!</p>
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
