@extends('layouts.admin')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Kategori</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola kategori produk toko Anda</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Left: Add Category Form --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-24">
            <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2 mb-5">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Kategori
            </h2>
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                    <input type="text" name="name" id="name" required
                           class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                           placeholder="Contoh: Celana Panjang">
                    @error('name')
                        <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <button type="submit" 
                        class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-[#013D29] text-white text-sm font-semibold rounded-xl hover:bg-[#025c3e] transition-all duration-200 shadow-sm hover:shadow-md active:scale-[0.98]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Kategori
                </button>
            </form>
        </div>
    </div>

    {{-- Right: Categories Table --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</th>
                            <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Jumlah Produk</th>
                            <th class="text-left py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Slug</th>
                            <th class="text-right py-4 px-5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                {{-- Name --}}
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-[#013D29]/10 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-4 h-4 text-[#013D29]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-900">{{ $category->name }}</span>
                                    </div>
                                </td>

                                {{-- Product Count --}}
                                <td class="py-4 px-5">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-gray-100 text-xs font-semibold text-gray-700">
                                        {{ $category->products_count }} produk
                                    </span>
                                </td>

                                {{-- Slug --}}
                                <td class="py-4 px-5">
                                    <span class="text-xs text-gray-400 font-mono">{{ $category->slug }}</span>
                                </td>

                                {{-- Actions --}}
                                <td class="py-4 px-5">
                                    <div class="flex items-center justify-end">
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="inline">
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
                                <td colspan="4" class="py-16 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    <p class="text-gray-400 font-medium">Belum ada kategori</p>
                                    <p class="text-gray-300 text-sm mt-1">Tambahkan kategori pertama Anda</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
