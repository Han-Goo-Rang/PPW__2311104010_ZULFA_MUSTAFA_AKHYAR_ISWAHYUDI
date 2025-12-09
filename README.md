# LAPORAN PRAKTIKUM

## PERANCANGAN DAN PEMROGRAMAN WEB

## MODUL 10 (PHP & MYSQL)

**Oleh:**
Zulfa Mustafa Akhyar Iswahyudi - 2311104010

**PROGRAM STUDI S1 REKAYASA PERANGKAT LUNAK**
**DIREKTORAT KAMPUS PURWOKERTO**
**UNIVERSITAS TELKOM**
**2025**

---

## BAB I

## PENDAHULUAN

### 1.1 Dasar Teori

#### 1.1.1 PHP (PHP: Hypertext Preprocessor)

PHP adalah bahasa pemrograman server-side yang digunakan untuk mengembangkan aplikasi web dinamis. PHP dijalankan di server dan menghasilkan output HTML yang dikirim ke browser client. Keunggulan PHP antara lain:

- Mudah dipelajari dan diimplementasikan
- Terintegrasi baik dengan HTML
- Mendukung berbagai database (MySQL, PostgreSQL, dll)
- Open source dan gratis
- Memiliki komunitas yang besar

#### 1.1.2 MySQL (My Structured Query Language)

MySQL adalah sistem manajemen basis data relasional (RDBMS) yang open source. MySQL menggunakan bahasa SQL untuk mengelola data. Fitur utama MySQL:

- Mendukung transaksi dan foreign keys
- Performa tinggi untuk aplikasi web
- Keamanan data dengan user authentication
- Mudah diinstall dan dikonfigurasi
- Kompatibel dengan berbagai platform

#### 1.1.3 REST API (Representational State Transfer)

REST API adalah arsitektur untuk membangun web service yang menggunakan HTTP methods (GET, POST, PUT, DELETE) untuk operasi CRUD. Keuntungan REST API:

- Stateless dan scalable
- Mudah diintegrasikan dengan frontend
- Menggunakan format JSON untuk data exchange
- Mendukung berbagai client (web, mobile, desktop)

#### 1.1.4 Session Management

Session adalah mekanisme untuk menyimpan data user di server selama user berinteraksi dengan aplikasi. Session digunakan untuk:

- Autentikasi user (login/logout)
- Menyimpan data user yang sedang login
- Tracking user activity
- Keamanan aplikasi

#### 1.1.5 Password Hashing

Password hashing adalah teknik mengenkripsi password sebelum disimpan di database. Menggunakan `password_hash()` dan `password_verify()` di PHP untuk:

- Melindungi password dari akses tidak sah
- Mencegah SQL injection
- Meningkatkan keamanan aplikasi

### 1.2 Tujuan

Praktikum ini bertujuan untuk:

1. Memahami konsep dasar PHP dan MySQL dalam pengembangan aplikasi web
2. Mengimplementasikan REST API untuk operasi CRUD (Create, Read, Update, Delete)
3. Membuat sistem autentikasi dengan session management
4. Mengintegrasikan frontend (HTML, CSS, JavaScript) dengan backend (PHP, MySQL)
5. Menerapkan best practices dalam keamanan aplikasi web
6. Mengembangkan aplikasi web fullstack yang fungsional dan responsif

### 1.3 Manfaat

Manfaat dari praktikum ini adalah:

1. **Pemahaman Mendalam:** Peserta memahami arsitektur aplikasi web fullstack
2. **Skill Praktis:** Peserta dapat membuat aplikasi web dengan PHP dan MySQL
3. **Portfolio:** Hasil praktikum dapat dijadikan portfolio untuk karir di bidang web development
4. **Best Practices:** Peserta belajar menerapkan security dan coding standards
5. **Problem Solving:** Peserta terlatih dalam troubleshooting dan debugging aplikasi web
6. **Kolaborasi:** Peserta memahami workflow development dengan version control dan documentation

---

## BAB II

## HASIL PRAKTIKUM

### Deskripsi

Aplikasi yang dikembangkan adalah **"Unwritten"** - sebuah platform e-commerce fashion untuk penjualan koleksi **Lightfantasy Outfit**. Aplikasi ini dibangun menggunakan teknologi:

- **Frontend:** HTML5, CSS3, JavaScript (Vanilla + jQuery), Bootstrap 5.3.3
- **Backend:** PHP 7.4+, MySQL 5.7+
- **Server:** Apache (Laragon)
- **Architecture:** REST API dengan Session-based Authentication

Aplikasi ini merupakan MVP (Minimum Viable Product) dengan fitur core yang sudah berfungsi penuh, mencakup:

- Katalog produk publik dengan search dan filter
- Detail produk dengan carousel gambar
- Admin dashboard dengan CRUD produk
- Sistem autentikasi dengan login/logout
- Upload gambar produk
- Responsive design untuk desktop dan mobile

### Fitur

#### A. Fitur Frontend Publik

**1. Halaman Utama (index.html)**

- Carousel banner otomatis dengan 3 slide
- Grid katalog produk yang dinamis (9 produk)
- Search box untuk filter produk real-time
- Sidebar rekomendasi produk
- Tombol "Tambah ke Keranjang" dengan toast notification
- Back-to-top button
- Responsive design (mobile-first)

**2. Halaman Detail Produk (detail.html)**

- Carousel gambar produk dengan multiple images
- Informasi detail produk:
  - Nama produk
  - Harga (format Rp)
  - Deskripsi lengkap
  - Spesifikasi (bahan, aksesoris, warna, ukuran)
- Rekomendasi produk lainnya (3 produk random)
- Tombol "Tambah ke Keranjang"
- Query parameter untuk dynamic routing (`?id=X`)

#### B. Fitur Admin Dashboard

**1. Sistem Autentikasi (admin/login.html)**

- Form login dengan username dan password
- Validasi input client-side
- Error handling dengan alert messages
- Auto-redirect ke dashboard jika sudah login
- Demo credentials: `admin` / `admin123`

**2. Admin Dashboard (admin/dashboard.html)**

- Tabel daftar produk dengan pagination (10 item per halaman)
- Tombol "Tambah Produk" → Modal form kosong
- Tombol "Edit" → Modal form pre-filled dengan data produk
- Tombol "Hapus" → Modal konfirmasi penghapusan
- Logout button di navbar
- Success/error alerts untuk setiap action
- Responsive table design

**3. CRUD Operations**

**CREATE (Tambah Produk):**

- Modal form dengan fields:
  - Nama Produk (required)
  - Harga (required, format Rp atau angka)
  - Deskripsi (required, min 10 karakter)
  - Bahan (optional)
  - Aksesoris (optional)
  - Warna (optional)
  - Ukuran (optional)
  - Upload Gambar (optional)
- Validasi input di client dan server
- Insert ke database dengan timestamp
- Auto-reload tabel setelah insert

**READ (Lihat Produk):**

- GET `/api/products.php` untuk ambil semua produk
- GET `/api/products.php?id=X` untuk ambil produk spesifik
- Tampilkan di tabel dengan pagination
- Tampilkan di grid katalog publik
- Tampilkan di halaman detail produk

**UPDATE (Edit Produk):**

- PUT `/api/products.php` untuk update produk
- Modal form pre-filled dengan data lama
- Validasi input sebelum update
- Update timestamp `updated_at`
- Auto-reload tabel setelah update

**DELETE (Hapus Produk):**

- DELETE `/api/products.php?id=X` untuk hapus produk
- Modal konfirmasi sebelum delete
- Soft delete atau hard delete dari database
- Auto-reload tabel setelah delete

#### C. Fitur Backend API

**1. Authentication API (api/auth.php)**

- `POST /api/auth.php?action=login` - Login user
  - Input: username, password
  - Output: user_id, username, session token
  - Validasi password dengan `password_verify()`
  - Set session di server
- `GET /api/auth.php?action=check` - Cek status login
  - Output: authenticated status, user data
  - Digunakan untuk auto-redirect
- `POST /api/auth.php?action=logout` - Logout user
  - Destroy session
  - Clear cookies

**2. Products API (api/products.php)**

- `GET /api/products.php` - Ambil semua produk
  - Output: array of products dengan pagination
- `GET /api/products.php?id=X` - Ambil produk spesifik
  - Output: single product object
- `POST /api/products.php` - Buat produk baru (auth required)
  - Input: product data (name, price, description, dll)
  - Validasi input
  - Insert ke database
  - Output: created product object
- `PUT /api/products.php` - Update produk (auth required)
  - Input: product id + updated data
  - Validasi input
  - Update di database
  - Output: updated product object
- `DELETE /api/products.php?id=X` - Hapus produk (auth required)
  - Delete dari database
  - Output: success message

**3. Upload API (api/upload.php)**

- `POST /api/upload.php` - Upload gambar (auth required)
  - Input: file dari form
  - Validasi file type (jpg, jpeg, png, gif, webp)
  - Validasi file size (max 5MB)
  - Generate filename dengan timestamp
  - Save ke `assets/img/`
  - Output: filename, file path

**4. Validation API (api/validators.php)**

- `validateProductName()` - Validasi nama produk
- `validateProductPrice()` - Validasi harga (format Rp atau angka)
- `validateProductDescription()` - Validasi deskripsi (min 10 char)
- `validateProductImages()` - Validasi array gambar
- `validateProductData()` - Validasi semua field produk
- `validateRequiredFields()` - Cek field wajib

#### D. Database Schema

**Tabel: users**

```sql
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Tabel: products**

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

#### E. Security Features

1. **Password Hashing:** Menggunakan `password_hash()` dan `password_verify()`
2. **Session Management:** Session-based authentication dengan PHP native
3. **Input Validation:** Validasi di client-side dan server-side
4. **SQL Injection Prevention:** Menggunakan prepared statements
5. **CORS Headers:** Allow cross-origin requests dengan credentials
6. **.htaccess Protection:** Melindungi folder admin dan api
7. **Error Handling:** Try-catch blocks dan error messages yang informatif

#### F. Responsive Design

- Mobile-first approach menggunakan Bootstrap 5.3.3
- Breakpoints: xs (mobile), sm, md, lg, xl, xxl
- Flexible grid system untuk layout
- Touch-friendly buttons dan forms
- Optimized images untuk berbagai ukuran layar

---

## BAB III

## KESIMPULAN & SARAN

### 3.1 Kesimpulan

Praktikum ini telah berhasil menghasilkan aplikasi web e-commerce "Unwritten" yang mendemonstrasikan:

1. **Implementasi REST API:** Aplikasi menggunakan REST API untuk komunikasi antara frontend dan backend, dengan HTTP methods (GET, POST, PUT, DELETE) yang sesuai standar.

2. **CRUD Operations:** Semua operasi CRUD (Create, Read, Update, Delete) telah diimplementasikan dengan baik, baik di frontend maupun backend.

3. **Authentication & Authorization:** Sistem login dengan session management dan password hashing telah diterapkan untuk keamanan aplikasi.

4. **Database Design:** Schema database dirancang dengan baik menggunakan tabel users dan products dengan relasi yang tepat.

5. **Frontend-Backend Integration:** Frontend (HTML, CSS, JavaScript) terintegrasi dengan baik dengan backend (PHP, MySQL) melalui AJAX calls.

6. **Security Best Practices:** Aplikasi menerapkan security best practices seperti input validation, SQL injection prevention, dan password hashing.

7. **Responsive Design:** Aplikasi responsif dan dapat diakses dari berbagai perangkat (desktop, tablet, mobile).

8. **Code Organization:** Kode terstruktur dengan baik dengan separation of concerns (frontend, backend, database).

### 3.2 Saran

Untuk pengembangan lebih lanjut, berikut adalah saran-saran:

1. **Shopping Cart Backend:** Implementasikan shopping cart di backend dengan database untuk menyimpan cart items per user.

2. **Checkout & Payment:** Tambahkan fitur checkout dengan integrasi payment gateway (Midtrans, Stripe, dll).

3. **User Registration:** Implementasikan fitur registrasi user untuk customer, bukan hanya admin.

4. **Order Management:** Tambahkan fitur order management untuk tracking pesanan dan status pengiriman.

5. **Product Reviews & Ratings:** Implementasikan fitur review dan rating produk dari customer.

6. **Admin Analytics:** Tambahkan dashboard analytics untuk melihat sales report, top products, dll.

7. **Email Notifications:** Implementasikan email notifications untuk order confirmation, shipping updates, dll.

8. **Image Optimization:** Optimasi gambar dengan compression dan lazy loading untuk performa lebih baik.

9. **Caching:** Implementasikan caching (Redis, Memcached) untuk performa lebih baik.

10. **API Documentation:** Buat dokumentasi API yang lengkap menggunakan Swagger/OpenAPI.

11. **Unit Testing:** Tambahkan unit tests untuk backend API menggunakan PHPUnit.

12. **CI/CD Pipeline:** Setup CI/CD pipeline untuk automated testing dan deployment.

13. **Database Optimization:** Tambahkan indexes pada kolom yang sering di-query untuk performa lebih baik.

14. **Error Logging:** Implementasikan error logging untuk tracking bugs dan issues di production.

15. **Multi-language Support:** Tambahkan support untuk multiple languages (i18n).

---

**Demikian laporan praktikum ini dibuat. Semoga bermanfaat.**

**Purwokerto, Desember 2025**

**Zulfa Mustafa Akhyar Iswahyudi**
**2311104010**
