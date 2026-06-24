<footer class="bg-gray-50 border-t border-gray-100 mt-16">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-10 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-lg font-bold" style="color: #013D29;">Iwangsport</h3>
                <p class="text-gray-500 text-sm mt-3 leading-relaxed">
                    Konveksi celana sport berkualitas tinggi dengan desain modern dan harga terjangkau.
                </p>
            </div>
            
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Navigasi</h3>
                <ul class="space-y-2.5 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-500 hover:text-[#013D29] transition-colors">Home</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-500 hover:text-[#013D29] transition-colors">Produk</a></li>
                </ul>
            </div>
            
            <div>
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Kontak</h3>
                <ul class="space-y-2.5 text-sm text-gray-500">
                    <li>Email: iwang@gmail.com</li>
                    <li>Phone: 08123456789</li>
                </ul>
            </div>
        </div>
        
        <div class="mt-10 pt-8 border-t border-gray-200 text-center text-xs text-gray-400">
            <p>&copy; {{ date('Y') }} Iwangsport. All rights reserved.</p>
        </div>
    </div>
</footer>
