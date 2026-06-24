@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Produk</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola semua produk toko Anda</p>
        </div>
        <a href="{{ route('admin.products.create') }}" 
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#013D29] text-white text-sm font-semibold rounded-xl hover:bg-[#025c3e] transition-all duration-200 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Produk
        </a>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Total Produk</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $products->total() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Aktif</p>
        <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $products->where('is_active', true)->count() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Stok Habis</p>
        <p class="text-2xl font-bold text-red-500 mt-1">{{ $products->where('total_stock', 0)->count() }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">Kategori</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $products->pluck('category_id')->unique()->count() }}</p>
    </div>
</div>

{{-- Products Table --}}
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Produk</th>
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</th>
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Harga</th>
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Varian</th>
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Stok</th>
                    <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="text-right py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        {{-- Product Name + Image --}}
                        <td class="py-4 px-5">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-[#F5F6F6] rounded-xl overflow-hidden flex-shrink-0">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($product->slug, 30) }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Category --}}
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 text-xs font-medium text-gray-600">
                                {{ $product->category->name ?? '-' }}
                            </span>
                        </td>

                        {{-- Price --}}
                        <td class="py-4 px-5">
                            <span class="text-sm font-bold text-gray-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </td>

                        {{-- Variants (Size & Color) --}}
                        <td class="py-4 px-5">
                            @if($product->variants->count() > 0)
                                <div class="flex flex-wrap gap-1.5 max-w-[200px]">
                                    @php
                                        $colors = $product->variants->whereNotNull('color')->pluck('color')->unique();
                                        $sizes = $product->variants->whereNotNull('size')->pluck('size')->unique();
                                    @endphp
                                    @foreach($sizes as $size)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-gray-100 text-[11px] font-semibold text-gray-600">
                                            {{ $size }}
                                        </span>
                                    @endforeach
                                    @foreach($colors as $color)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-gray-100 text-[11px] font-medium text-gray-600">
                                            <span class="w-2.5 h-2.5 rounded-full border border-gray-200" style="background-color: {{ strtolower($color) }};"></span>
                                            {{ $color }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-gray-300">-</span>
                            @endif
                        </td>

                        {{-- Stock --}}
                        <td class="py-4 px-5">
                            @if($product->total_stock > 0)
                                <span class="text-sm font-semibold text-gray-900">{{ $product->total_stock }}</span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-red-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Habis
                                </span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="py-4 px-5">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $product->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $product->is_active ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="py-4 px-5">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.products.edit', $product->id) }}" 
                                   class="p-2 rounded-lg text-gray-400 hover:text-[#013D29] hover:bg-gray-100 transition-colors"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <p class="text-gray-400 font-medium">Belum ada produk</p>
                            <p class="text-gray-300 text-sm mt-1">Mulai tambahkan produk pertama Anda</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
