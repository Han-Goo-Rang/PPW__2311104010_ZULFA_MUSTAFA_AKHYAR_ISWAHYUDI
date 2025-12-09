# Analisis Project Web CRUD - Unwritten (Lightfantasy Outfit)

## 📋 Ringkasan Project

Project ini adalah aplikasi web e-commerce fashion **Unwritten** yang dibangun dengan stack **PHP, HTML, CSS, dan JavaScript** (Vanilla + jQuery). Ini adalah fullstack CRUD application dengan fitur admin dashboard untuk mengelola produk.

---

## 🏗️ Struktur Project

```
root/
├── index.html                 # Halaman utama (listing produk)
├── detail.html                # Halaman detail produk
├── admin/
│   ├── login.html            # Halaman login admin
│   ├── dashboard.html        # Dashboard admin (CRUD produk)
│   └── .htaccess             # Proteksi folder admin
├── api/
│   ├── config.php            # Konfigurasi database & session
│   ├── auth.php              # API autentikasi (login/logout)
│   ├── products.php          # API CRUD produk
│   ├── validators.php        # Validasi input
│   └── .htaccess             # Proteksi folder API
├── assets/
│   ├── app.css               # Styling utama
│   ├── script.js             # JavaScript frontend
│   ├── api-client.js         # Client untuk API calls
│   └── img/                  # Folder gambar produk
└── .kiro/                    # Konfigurasi Kiro IDE
```

---

## 🔄 Alur Kerja Aplikasi

### **1. FRONTEND - Halaman Publik (index.html & detail.html)**

#### **index.html** - Halaman Listing Produk

- **Fitur:**

  - Carousel banner otomatis
  - Grid produk dengan 9 item
  - Search/filter produk real-time
  - Sidebar rekomendasi produk
  - Tombol "Tambah ke Keranjang" (UI only, belum backend)
  - Back-to-top button

- **Flow:**
  1. Page load → `script.js` dijalankan
  2. `loadProductsFromAPI()` dipanggil
  3. `fetchAllProducts()` dari `api-client.js` → GET `/api/products.php`
  4. Data produk ditampilkan di grid
  5. User bisa search/filter produk
  6. Klik produk → redirect ke `detail.html?id=X`

#### **detail.html** - Halaman Detail Produk

- **Fitur:**

  - Carousel gambar produk
  - Info produk (nama, harga, deskripsi, spesifikasi)
  - Tombol "Tambah ke Keranjang"
  - Rekomendasi produk lainnya (3 random)

- **Flow:**
  1. Page load dengan query param `?id=X`
  2. `loadDetailPageFromAPI()` dipanggil
  3. `fetchProductById(id)` → GET `/api/products.php?id=X`
  4. Data produk ditampilkan
  5. Carousel gambar diisi dari array `images`
  6. Rekomendasi diambil dari produk lain (random)

---

### **2. BACKEND - API (api/)**

#### **config.php** - Konfigurasi Database

```php
Database: unwritten_db
Host: localhost
User: root
Password: (kosong)
```

- Membuat koneksi MySQL
- Set charset UTF-8
- Start session
- Set CORS headers
- Handle preflight requests

#### **auth.php** - Autentikasi Admin

**Endpoints:**

- `POST /api/auth.php?action=login` - Login admin
- `POST /api/auth.php?action=logout` - Logout admin
- `GET /api/auth.php?action=check` - Cek status login

**Flow Login:**

1. User input username & password di `admin/login.html`
2. Form submit → `handleLogin()` di `admin/dashboard.html`
3. AJAX POST ke `/api/auth.php?action=login`
4. Backend cek database tabel `users`
5. Verify password dengan `password_verify()`
6. Jika valid → set `$_SESSION` → redirect ke dashboard
7. Jika invalid → tampilkan error

**Session Management:**

- Session disimpan di server (PHP default)
- Middleware `requireAuth()` melindungi endpoint CRUD

#### **products.php** - CRUD Produk

**Endpoints:**

- `GET /api/products.php` - Ambil semua produk
- `GET /api/products.php?id=X` - Ambil produk spesifik
- `POST /api/products.php` - Buat produk baru (auth required)
- `PUT /api/products.php` - Update produk (auth required)
- `DELETE /api/products.php?id=X` - Hapus produk (auth required)

**Database Schema (assumed):**

```sql
CREATE TABLE products (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  price VARCHAR(50) NOT NULL,
  description TEXT NOT NULL,
  images JSON,
  material VARCHAR(255),
  accessories VARCHAR(255),
  colors VARCHAR(255),
  sizes VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);
```

#### **validators.php** - Validasi Input

- `validateProductName()` - Max 255 char
- `validateProductPrice()` - Format Rp atau angka
- `validateProductDescription()` - Min 10 char
- `validateProductImages()` - Array, format file valid
- `validateProductData()` - Validasi semua field
- `validateRequiredFields()` - Cek field wajib

---

### **3. ADMIN DASHBOARD (admin/)**

#### **login.html** - Halaman Login

- Form login dengan username & password
- Demo credentials: `admin` / `admin123`
- Validasi client-side
- Error handling
- Auto-redirect ke dashboard jika sudah login

#### **dashboard.html** - Admin Panel

**Fitur:**

- Tabel produk dengan pagination (10 item/halaman)
- Tombol "Tambah Produk" → Modal form
- Edit produk → Modal form pre-filled
- Hapus produk → Konfirmasi modal
- Logout button
- Success/error alerts

**Flow CRUD:**

**CREATE (Tambah Produk):**

1. Klik "Tambah Produk" → Modal kosong
2. Isi form (name, price, description, dll)
3. Klik "Simpan" → `saveProduct()`
4. AJAX POST ke `/api/products.php`
5. Backend validasi → insert ke DB
6. Reload tabel produk

**READ (Lihat Produk):**

1. Page load → `loadProducts()`
2. AJAX GET `/api/products.php`
3. Tampilkan di tabel dengan pagination

**UPDATE (Edit Produk):**

1. Klik "Edit" → Modal pre-filled dengan data
2. Ubah field yang diperlukan
3. Klik "Simpan" → `saveProduct()`
4. AJAX PUT ke `/api/products.php`
5. Backend validasi → update DB
6. Reload tabel

**DELETE (Hapus Produk):**

1. Klik "Hapus" → Modal konfirmasi
2. Klik "Hapus" di modal
3. AJAX DELETE `/api/products.php?id=X`
4. Backend hapus dari DB
5. Reload tabel

---

## 🚀 Urutan Menjalankan Program

### **Prerequisite:**

1. **Laragon** sudah terinstall
2. **PHP 7.4+** dan **MySQL** aktif di Laragon
3. Database `unwritten_db` sudah dibuat
4. Tabel `products` dan `users` sudah dibuat
5. User admin sudah ada di tabel `users` (password di-hash dengan `password_hash()`)

### **Step-by-Step:**

#### **1. Setup Database**

```sql
-- Buat database
CREATE DATABASE unwritten_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE unwritten_db;

-- Buat tabel products
CREATE TABLE products (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  price VARCHAR(50) NOT NULL,
  description TEXT NOT NULL,
  images JSON,
  material VARCHAR(255),
  accessories VARCHAR(255),
  colors VARCHAR(255),
  sizes VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Buat tabel users
CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL
);

-- Insert user admin (password: admin123)
INSERT INTO users (username, password) VALUES
('admin', '$2y$10$YIjlrBxvxK8.8.8.8.8.8.8.8.8.8.8.8.8.8.8.8.8.8.8.8.8.8.8');

-- Insert sample products
INSERT INTO products (name, price, description, images, material, accessories, colors, sizes) VALUES
('Heavenly Zoran - Shadow', 'Rp 740.000', 'Koleksi eksklusif dengan desain elegan', '["Art1.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL'),
('Heavenly Zoran - Shaolin', 'Rp 710.100', 'Gaya tradisional dengan sentuhan modern', '["Art2.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL'),
-- ... tambah produk lainnya
```

#### **2. Setup Project di Laragon**

```bash
# Copy project ke folder htdocs Laragon
# Biasanya: C:\laragon\www\unwritten

# Atau jika menggunakan virtual host:
# Copy ke: C:\laragon\www\unwritten
# Edit C:\laragon\etc\apache2\sites-enabled\unwritten.conf
```

#### **3. Jalankan Laragon**

- Buka Laragon
- Klik "Start All" atau start Apache & MySQL
- Pastikan Apache dan MySQL berstatus "Running" (hijau)

#### **4. Akses Aplikasi**

**Halaman Publik (Listing Produk):**

```
http://localhost/unwritten/
atau
http://unwritten.local/ (jika pakai virtual host)
```

- Lihat daftar produk
- Search produk
- Klik produk untuk lihat detail

**Halaman Detail Produk:**

```
http://localhost/unwritten/detail.html?id=1
```

- Lihat detail produk dengan carousel gambar
- Lihat rekomendasi produk

**Admin Dashboard:**

```
http://localhost/unwritten/admin/login.html
```

- Login dengan: `admin` / `admin123`
- Kelola produk (tambah, edit, hapus)
- Lihat tabel produk dengan pagination

---

## 📊 Data Flow Diagram

```
┌─────────────────────────────────────────────────────────────┐
│                    FRONTEND (Public)                         │
├─────────────────────────────────────────────────────────────┤
│  index.html (Listing)  ←→  detail.html (Detail)             │
│         ↓                          ↓                         │
│  script.js + api-client.js (AJAX calls)                     │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    BACKEND (API)                             │
├─────────────────────────────────────────────────────────────┤
│  config.php (DB Connection)                                 │
│         ↓                                                    │
│  auth.php (Login/Logout)  ←→  products.php (CRUD)           │
│         ↓                          ↓                         │
│  validators.php (Input Validation)                          │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    DATABASE (MySQL)                          │
├─────────────────────────────────────────────────────────────┤
│  unwritten_db                                               │
│  ├── products (id, name, price, description, images, ...)  │
│  └── users (id, username, password)                        │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔐 Security Notes

1. **Authentication:** Session-based, password di-hash dengan `password_hash()`
2. **Authorization:** Middleware `requireAuth()` melindungi endpoint CRUD
3. **Input Validation:** Semua input divalidasi di backend
4. **SQL Injection Prevention:** Menggunakan prepared statements
5. **CORS:** Headers CORS diset untuk allow cross-origin requests
6. **.htaccess:** Melindungi folder `admin/` dan `api/`

---

## 🎨 Frontend Stack

- **HTML5** - Struktur
- **CSS3** - Styling (Bootstrap 5.3.3 + custom CSS)
- **JavaScript** - Interaktivitas (Vanilla JS + jQuery 3.7.1)
- **Bootstrap 5.3.3** - UI Framework
- **Font Awesome 6.4.0** - Icons (di admin dashboard)

---

## 🔧 Backend Stack

- **PHP 7.4+** - Server-side logic
- **MySQL** - Database
- **Apache** - Web server (via Laragon)

---

## 📝 Fitur yang Sudah Ada

✅ Listing produk dengan search/filter
✅ Detail produk dengan carousel
✅ Admin login/logout
✅ CRUD produk (Create, Read, Update, Delete)
✅ Pagination di admin dashboard
✅ Input validation
✅ Error handling
✅ Responsive design

---

## 🚧 Fitur yang Belum Ada (Optional)

- ❌ Shopping cart (backend)
- ❌ Checkout & payment
- ❌ User registration
- ❌ Order management
- ❌ Product reviews/ratings
- ❌ Image upload (currently hardcoded filenames)
- ❌ Email notifications
- ❌ Analytics/reporting

---

## 🐛 Troubleshooting

**Problem:** Database connection failed

- **Solution:** Pastikan MySQL running, database `unwritten_db` ada, credentials di `config.php` benar

**Problem:** Login gagal

- **Solution:** Pastikan user `admin` ada di tabel `users`, password di-hash dengan `password_hash()`

**Problem:** Produk tidak muncul

- **Solution:** Pastikan tabel `products` ada dan ada data di dalamnya

**Problem:** Gambar tidak muncul

- **Solution:** Pastikan file gambar ada di `assets/img/`, nama file sesuai dengan data di database

---

## 📞 Kontak & Info

- **Project:** Unwritten - Lightfantasy Outfit
- **Author:** Zulfa MAI-2311104010
- **Year:** 2025
- **Stack:** PHP + HTML + CSS + JavaScript (Vanilla + jQuery)
- **Database:** MySQL
- **Server:** Apache (Laragon)
