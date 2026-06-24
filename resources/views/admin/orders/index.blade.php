@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pesanan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola semua pesanan pelanggan</p>
        </div>
        <div class="flex items-center gap-2">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="flex items-center gap-2">
                <select name="status" onchange="this.form.submit()" 
                        class="px-4 py-2.5 bg-gray-50 border-none rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all cursor-pointer appearance-none min-w-[180px]">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi Ongkir</option>
                    <option value="shipping_confirmed" {{ request('status') == 'shipping_confirmed' ? 'selected' : '' }}>Siap Dibayar</option>
                    <option value="waiting_verification" {{ request('status') == 'waiting_verification' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Diverifikasi</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </form>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Pesanan</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $orders->total() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Pending</p>
        <p class="text-2xl font-bold text-amber-500 mt-1">{{ $orders->where('status', 'pending')->count() + $orders->where('status', 'waiting_verification')->count() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Dikirim</p>
        <p class="text-2xl font-bold text-blue-500 mt-1">{{ $orders->where('status', 'shipped')->count() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Selesai</p>
        <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $orders->where('status', 'completed')->count() }}</p>
    </div>
</div>

{{-- Orders Table --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
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
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        {{-- Invoice --}}
                        <td class="py-4 px-5">
                            <span class="text-sm font-semibold text-gray-900">#{{ $order->invoice_number }}</span>
                        </td>

                        {{-- Customer --}}
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#013D29]/10 flex items-center justify-center text-[#013D29] text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($order->user->name, 0, 1)) }}
                                </div>
                                <span class="text-sm text-gray-700">{{ $order->user->name }}</span>
                            </div>
                        </td>

                        {{-- Total --}}
                        <td class="py-4 px-5">
                            <span class="text-sm font-bold text-gray-900">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="py-4 px-5">
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
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->status->value] ?? 'bg-gray-100 text-gray-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $order->status->value === 'completed' ? 'bg-emerald-500' : ($order->status->value === 'cancelled' ? 'bg-red-500' : 'bg-current opacity-60') }}"></span>
                                {{ $order->status->label() }}
                            </span>
                        </td>

                        {{-- Date --}}
                        <td class="py-4 px-5">
                            <span class="text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</span>
                        </td>

                        {{-- Action --}}
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
                @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p class="text-gray-400 font-medium">Belum ada pesanan</p>
                            <p class="text-gray-300 text-sm mt-1">Pesanan akan muncul di sini</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
