# Dokumentasi Implementasi Project Unwritten

## 📋 Daftar Isi

1. [Ringkasan Eksekutif](#ringkasan-eksekutif)
2. [Arsitektur Sistem](#arsitektur-sistem)
3. [Fitur Utama](#fitur-utama)
4. [Panduan Instalasi](#panduan-instalasi)
5. [Panduan Penggunaan](#panduan-penggunaan)
6. [Dokumentasi Teknis](#dokumentasi-teknis)
7. [Troubleshooting](#troubleshooting)

---

## 🎯 Ringkasan Eksekutif

### Untuk Stakeholder

**Unwritten** adalah aplikasi web e-commerce untuk penjualan fashion Lightfantasy Outfit dengan fitur:

- **Frontend Publik:** Katalog produk, detail produk, rekomendasi produk
- **Admin Dashboard:** Manajemen produk (tambah, edit, hapus), upload gambar
- **Sistem Autentikasi:** Login dengan database, session management
- **Responsive Design:** Kompatibel dengan desktop dan mobile

**Status:** MVP (Minimum Viable Product) - Fitur core sudah berfungsi, edit produk masih dalam pengembangan

**Teknologi Stack:**

- Frontend: HTML5, CSS3, JavaScript (jQuery), Bootstrap 5
- Backend: PHP 7.4+, MySQL 5.7+
- Server: Apache (Laragon)

---

## 🏗️ Arsitektur Sistem

### Struktur Folder

```
10_PHP_MYSQL/
├── index.html                 # Halaman utama (katalog produk)
├── detail.html                # Halaman detail produk
├── admin/
│   ├── login.html            # Halaman login admin
│   ├── dashboard.html        # Dashboard admin (CRUD produk)
├── api/
│   ├── auth.php              # API autentikasi (login/logout/check)
│   ├── products.php          # API CRUD produk
│   ├── upload.php            # API upload gambar
│   ├── config.php            # Konfigurasi database & session
│   ├── validators.php        # Validasi input
├── assets/
│   ├── app.css               # Stylesheet utama
│   ├── script.js             # JavaScript utama
│   ├── api-client.js         # API client (fetch wrapper)
│   ├── img/                  # Folder gambar produk
├── database-setup.php        # Script setup database
└── DOKUMENTASI.md            # File ini
```

### Alur Data

```
Frontend (HTML/JS)
    ↓
AJAX Request
    ↓
API (PHP)
    ↓
Database (MySQL)
    ↓
Response JSON
    ↓
Frontend Update DOM
```

---

## ✨ Fitur Utama

### 1. Halaman Publik (index.html)

**Fitur:**

- Carousel banner dengan 3 slide
- Grid katalog produk (dinamis dari API)
- Search/filter produk
- Rekomendasi produk di sidebar
- Tombol "Tambah ke Keranjang" (UI only)
- Responsive design

**Endpoint API:**

- `GET /api/products.php` - Ambil semua produk

### 2. Halaman Detail Produk (detail.html)

**Fitur:**

- Carousel gambar produk
- Informasi detail produk (nama, harga, deskripsi, bahan, warna, ukuran)
- Rekomendasi produk lainnya (3 produk random)
- Tombol "Tambah ke Keranjang"

**Endpoint API:**

- `GET /api/products.php?id=X` - Ambil detail produk

### 3. Sistem Autentikasi

**Login (admin/login.html)**

- Form username & password
- Validasi input client-side
- Error handling
- Redirect ke dashboard jika sudah login

**Endpoint API:**

- `POST /api/auth.php?action=login` - Login user
- `GET /api/auth.php?action=check` - Cek status login
- `POST /api/auth.php?action=logout` - Logout user

**Keamanan:**

- Password di-hash menggunakan bcrypt
- Prepared statements untuk prevent SQL injection
- Session management dengan PHP native
- CORS dengan credential support

### 4. Admin Dashboard (admin/dashboard.html)

**Fitur:**

- Tabel daftar produk dengan pagination
- Tombol Tambah Produk
- Tombol Edit & Hapus per produk
- Modal form untuk tambah/edit produk
- Upload gambar dari device
- Validasi form
- Alert success/error

**Endpoint API:**

- `GET /api/products.php` - Ambil semua produk
- `POST /api/products.php` - Tambah produk (require auth)
- `PUT /api/products.php` - Edit produk (require auth)
- `DELETE /api/products.php?id=X` - Hapus produk (require auth)
- `POST /api/upload.php` - Upload gambar (require auth)

---

## 🚀 Panduan Instalasi

### Prasyarat

- Laragon (atau Apache + PHP + MySQL)
- PHP 7.4+
- MySQL 5.7+
- Browser modern (Chrome, Firefox, Safari, Edge)

### Langkah Instalasi

#### 1. Setup Database

```bash
# Akses folder project
cd C:\laragon\www\10_PHP_MYSQL

# Buka browser dan akses setup script
http://localhost/10_PHP_MYSQL/database-setup.php
```

Script akan:

- Membuat database `unwritten_db`
- Membuat tabel `users` dan `products`
- Insert test user (admin/admin123)
- Insert 9 produk sample

#### 2. Verifikasi Setup

```bash
# Akses debug script untuk verifikasi
http://localhost/10_PHP_MYSQL/debug.php
```

Pastikan:

- ✅ Database terkoneksi
- ✅ Tabel users ada dengan 2 user
- ✅ Password verification berhasil

#### 3. Akses Aplikasi

**Frontend Publik:**

```
http://localhost/10_PHP_MYSQL/index.html
```

**Admin Login:**

```
http://localhost/10_PHP_MYSQL/admin/login.html
```

**Kredensial Test:**

- Username: `admin`
- Password: `admin123`

---

## 📖 Panduan Penggunaan

### Untuk End User (Publik)

#### 1. Browsing Produk

1. Buka halaman utama
2. Lihat carousel banner
3. Scroll katalog produk
4. Gunakan search box untuk filter produk
5. Klik produk untuk lihat detail

#### 2. Lihat Detail Produk

1. Klik produk di katalog atau rekomendasi
2. Lihat carousel gambar produk
3. Baca informasi detail (nama, harga, deskripsi, bahan, warna, ukuran)
4. Lihat rekomendasi produk lainnya
5. Klik "Tambah ke Keranjang" (fitur UI, belum terintegrasi backend)

### Untuk Admin

#### 1. Login

1. Buka halaman login admin
2. Masukkan username & password
3. Klik tombol Login
4. Akan redirect ke dashboard jika berhasil

#### 2. Lihat Daftar Produk

1. Di dashboard, lihat tabel produk
2. Gunakan pagination untuk navigasi
3. Lihat gambar, nama, harga, deskripsi produk

#### 3. Tambah Produk

1. Klik tombol "Tambah Produk"
2. Isi form:
   - Nama Produk (required)
   - Harga (required, format: Rp 100.000 atau 100000)
   - Deskripsi (required, min 10 karakter)
   - Bahan (optional)
   - Aksesoris (optional)
   - Warna (optional)
   - Ukuran (optional)
   - Upload Gambar (optional, atau gunakan nama file existing)
3. Klik "Simpan"
4. Produk akan muncul di tabel dan halaman publik

#### 4. Edit Produk

1. Klik tombol "Edit" pada produk
2. Form akan terisi dengan data produk
3. Ubah field yang diperlukan
4. Klik "Simpan"
5. Produk akan terupdate

#### 5. Hapus Produk

1. Klik tombol "Hapus" pada produk
2. Konfirmasi penghapusan
3. Produk akan dihapus dari database

#### 6. Logout

1. Klik tombol "Logout" di navbar
2. Akan redirect ke halaman login

---

## 🔧 Dokumentasi Teknis

### Database Schema

#### Tabel: users

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Tabel: products

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
```

### API Endpoints

#### Authentication

**POST /api/auth.php?action=login**

```json
Request:
{
    "username": "admin",
    "password": "admin123"
}

Response (Success):
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user_id": 1,
        "username": "admin"
    }
}

Response (Error):
{
    "success": false,
    "message": "Invalid username or password"
}
```

**GET /api/auth.php?action=check**

```json
Response (Authenticated):
{
    "success": true,
    "authenticated": true,
    "data": {
        "user_id": 1,
        "username": "admin"
    }
}

Response (Not Authenticated):
{
    "success": false,
    "authenticated": false,
    "message": "Not authenticated"
}
```

**POST /api/auth.php?action=logout**

```json
Response:
{
    "success": true,
    "message": "Logout successful"
}
```

#### Products

**GET /api/products.php**

```json
Response:
{
    "success": true,
    "data": [
        {
            "id": 1,
            "name": "Heavenly Zoran - Shadow",
            "price": "Rp 740.000",
            "description": "Gaya elegan bernuansa misterius...",
            "images": ["Art1.jpeg", "Art2.jpeg"],
            "material": "Katun Satin Premium",
            "accessories": "Emerald",
            "colors": "Emas, Azure, Ametyst",
            "sizes": "XL, XXL, XXXL",
            "created_at": "2025-12-06 18:50:49",
            "updated_at": "2025-12-06 18:50:49"
        }
    ],
    "count": 9
}
```

**GET /api/products.php?id=1**

```json
Response:
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Heavenly Zoran - Shadow",
        ...
    }
}
```

**POST /api/products.php** (require auth)

```json
Request:
{
    "name": "New Product",
    "price": "Rp 500.000",
    "description": "Product description here",
    "material": "Cotton",
    "accessories": "Gold",
    "colors": "Red, Blue",
    "sizes": "M, L, XL",
    "images": ["Art1.jpeg"]
}

Response:
{
    "success": true,
    "data": { ... }
}
```

**PUT /api/products.php** (require auth)

```json
Request:
{
    "id": 1,
    "name": "Updated Product",
    "price": "Rp 600.000",
    ...
}

Response:
{
    "success": true,
    "data": { ... }
}
```

**DELETE /api/products.php?id=1** (require auth)

```json
Response:
{
    "success": true,
    "message": "Product deleted successfully"
}
```

**POST /api/upload.php** (require auth)

```
Request: multipart/form-data dengan file
Response:
{
    "success": true,
    "filename": "Art_1702000000_abc123.jpeg",
    "path": "assets/img/Art_1702000000_abc123.jpeg"
}
```

### Session Management

**Session Variables:**

```php
$_SESSION['user_id']    // ID user dari database
$_SESSION['username']   // Username user
$_SESSION['logged_in']  // Boolean flag
```

**Session Lifecycle:**

1. User login → Session dibuat dengan data user
2. User browse → Session dipertahankan di cookie
3. User logout → Session dihancurkan dengan `session_destroy()`

### Validasi Input

**Product Validation:**

- Name: Required, max 255 karakter
- Price: Required, format Rp atau angka
- Description: Required, min 10 karakter
- Images: Optional, format jpg/jpeg/png/gif/webp
- Material, Accessories, Colors, Sizes: Optional

**Upload Validation:**

- File type: jpg, jpeg, png, gif, webp
- Max size: 5MB
- Filename: Auto-generated dengan timestamp

---

## 🐛 Troubleshooting

### Database Connection Error

**Error:** "Database connection failed"

**Solusi:**

1. Pastikan MySQL running di Laragon
2. Cek credentials di `api/config.php`
3. Pastikan database `unwritten_db` sudah dibuat
4. Jalankan `database-setup.php` untuk setup ulang

### Login Gagal

**Error:** "Invalid username or password"

**Solusi:**

1. Pastikan username & password benar (admin/admin123)
2. Cek tabel users di database
3. Jalankan `debug.php` untuk verifikasi password hash
4. Jalankan `database-setup.php` untuk reset user

### Produk Tidak Tampil

**Error:** Halaman publik kosong

**Solusi:**

1. Buka browser console (F12) untuk cek error
2. Cek Network tab untuk verifikasi API response
3. Pastikan `api/products.php` bisa diakses
4. Jalankan `database-setup.php` untuk insert produk sample

### Upload Gambar Gagal

**Error:** "Failed to move uploaded file"

**Solusi:**

1. Pastikan folder `assets/img/` ada dan writable
2. Cek permission folder (chmod 755)
3. Pastikan file size < 5MB
4. Gunakan format gambar yang didukung (jpg, png, gif, webp)

### Edit Produk Tidak Berfungsi

**Status:** Known Issue - Sedang dalam pengembangan

**Workaround:**

1. Hapus produk lama
2. Tambah produk baru dengan data yang diinginkan

---

## 📝 Catatan Pengembangan

### Fitur yang Sudah Selesai ✅

- [x] Frontend publik (katalog, detail, rekomendasi)
- [x] Admin login dengan database & session
- [x] CRUD produk (Create, Read, Delete)
- [x] Upload gambar
- [x] Responsive design
- [x] API REST

### Fitur yang Sedang Dikembangkan 🔄

- [ ] Edit produk (PUT endpoint ada, UI masih ada bug)
- [ ] Shopping cart (UI ada, backend belum)
- [ ] Checkout & payment
- [ ] User profile & order history

### Fitur Masa Depan 📋

- [ ] Email notification
- [ ] Product reviews & ratings
- [ ] Wishlist
- [ ] Admin analytics & reports
- [ ] Multi-language support
- [ ] Dark mode

---

## 📞 Support & Contact

Untuk pertanyaan atau issue, silakan hubungi tim development.

**Last Updated:** December 2025
**Version:** 1.0.0 (MVP)
**Author:** Zulfa MAI-2311104010
