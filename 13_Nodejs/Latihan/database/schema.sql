-- Buat database
CREATE DATABASE IF NOT EXISTS db_mahasiswa;
USE db_mahasiswa;

-- Buat tabel mahasiswa
CREATE TABLE IF NOT EXISTS mahasiswa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nim VARCHAR(20) NOT NULL UNIQUE,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  jurusan VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data contoh
INSERT INTO mahasiswa (nim, nama, email, jurusan) VALUES
('2021001', 'Ahmad Rizki', 'ahmad@example.com', 'Teknik Informatika'),
('2021002', 'Siti Nurhaliza', 'siti@example.com', 'Sistem Informasi'),
('2021003', 'Budi Santoso', 'budi@example.com', 'Teknik Komputer');
