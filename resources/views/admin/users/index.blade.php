@extends('layouts.admin')

@section('title', 'Daftar Pelanggan')

@section('content')
<div class="mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pelanggan</h1>
        <p class="text-sm text-gray-500 mt-1">Daftar pelanggan terdaftar</p>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Pelanggan</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $users->total() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Dengan Pesanan</p>
        <p class="text-2xl font-bold text-[#013D29] mt-1">{{ $users->where('orders_count', '>', 0)->count() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Baru (Bulan Ini)</p>
        <p class="text-2xl font-bold text-blue-500 mt-1">{{ $users->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
    </div>
</div>

{{-- Users Table --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">No. HP</th>
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Pesanan</th>
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Terdaftar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        {{-- Name + Avatar --}}
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-[#013D29] flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $user->name }}</span>
                            </div>
                        </td>

                        {{-- Email --}}
                        <td class="py-4 px-5">
                            <span class="text-sm text-gray-500">{{ $user->email }}</span>
                        </td>

                        {{-- Phone --}}
                        <td class="py-4 px-5">
                            <span class="text-sm text-gray-700">{{ $user->phone ?? '-' }}</span>
                        </td>

                        {{-- Order Count --}}
                        <td class="py-4 px-5">
                            @if($user->orders_count > 0)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-[#013D29]/10 text-xs font-semibold text-[#013D29]">
                                    {{ $user->orders_count }} pesanan
                                </span>
                            @else
                                <span class="text-xs text-gray-300">-</span>
                            @endif
                        </td>

                        {{-- Registered --}}
                        <td class="py-4 px-5">
                            <span class="text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <p class="text-gray-400 font-medium">Belum ada pelanggan</p>
                            <p class="text-gray-300 text-sm mt-1">Pelanggan akan muncul di sini setelah registrasi</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
