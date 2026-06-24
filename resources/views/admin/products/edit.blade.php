@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.products.index') }}" 
           class="p-2 rounded-xl text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
            <p class="text-sm text-gray-500 mt-0.5">Ubah informasi produk "{{ $product->name }}"</p>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="max-w-4xl">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Left Column: Main Info --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Product Info Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-5">
                <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Produk
                </h2>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all">
                    @error('name')
                        <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="category_id" id="category_id" required 
                            class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all cursor-pointer appearance-none">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp)</label>
                    <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required min="0"
                           class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all">
                    @error('price')
                        <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="description" id="description" rows="4"
                              class="w-full px-4 py-3 bg-gray-50 border-none rounded-xl text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all resize-none"
                              placeholder="Deskripsi produk...">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            {{-- Variants Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Varian Produk
                    </h2>
                    <button type="button" onclick="addVariant()" 
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-[#013D29] bg-[#013D29]/5 hover:bg-[#013D29]/10 rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Varian
                    </button>
                </div>

                <div id="variants-container" class="space-y-3">
                    @if($product->variants->count() > 0)
                        @foreach($product->variants as $index => $variant)
                            <div class="variant-row flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                <input type="text" name="variants[{{ $variant->id }}][size]" 
                                       class="flex-1 px-3 py-2.5 bg-white border-none rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                                       placeholder="Ukuran (S/M/L/XL)" value="{{ $variant->size }}">
                                <input type="text" name="variants[{{ $variant->id }}][color]" 
                                       class="flex-1 px-3 py-2.5 bg-white border-none rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                                       placeholder="Warna" value="{{ $variant->color }}">
                                <input type="number" name="variants[{{ $variant->id }}][stock]" 
                                       class="w-24 px-3 py-2.5 bg-white border-none rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                                       placeholder="Stok" min="0" value="{{ $variant->stock }}">
                                <button type="button" onclick="removeVariant(this)" 
                                        class="p-2 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="variant-row flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                            <input type="text" name="variants[new_0][size]" 
                                   class="flex-1 px-3 py-2.5 bg-white border-none rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                                   placeholder="Ukuran (S/M/L/XL)">
                            <input type="text" name="variants[new_0][color]" 
                                   class="flex-1 px-3 py-2.5 bg-white border-none rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                                   placeholder="Warna">
                            <input type="number" name="variants[new_0][stock]" 
                                   class="w-24 px-3 py-2.5 bg-white border-none rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                                   placeholder="Stok" min="0">
                            <button type="button" onclick="removeVariant(this)" 
                                    class="p-2 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column: Sidebar --}}
        <div class="space-y-6">
            {{-- Image Upload --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Gambar Produk
                </h2>
                <label for="image" class="block cursor-pointer">
                    <div id="image-preview" class="aspect-square bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 hover:border-[#013D29]/30 transition-colors flex flex-col items-center justify-center overflow-hidden">
                        @if($product->image)
                            <img id="preview-img" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-contain p-4">
                            <div id="placeholder" class="hidden text-center">
                                <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-xs text-gray-400 font-medium">Klik untuk upload</p>
                            </div>
                        @else
                            <div id="placeholder" class="text-center">
                                <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-xs text-gray-400 font-medium">Klik untuk upload</p>
                                <p class="text-[11px] text-gray-300 mt-0.5">PNG, JPG (max 2MB)</p>
                            </div>
                            <img id="preview-img" class="hidden w-full h-full object-contain p-4" alt="Preview">
                        @endif
                    </div>
                    <input type="file" name="image" id="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                </label>
                @error('image')
                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Status --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="text-sm font-semibold text-gray-900 flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Status
                </h2>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="peer sr-only">
                        <div class="w-10 h-6 bg-gray-200 rounded-full peer-checked:bg-[#013D29] transition-colors"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-sm peer-checked:translate-x-4 transition-transform"></div>
                    </div>
                    <span class="text-sm text-gray-700 group-hover:text-gray-900 transition-colors">Produk Aktif</span>
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit" 
                    class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-[#013D29] text-white text-sm font-semibold rounded-xl hover:bg-[#025c3e] transition-all duration-200 shadow-sm hover:shadow-md active:scale-[0.98]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Produk
            </button>
        </div>
    </div>
</form>

<script>
let variantIndex = {{ $product->variants->count() ? $product->variants->max('id') + 1 : 1 }};

function addVariant() {
    const container = document.getElementById('variants-container');
    const html = `
        <div class="variant-row flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
            <input type="text" name="variants[new_${variantIndex}][size]" 
                   class="flex-1 px-3 py-2.5 bg-white border-none rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                   placeholder="Ukuran (S/M/L/XL)">
            <input type="text" name="variants[new_${variantIndex}][color]" 
                   class="flex-1 px-3 py-2.5 bg-white border-none rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                   placeholder="Warna (Merah/Hitam)">
            <input type="number" name="variants[new_${variantIndex}][stock]" 
                   class="w-24 px-3 py-2.5 bg-white border-none rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013D29]/20 transition-all"
                   placeholder="Stok" min="0">
            <button type="button" onclick="removeVariant(this)" 
                    class="p-2 rounded-lg text-gray-300 hover:text-red-500 hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    variantIndex++;
}

function removeVariant(btn) {
    const container = document.getElementById('variants-container');
    if (container.children.length > 1) {
        btn.closest('.variant-row').remove();
    }
}

function previewImage(input) {
    const preview = document.getElementById('preview-img');
    const placeholder = document.getElementById('placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
