-- Create Database
CREATE DATABASE IF NOT EXISTS unwritten_db;
USE unwritten_db;

-- Create Users Table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create Products Table
CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert Default Admin User (username: admin, password: admin123)
INSERT INTO users (username, password) VALUES 
('admin', '$2y$10$YIjlrPDtOSqVV8/LewKh2OPST9/PgBkqquzi.Oo8KKUgO2t0jWMUm');

-- Insert Sample Products
INSERT INTO products (name, price, description, images, material, accessories, colors, sizes) VALUES
('Heavenly Zoran - Shadow', 'Rp 740.000', 'Gaya elegan bernuansa misterius dengan bahan satin lembut dan ringan.', '["Art1.jpeg", "Art2.jpeg", "Art3.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL'),
('Heavenly Zoran - Shaolin', 'Rp 710.100', 'Perpaduan desain oriental modern dengan nuansa lembut.', '["Art2.jpeg", "Art3.jpeg", "Art4.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL'),
('Heavenly Zoran - Enlight', 'Rp 820.000', 'Memberikan kesan bercahaya dengan material berkilau lembut.', '["Art3.jpeg", "Art4.jpeg", "Art5.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL'),
('Heavenly Candra', 'Rp 930.000', 'Elegan dan klasik, cocok untuk acara malam hari.', '["Art4.jpeg", "Art5.jpeg", "Art6.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL'),
('Heavenly Chaos', 'Rp 930.000', 'Desain berani yang melambangkan keunikan dan ekspresi diri.', '["Art5.jpeg", "Art6.jpeg", "Art7.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL'),
('Heavenly Armanth', 'Rp 890.000', 'Motif abstrak berwarna hangat dengan bahan premium.', '["Art6.jpeg", "Art7.jpeg", "Art8.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL'),
('Heavenly Shades', 'Rp 925.000', 'Tampilan gradasi lembut memberi kesan menenangkan.', '["Art7.jpeg", "Art8.jpeg", "Art10.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL'),
('Heavenly Ayaskara', 'Rp 970.000', 'Perpaduan desain modern dan tradisional dalam satu karya.', '["Art8.jpeg", "Art10.jpeg", "Art1.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL'),
('Heavenly Gaia - Cassandra', 'Rp 1.000.000', 'Perpaduan desain klasikal dan surealisme.', '["Art10.jpeg"]', 'Katun Satin Premium', 'Emerald', 'Emas, Azure, Ametyst', 'XL, XXL, XXXL');
