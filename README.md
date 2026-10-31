# Katalog Buku (Sistem Informasi Manajemen Data Sederhana)

Tugas 2 – PHP murni (PDO) + MySQL/MariaDB.

## Fitur
- **Login/Logout** dengan `$_SESSION`; semua halaman CRUD diproteksi (`auth.php`). Password di-hash (`password_hash`).
- **CRUD Buku**: tambah, tampil (tabel + pencarian), ubah, hapus.
- **Validasi** dengan `if-else` (kelengkapan, format ISBN, rentang tahun, stok, kategori, ISBN unik).
- **Sanitasi**: `strip_tags`, `filter_var`, `htmlspecialchars`; prepared statement; token CSRF.
- **Dual bahasa** ID/EN disimpan di `$_SESSION['bahasa']` (dipilih dengan `switch`).

## Cara Menjalankan (Laragon/XAMPP)
1. Salin folder ke `htdocs`/`www`, mis. `katalog-buku`.
2. Jalankan Apache & MySQL.
3. Impor `database.sql` lewat phpMyAdmin (atau `mysql -u root < database.sql`).
4. Buka `http://localhost/katalog-buku/` → login **admin / admin123**.

Jika MySQL memakai password, ubah `$password` di `koneksi.php`.

## Struktur File
| File | Fungsi |
|---|---|
| database.sql | Skema + data awal |
| koneksi.php | Koneksi PDO |
| bahasa.php / ganti_bahasa.php | Kamus ID/EN + session bahasa |
| auth.php | Proteksi halaman |
| fungsi.php | Sanitasi, validasi, CSRF, flash |
| login.php / logout.php | Otentikasi |
| index.php | Read |
| tambah.php | Create |
| edit.php | Update |
| hapus.php | Delete (POST) |
| form_buku.php, header.php, footer.php, style.css | Tampilan |
