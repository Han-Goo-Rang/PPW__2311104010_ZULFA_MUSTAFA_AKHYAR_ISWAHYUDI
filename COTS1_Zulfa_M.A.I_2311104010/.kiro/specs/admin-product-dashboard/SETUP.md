# Admin Product Dashboard - Setup Guide

## Prerequisites

- PHP 7.4 atau lebih tinggi
- MySQL Server
- Web Server (Apache dengan mod_rewrite atau Nginx)
- phpMyAdmin (untuk setup database)

## Installation Steps

### 1. Database Setup

1. Buka phpMyAdmin di browser
2. Klik tab "SQL"
3. Copy-paste seluruh isi dari file `database.sql`
4. Klik "Go" untuk execute

Atau gunakan command line:

```bash
mysql -u root -p < database.sql
```

### 2. Configure Database Connection

Edit file `api/config.php` dan sesuaikan dengan konfigurasi MySQL Anda:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'unwritten_db');
```

### 3. File Structure

Pastikan struktur folder sudah benar:

```
project-root/
├── index.html
├── detail.html
├── admin/
│   ├── login.html
│   ├── dashboard.html
│   └── .htaccess
├── api/
│   ├── config.php
│   ├── auth.php
│   ├── products.php
│   ├── validators.php
│   └── .htaccess
└── assets/
    ├── app.css
    ├── script.js
    ├── api-client.js
    └── img/
        ├── Art1.jpeg
        ├── Art2.jpeg
        └── ... (semua gambar produk)
```

### 4. Web Server Configuration

#### Apache

Pastikan `mod_rewrite` sudah enabled:

```bash
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Nginx

Tidak perlu konfigurasi khusus, API sudah berfungsi dengan baik.

### 5. Access the Application

- **Customer Site**: `http://localhost/index.html`
- **Admin Login**: `http://localhost/admin/login.html`
- **Admin Dashboard**: `http://localhost/admin/dashboard.html` (setelah login)

## Default Admin Credentials

- **Username**: `admin`
- **Password**: `admin123`

## API Endpoints

### Authentication

- `POST /api/auth.php?action=login` - Login user
- `POST /api/auth.php?action=logout` - Logout user
- `GET /api/auth.php?action=check` - Check authentication status

### Products

- `GET /api/products.php` - Get all products
- `GET /api/products.php?id=X` - Get single product by ID
- `POST /api/products.php` - Create new product (requires authentication)
- `PUT /api/products.php` - Update product (requires authentication)
- `DELETE /api/products.php?id=X` - Delete product (requires authentication)

## Features

### Customer Features

- View all products
- Search products
- View product details
- Add products to cart (UI only)

### Admin Features

- Login/Logout
- View all products in table format
- Create new products
- Edit existing products
- Delete products
- Pagination for product list
- Form validation
- Error handling

## Security Features

- Session-based authentication
- Password hashing with bcrypt
- SQL injection prevention with prepared statements
- CORS headers for API requests
- Input validation on both frontend and backend

## Troubleshooting

### Database Connection Error

Pastikan:

1. MySQL server sudah running
2. Database credentials di `api/config.php` sudah benar
3. Database `unwritten_db` sudah dibuat

### API Not Working

Pastikan:

1. PHP version 7.4 atau lebih tinggi
2. `mod_rewrite` sudah enabled (untuk Apache)
3. File permissions sudah benar (755 untuk folder, 644 untuk file)

### Login Not Working

Pastikan:

1. Session sudah enabled di PHP
2. Cookie sudah enabled di browser
3. Username dan password sudah benar (default: admin/admin123)

### Images Not Loading

Pastikan:

1. Gambar sudah ada di folder `assets/img/`
2. Nama file gambar sudah benar (case-sensitive)
3. File permissions sudah benar

## Performance Tips

1. Gunakan CDN untuk Bootstrap dan jQuery
2. Minify CSS dan JavaScript
3. Optimize gambar produk
4. Gunakan database indexing untuk kolom yang sering di-query
5. Implement caching untuk API responses

## Future Enhancements

- User management (multiple admin accounts)
- Product categories
- Product inventory tracking
- Order management
- Customer reviews
- Payment integration
- Email notifications
- Analytics dashboard
