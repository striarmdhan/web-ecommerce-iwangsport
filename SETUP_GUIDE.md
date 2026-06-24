# XYZ Sport E-Commerce - Setup & Installation Guide

## ✅ Project Status: SELESAI (Backend & Views Complete)

Sistem e-commerce XYZ Sport telah berhasil dibuat sesuai dengan spesifikasi di `SPEC_ECOMMERCE_XYZ.md`.

---

## 📋 Yang Sudah Dibuat

### Backend (PHP/Laravel)
- ✅ **Enums**: OrderStatus, PaymentMethod, PaymentStatus, UserRole
- ✅ **Models** (12 models): User, Product, Category, ProductVariant, ProductImage, Cart, CartItem, Order, OrderItem, Payment, Address, StoreSetting
- ✅ **Controllers**:
  - Auth: AuthController (login, register, logout)
  - Customer: ProductController, CartController, CheckoutController, OrderController
  - Admin: DashboardController, OrderController, ProductController, CategoryController, UserController
- ✅ **Middleware**: IsAdmin (untuk proteksi admin routes)
- ✅ **Policies**: OrderPolicy (authorization untuk orders)
- ✅ **Routes**: web.php (customer routes), admin.php (admin routes)
- ✅ **Migrations**: 12 migration files untuk semua tabel
- ✅ **Seeders**: DatabaseSeeder dengan sample data

### Frontend (Blade + Tailwind CSS)
- ✅ **Layouts**: app.blade.php (customer), guest.blade.php (auth), admin.blade.php (admin)
- ✅ **Components/Partials**: navbar, footer, sidebar admin, header admin
- ✅ **Views Customer**:
  - welcome.blade.php (home page dengan produk terbaru)
  - auth/login.blade.php & register.blade.php
  - customer/products/index.blade.php (daftar produk dengan filter & search)
  - customer/products/show.blade.php (detail produk dengan varian)
  - customer/cart/index.blade.php (keranjang belanja)
  - customer/checkout/index.blade.php (checkout dengan pilih alamat & payment)
  - customer/orders/index.blade.php (daftar pesanan)
  - customer/orders/show.blade.php (detail pesanan + upload bukti bayar)
- ✅ **Views Admin**:
  - admin/dashboard/index.blade.php (dashboard dengan statistik)
  - admin/orders/index.blade.php & show.blade.php (manajemen pesanan)
  - admin/products/index.blade.php, create.blade.php, edit.blade.php (CRUD produk)
  - admin/categories/index.blade.php (manajemen kategori)
  - admin/users/index.blade.php (daftar pelanggan)
- ✅ **CSS**: Tailwind CSS v4 dengan brand colors (teal) dan custom components
- ✅ **JavaScript**: Alpine.js untuk interaktivitas (dropdown, dll)

### Database
- ✅ **Migrations dijalankan**: Semua 15 tabel berhasil dibuat
- ✅ **Seeder dijalankan**: 
  - 2 users (admin & customer demo)
  - 4 kategori produk
  - 4 produk dengan varian (S, M, L, XL)
  - Store settings
- ✅ **Storage link**: Sudah dibuat untuk file uploads

---

## 🚀 Cara Menjalankan Aplikasi

### 1. Install Dependencies (jika belum)
```bash
composer install
npm install
```

### 2. Build Frontend Assets
```bash
npm run build
```

Atau untuk development dengan hot reload:
```bash
npm run dev
```

### 3. Jalankan Server
```bash
php artisan serve
```

Aplikasi akan berjalan di: http://localhost:8000

---

## 🔐 Akun Login

### Admin
- **Email**: admin@xyzsport.com
- **Password**: password

### Customer (Demo)
- **Email**: customer@xyzsport.com
- **Password**: password

---

## 📦 Fitur yang Tersedia

### Customer
1. **Autentikasi**: Register, login, logout
2. **Katalog Produk**: 
   - Browse semua produk dengan grid view
   - Filter berdasarkan kategori, harga
   - Search produk
   - Sorting (terbaru, termurah, termahal)
3. **Detail Produk**:
   - Lihat deskripsi & galeri
   - Pilih varian (ukuran, warna)
   - Lihat stok
4. **Keranjang Belanja**:
   - Tambah produk ke keranjang
   - Update jumlah
   - Hapus item
   - Lihat subtotal
5. **Checkout**:
   - Pilih alamat pengiriman
   - Pilih metode pembayaran (QRIS/Transfer)
   - Tambah catatan
   - Buat pesanan
6. **Pesanan**:
   - Lihat daftar pesanan dengan status
   - Lihat detail pesanan
   - Upload bukti pembayaran
   - Track status pesanan

### Admin
1. **Dashboard**:
   - Statistik (total pesanan, pending, produk, pelanggan, revenue)
   - Daftar pesanan terbaru
2. **Manajemen Pesanan**:
   - Lihat semua pesanan dengan filter status
   - Verifikasi pembayaran (approve/reject)
   - Update ongkir
   - Update status pengiriman (kirim + input resi)
   - Tandai selesai
3. **Manajemen Produk**:
   - CRUD produk
   - Upload gambar produk
   - Kelola varian (ukuran, warna, stok)
   - Aktifkan/nonaktifkan produk
4. **Manajemen Kategori**:
   - Tambah/edit/hapus kategori
5. **Manajemen Pelanggan**:
   - Lihat daftar pelanggan
   - Lihat jumlah pesanan per pelanggan

---

## 🎨 Design System

### Warna Brand (Teal)
- Primary: `#0f766e` (brand-700)
- Hover: `#115e59` (brand-800)
- Light: `#f0fdfa` (brand-50)

### Typography
- Font: Inter (Google Fonts)
- Heading: Bold, 2xl-5xl
- Body: Regular, sm-base

### Components
- **Buttons**: btn-primary, btn-secondary, btn-danger
- **Inputs**: input-field (dengan focus ring)
- **Cards**: card (rounded-xl, shadow-sm)
- **Badges**: Status badges dengan warna berbeda

### Layout
- Responsive: Mobile-first
- Grid: 2 cols (mobile), 3-4 cols (desktop)
- Spacing: Konsisten dengan Tailwind scale

---

## 📂 Struktur Folder

```
app/
├── Enums/              # OrderStatus, PaymentMethod, dll
├── Http/
│   ├── Controllers/
│   │   ├── Admin/      # DashboardController, OrderController, dll
│   │   ├── Auth/       # AuthController
│   │   └── Customer/   # ProductController, CartController, dll
│   └── Middleware/     # IsAdmin
├── Models/             # User, Product, Order, dll
└── Policies/           # OrderPolicy

resources/
├── css/app.css         # Tailwind + custom components
├── js/app.js           # Alpine.js
└── views/
    ├── layouts/        # app, guest, admin
    ├── auth/           # login, register
    ├── customer/       # products, cart, checkout, orders
    └── admin/          # dashboard, products, orders, categories, users

database/
├── migrations/         # 12 migration files
└── seeders/            # DatabaseSeeder

routes/
├── web.php             # Customer routes
└── admin.php           # Admin routes
```

---

## 🔧 Konfigurasi

### Database
- **Connection**: MySQL
- **Database**: ecommerce_xyz
- **Host**: 127.0.0.1
- **Port**: 3306
- **Username**: root

### Payment Methods
- QRIS (manual verification)
- Transfer Bank (manual verification)

### Shipping
- Manual input oleh admin
- Admin dapat update ongkir dan input nomor resi

---

## 📝 Catatan Penting

1. **Tidak ada API eksternal**: Semua proses manual (payment, shipping)
2. **Upload gambar**: Pastikan folder `storage/app/public` writable
3. **Security**: Ganti password default setelah login pertama
4. **Production**: Set `APP_DEBUG=false` dan generate app key baru

---

## 🐛 Troubleshooting

### Error: Vite manifest not found
```bash
npm run build
```

### Error: Storage link tidak ada
```bash
php artisan storage:link
```

### Error: Database tidak ada
```bash
php artisan migrate
php artisan db:seed
```

### Permission denied saat upload
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

---

## 📊 Sample Data yang Sudah Ada

- **2 Users**: 1 Admin, 1 Customer
- **4 Categories**: Celana Training, Jogger, Pendek, Panjang
- **4 Products**: Masing-masing dengan 4 varian ukuran (S, M, L, XL)
- **16 Product Variants**: 4 produk × 4 ukuran, stok 10 per varian
- **Store Settings**: Info toko dengan rekening BCA

---

## ✅ Checklist Spesifikasi

Dari `SPEC_ECOMMERCE_XYZ.md`:

### MVP Features
- [x] Auth customer (register/login)
- [x] Katalog + detail + varian + kategori + pencarian
- [x] Keranjang
- [x] Checkout + pembayaran manual (QRIS/transfer + upload bukti)
- [x] Verifikasi pembayaran oleh admin
- [x] Manajemen pesanan & status (kirim manual)
- [x] Admin CRUD produk + stok

### Design
- [x] Modern, simple, minimalis
- [x] Mobile-first & responsif
- [x] Tailwind CSS dengan brand colors
- [x] Komponen reusable (buttons, cards, inputs)

### Struktur
- [x] Folder terorganisir sesuai konvensi Laravel
- [x] Separation of concerns (Controllers, Models, Views)
- [x] Enums untuk status
- [x] Policies untuk authorization

---

## 🎯 Next Steps (Optional Enhancements)

Fitur yang bisa ditambahkan di masa depan:
- [ ] Review & rating produk
- [ ] Wishlist
- [ ] Kupon/diskon
- [ ] Laporan penjualan lanjutan
- [ ] Notifikasi email otomatis
- [ ] Export data ke Excel/PDF
- [ ] Multi-bahasa
- [ ] Dark mode

---

## 📞 Support

Jika ada pertanyaan atau issue, silakan cek:
- Laravel Documentation: https://laravel.com/docs
- Tailwind CSS: https://tailwindcss.com/docs
- Alpine.js: https://alpinejs.dev

---

**Status**: ✅ Siap digunakan setelah `npm run build` dijalankan!

**Last Updated**: 2026-06-22
