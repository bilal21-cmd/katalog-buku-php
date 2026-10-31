<?php
// Koneksi database memakai PDO (MySQL/MariaDB)
$host     = "localhost";
$dbname   = "db_katalog_buku";
$username = "root";
$password = "";          // isi jika MySQL Anda memakai password

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Koneksi database gagal. Pastikan database 'db_katalog_buku' sudah diimpor dari database.sql.");
}
