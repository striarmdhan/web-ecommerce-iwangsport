@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Selamat datang di panel admin Iwangsport</p>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-lg bg-[#013D29]/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-[#013D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Pesanan</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_orders'] }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pending</p>
        <p class="text-2xl font-bold text-amber-500 mt-1">{{ $stats['pending_orders'] }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Produk</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_products'] }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pelanggan</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_customers'] }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pendapatan</p>
        <p class="text-lg font-bold text-emerald-600 mt-1">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
    </div>
</div>

{{-- Recent Orders --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Pesanan Terbaru
        </h2>
    </div>

    @if($recentOrders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Invoice</th>
                        <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                        <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Total</th>
                        <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="text-right py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentOrders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-4 px-5">
                                <span class="text-sm font-semibold text-gray-900">#{{ $order->invoice_number }}</span>
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-[#013D29]/10 flex items-center justify-center text-[#013D29] text-xs font-bold flex-shrink-0">
                                        {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm text-gray-700">{{ $order->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="text-sm font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-4 px-5">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-amber-50 text-amber-700',
                                        'waiting_verification' => 'bg-blue-50 text-blue-700',
                                        'verified' => 'bg-emerald-50 text-emerald-700',
                                        'processing' => 'bg-indigo-50 text-indigo-700',
                                        'shipped' => 'bg-purple-50 text-purple-700',
                                        'completed' => 'bg-emerald-50 text-emerald-700',
                                        'cancelled' => 'bg-red-50 text-red-700',
                                    ];
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->status->value] ?? 'bg-gray-100 text-gray-600' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-60"></span>
                                    {{ $order->status->label() }}
                                </span>
                            </td>
                            <td class="py-4 px-5">
                                <span class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="py-4 px-5">
                                <div class="flex items-center justify-end">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" 
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-[#013D29] bg-[#013D29]/5 hover:bg-[#013D29]/10 rounded-lg transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="py-16 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <p class="text-gray-400 font-medium">Belum ada pesanan</p>
            <p class="text-gray-300 text-sm mt-1">Pesanan akan muncul di sini</p>
        </div>
    @endif
</div>
@endsection
