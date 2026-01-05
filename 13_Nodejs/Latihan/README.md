# Aplikasi Pengelolaan Data Mahasiswa

Aplikasi web untuk pengelolaan data mahasiswa berbasis Node.js, Express.js, dan MySQL dengan RESTful API.

## Struktur Proyek

```
aplikasi-pengelolaan-mahasiswa/
├── config/
│   └── database.js          # Konfigurasi koneksi database
├── routes/
│   └── mahasiswa.js         # Routes untuk API mahasiswa
├── public/
│   └── index.html           # Frontend aplikasi
├── database/
│   └── schema.sql           # Schema database
├── server.js                # Entry point aplikasi
├── package.json             # Dependencies
├── .env                     # Konfigurasi environment
└── README.md                # Dokumentasi
```

## Fitur Utama

- **GET /api/mahasiswa** - Mengambil semua data mahasiswa
- **GET /api/mahasiswa/:id** - Mengambil data mahasiswa berdasarkan ID
- **POST /api/mahasiswa** - Menambah data mahasiswa baru
- **PUT /api/mahasiswa/:id** - Mengupdate data mahasiswa
- **DELETE /api/mahasiswa/:id** - Menghapus data mahasiswa

## Instalasi

1. Clone atau download proyek ini
2. Install dependencies:

   ```bash
   npm install
   ```

3. Setup database:

   - Buka MySQL dan jalankan script di `database/schema.sql`
   - Atau gunakan command:
     ```bash
     mysql -u root -p < database/schema.sql
     ```

4. Konfigurasi `.env`:
   ```
   PORT=3000
   DB_HOST=localhost
   DB_USER=root
   DB_PASSWORD=password_anda
   DB_NAME=db_mahasiswa
   ```

## Menjalankan Aplikasi

Development mode (dengan auto-reload):

```bash
npm run dev
```

Production mode:

```bash
npm start
```

Aplikasi akan berjalan di `http://localhost:3000`

## Teknologi yang Digunakan

- **Node.js** - Runtime JavaScript
- **Express.js** - Web framework
- **MySQL** - Database
- **CORS** - Cross-Origin Resource Sharing
- **Body Parser** - Middleware untuk parsing request body
- **Dotenv** - Manajemen environment variables

## API Endpoints

### Tambah Mahasiswa

```
POST /api/mahasiswa
Content-Type: application/json

{
  "nim": "2021004",
  "nama": "Rina Wijaya",
  "email": "rina@example.com",
  "jurusan": "Teknik Informatika"
}
```

### Update Mahasiswa

```
PUT /api/mahasiswa/1
Content-Type: application/json

{
  "nim": "2021004",
  "nama": "Rina Wijaya",
  "email": "rina.wijaya@example.com",
  "jurusan": "Sistem Informasi"
}
```

### Hapus Mahasiswa

```
DELETE /api/mahasiswa/1
```

## Catatan

- Pastikan MySQL server sudah berjalan sebelum menjalankan aplikasi
- Sesuaikan konfigurasi database di file `.env` dengan setup lokal Anda
- Frontend dapat diakses di `http://localhost:3000/public/index.html`
