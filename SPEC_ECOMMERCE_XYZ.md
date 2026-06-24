# Spesifikasi Sistem E-Commerce "XYZ" (Konveksi Celana Sport)

> Dokumen ini adalah **blueprint / project spec** untuk membangun website e-commerce.
> Gunakan dokumen ini sebagai acuan utama saat mengembangkan sistem bersama AI coding agent.
> Studi kasus: **XYZ**, sebuah usaha konveksi (produsen) **celana sport**. (Nama asli disamarkan menjadi "XYZ".)

---

## 1. Ringkasan Proyek

| Item | Keterangan |
|------|------------|
| Nama Sistem | Website E-Commerce XYZ |
| Studi Kasus | Usaha konveksi celana sport "XYZ" |
| Jenis | B2C (Business to Customer) |
| Tujuan | Memperluas jangkauan pasar & memudahkan transaksi penjualan online |
| Framework Backend | **Laravel** |
| Styling Frontend | **Tailwind CSS** |
| Database | MySQL / MariaDB |
| Integrasi API Eksternal | **TIDAK ADA** (semua proses internal/manual) |

### Prinsip Penting
- **Tanpa API eksternal**: tidak ada payment gateway, tidak ada API ongkir. Semua manual.
- **Pembayaran**: QRIS / Transfer Bank. Sistem **hanya menampilkan nomor rekening / gambar QRIS statis**. Pelanggan **upload bukti pembayaran manual**, lalu **di-ACC (verifikasi) oleh admin**.
- **Pengiriman**: diatur **manual** oleh admin (input ongkir manual, update resi/status manual).

---

## 2. Aktor & Role

| Role | Deskripsi |
|------|-----------|
| **Customer** | Pengunjung yang mendaftar, melihat produk, memesan, membayar, dan melacak pesanan. |
| **Admin** | Pengelola toko: kelola produk, verifikasi pembayaran, kelola & kirim pesanan. |

---

## 3. Fitur Role Customer

### 3.1 Autentikasi & Akun
- [ ] Registrasi akun (nama, email, password, no. HP)
- [ ] Login & logout
- [ ] Lupa password / reset password
- [ ] Halaman profil (edit data diri)
- [ ] Manajemen alamat pengiriman (tambah/edit/hapus alamat)
- [ ] Riwayat pesanan

### 3.2 Katalog Produk
- [ ] Halaman utama (produk unggulan / terbaru)
- [ ] Daftar produk (grid) dengan gambar, nama, harga
- [ ] Halaman detail produk (galeri gambar, deskripsi, harga, stok)
- [ ] **Varian produk** (ukuran: S/M/L/XL, warna) — relevan untuk celana sport
- [ ] Kategori produk
- [ ] Pencarian produk (search bar)
- [ ] Filter (kategori, rentang harga) & sorting (terbaru, termurah, termahal)

### 3.3 Keranjang & Checkout
- [ ] Tambah ke keranjang (pilih varian & kuantitas)
- [ ] Lihat keranjang (ubah kuantitas, hapus item)
- [ ] Kalkulasi subtotal otomatis
- [ ] Checkout: pilih alamat, lihat ringkasan pesanan
- [ ] Ongkir diisi/ditentukan manual (flat atau ditentukan admin)

### 3.4 Pembayaran (Manual)
- [ ] Pilih metode: **QRIS** atau **Transfer Bank**
- [ ] Sistem menampilkan **nomor rekening** dan/atau **gambar QRIS statis**
- [ ] Pelanggan **upload bukti pembayaran** (gambar/PDF)
- [ ] Status pembayaran: `Menunggu Pembayaran` -> `Menunggu Verifikasi` -> `Diverifikasi / Ditolak`

### 3.5 Pesanan
- [ ] Nomor invoice / kode pesanan
- [ ] Tracking status pesanan (lihat detail di bawah)
- [ ] Notifikasi sederhana (in-app / email opsional, tanpa API berbayar)

---

## 4. Fitur Role Admin

### 4.1 Dashboard
- [ ] Ringkasan: total pesanan, pesanan menunggu verifikasi, total produk, pendapatan
- [ ] Grafik penjualan sederhana (opsional, tanpa library berat)

### 4.2 Manajemen Produk
- [ ] CRUD produk (nama, deskripsi, harga, gambar, stok)
- [ ] CRUD kategori
- [ ] Kelola varian (ukuran, warna) & stok per varian
- [ ] Upload banyak gambar per produk

### 4.3 Manajemen Pesanan
- [ ] Lihat daftar pesanan + filter berdasarkan status
- [ ] Lihat detail pesanan & **bukti pembayaran** yang diupload pelanggan
- [ ] **Verifikasi pembayaran** (ACC / Tolak)
- [ ] Update status pengiriman (manual) + input resi/keterangan
- [ ] Atur/ubah ongkir manual

### 4.4 Manajemen Inventori
- [ ] Stok berkurang otomatis saat pesanan diverifikasi
- [ ] Peringatan stok menipis (opsional)

### 4.5 Manajemen User
- [ ] Lihat daftar pelanggan
- [ ] Role & permission (Admin vs Customer)

### 4.6 Pengaturan Toko
- [ ] Kelola nomor rekening & gambar QRIS
- [ ] Kelola informasi toko (nama, kontak, alamat)

---

## 5. Alur Status Pesanan (State Flow)

```
[Pesanan Dibuat]
      |
      v
[Menunggu Pembayaran] --(customer upload bukti)--> [Menunggu Verifikasi]
      |                                                     |
      |                                          (admin verifikasi)
      |                                          /                  \
      |                                  [Ditolak]            [Diproses/Dibayar]
      |                                  (ulangi bayar)              |
      |                                                  (admin kirim manual)
      |                                                             v
      |                                                       [Dikirim]
      |                                                             |
      |                                                  (customer terima)
      |                                                             v
      v                                                       [Selesai]
[Dibatalkan] (jika tidak bayar dalam batas waktu)
```

---

## 6. Ringkasan Desain (Modern, Simple, Minimalis)

Tujuan tampilan: **bersih, modern, fokus pada produk, banyak ruang kosong (whitespace).**

### 6.1 Prinsip Visual
- **Minimalis**: hindari elemen berlebihan; utamakan whitespace dan hierarki yang jelas.
- **Konsisten**: gunakan satu set komponen yang dipakai berulang (button, card, input).
- **Mobile-first & responsif**: desain dari layar kecil ke besar.
- **Fokus produk**: gambar produk besar & berkualitas, teks pendukung secukupnya.

### 6.2 Palet Warna (saran)
| Peran | Warna | Contoh |
|-------|-------|--------|
| Primary (aksen) | Satu warna kuat & sporty | `#1E293B` (slate gelap) atau `#0F766E` (teal) |
| Background | Putih / abu sangat terang | `#FFFFFF`, `#F8FAFC` |
| Teks utama | Abu gelap (bukan hitam pekat) | `#0F172A` |
| Teks sekunder | Abu sedang | `#64748B` |
| Border / garis | Abu terang | `#E2E8F0` |
| Sukses / Error | Hijau / Merah lembut | `#16A34A` / `#DC2626` |

> Gunakan **maksimal 1 warna aksen** + netral (putih/abu). Ini kunci kesan minimalis.

### 6.3 Tipografi
- Gunakan **1 font sans-serif modern** (mis. *Inter*, *Plus Jakarta Sans*, atau *Poppins*).
- Hierarki ukuran jelas: judul besar & tebal, body 14-16px, abu untuk teks sekunder.
- Hindari terlalu banyak variasi ukuran/berat font.

### 6.4 Komponen & Layout
- **Sudut membulat** (`rounded-lg` / `rounded-xl`) untuk card, button, input.
- **Bayangan halus** (`shadow-sm`) — jangan berlebihan.
- **Grid produk**: 2 kolom (mobile) -> 3-4 kolom (desktop), jarak antar-card konsisten.
- **Button**: solid untuk aksi utama, outline/ghost untuk aksi sekunder.
- **Spacing konsisten**: gunakan skala Tailwind (4, 6, 8, 12, 16...).
- **Navbar** simpel: logo kiri, search tengah, keranjang & akun kanan.
- **Transisi halus** pada hover (`transition`), efek minimal.

### 6.5 Tailwind Guidelines
- Definisikan warna brand di `tailwind.config.js` (jangan hardcode hex di mana-mana).
- Gunakan utility class, hindari custom CSS berlebihan.
- Manfaatkan komponen Blade reusable (mis. `<x-button>`, `<x-product-card>`).

---

## 7. Aturan Struktur Folder (WAJIB DIPATUHI)

> **PERINTAH UNTUK AI AGENT:** Selalu jaga struktur folder tetap **rapih, konsisten, dan terorganisir**. Jangan menaruh file sembarangan. Ikuti konvensi Laravel dan kelompokkan file sesuai fungsinya.

### Aturan Umum
1. **SELALU** tempatkan file pada folder yang sesuai fungsinya (jangan campur aduk).
2. **SELALU** ikuti konvensi penamaan Laravel:
   - Controller: `PascalCase` + akhiran `Controller` (mis. `ProductController`).
   - Model: `PascalCase` tunggal (mis. `Product`, `Order`).
   - Tabel migrasi: `snake_case` jamak (mis. `products`, `order_items`).
   - Blade view: `kebab-case` atau `snake_case` konsisten.
3. **Pisahkan** logika ke tempat yang tepat: gunakan **Service / Action class** untuk logika bisnis kompleks, jangan menumpuk semua di Controller.
4. **Kelompokkan** view berdasarkan domain (mis. `views/admin/...`, `views/customer/...`).
5. **Gunakan Form Request** untuk validasi (jangan validasi panjang di controller).
6. **Komponen Blade reusable** ditaruh di `resources/views/components/`.
7. **Jangan** membuat file duplikat / file sampah. Hapus file yang tidak terpakai.
8. Setiap menambah fitur baru, **periksa dulu** apakah sudah ada folder/komponen yang sesuai sebelum membuat baru.

### Struktur Folder yang Disarankan

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Controller area admin
│   │   ├── Customer/       # Controller area customer
│   │   └── Auth/           # Controller autentikasi
│   ├── Requests/           # Form Request (validasi)
│   └── Middleware/
├── Models/                 # Eloquent Models
├── Services/               # Logika bisnis (mis. OrderService, CartService)
└── Enums/                  # Enum status (mis. OrderStatus)

resources/
├── views/
│   ├── components/         # Komponen Blade reusable (button, card, dll)
│   ├── layouts/            # Layout utama (app, admin, guest)
│   ├── customer/           # Halaman sisi customer
│   │   ├── products/
│   │   ├── cart/
│   │   ├── checkout/
│   │   └── orders/
│   └── admin/              # Halaman sisi admin
│       ├── dashboard/
│       ├── products/
│       └── orders/
├── css/
└── js/

database/
├── migrations/
├── seeders/
└── factories/

routes/
├── web.php
└── admin.php              # (opsional) pisahkan route admin

public/
└── storage/               # Symlink untuk file upload (gambar produk, bukti bayar)
```

---

## 8. Skema Database (Garis Besar)

| Tabel | Kolom Utama |
|-------|-------------|
| `users` | id, name, email, password, phone, role |
| `addresses` | id, user_id, label, recipient, phone, full_address |
| `categories` | id, name, slug |
| `products` | id, category_id, name, slug, description, price, image, is_active |
| `product_variants` | id, product_id, size, color, stock |
| `product_images` | id, product_id, path |
| `carts` | id, user_id |
| `cart_items` | id, cart_id, product_variant_id, quantity |
| `orders` | id, user_id, invoice_number, status, subtotal, shipping_cost, total, payment_method, shipping_note, tracking_number |
| `order_items` | id, order_id, product_variant_id, product_name, price, quantity |
| `payments` | id, order_id, method (qris/transfer), proof_path, status, verified_at, verified_by |
| `store_settings` | id, bank_name, account_number, account_holder, qris_image, store_name, contact |

---

## 9. Ruang Lingkup MVP (Prioritas)

**Harus ada (MVP):**
1. Auth customer (register/login)
2. Katalog + detail + varian + kategori + pencarian
3. Keranjang
4. Checkout + pembayaran manual (QRIS/transfer + upload bukti)
5. Verifikasi pembayaran oleh admin
6. Manajemen pesanan & status (kirim manual)
7. Admin CRUD produk + stok

**Pengembangan lanjutan (opsional / future work):**
- Review & rating produk
- Wishlist
- Kupon/diskon
- Laporan penjualan lanjutan
- Notifikasi email otomatis

---

## 10. Catatan untuk AI Agent

- Bangun secara **bertahap & modular** sesuai prioritas MVP di atas.
- **Patuhi aturan struktur folder** di Bagian 7 setiap saat.
- Gunakan **Laravel + Tailwind CSS** saja; **jangan** menambahkan integrasi API eksternal.
- Jaga desain tetap **modern, simple, minimalis** sesuai Bagian 6.
- Tulis kode bersih, beri komentar seperlunya, dan gunakan konvensi Laravel.
- Setiap selesai satu modul, pastikan **struktur folder tetap rapih** dan tidak ada file menggantung.
