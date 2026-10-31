-- Skrip ekspor database: Katalog Buku
CREATE DATABASE IF NOT EXISTS db_katalog_buku CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_katalog_buku;

DROP TABLE IF EXISTS buku;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(13) NOT NULL UNIQUE,
    judul VARCHAR(200) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun SMALLINT NOT NULL,
    kategori VARCHAR(20) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Akun demo: admin / admin123 (password di-hash dengan password_hash)
INSERT INTO users (username, password, nama) VALUES
('admin', '$2y$10$bTMDzalehDsYfejbUaqqoun.0ffZXBDeaDQF/RLxVABuenMwGk7uu', 'Administrator');

INSERT INTO buku (isbn, judul, penulis, penerbit, tahun, kategori, stok) VALUES
('9786020332956', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 'Fiksi', 12),
('9786021234567', 'Pemrograman Web dengan PHP', 'Budi Raharjo', 'Informatika', 2020, 'Teknologi', 8),
('9789794336793', 'Sapiens: Riwayat Singkat Umat Manusia', 'Yuval Noah Harari', 'KPG', 2017, 'Sejarah', 5),
('9786020318431', 'Cosmos', 'Carl Sagan', 'Gramedia', 2013, 'Sains', 3);
