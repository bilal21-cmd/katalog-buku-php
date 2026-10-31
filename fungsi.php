<?php
require_once 'bahasa.php';

// Sanitasi teks: buang tag HTML, spasi berlebih
function bersihkan($teks) {
    return trim(strip_tags((string)$teks));
}

// Escape saat menampilkan ke HTML (cegah XSS)
function e($teks) {
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

// Token CSRF
function csrf_token() {
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}
function csrf_valid($token) {
    return isset($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}

// Pesan flash (tampil sekali setelah redirect)
function set_flash($kunci) { $_SESSION['flash'] = $kunci; }
function ambil_flash() {
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $f;
}

function daftar_kategori() {
    return ['Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Lainnya'];
}

/**
 * Sanitasi + validasi data buku.
 * Mengembalikan [data_bersih, daftar_error]
 */
function validasi_buku(PDO $pdo, array $input, $id_abaikan = null) {
    $data = [
        'isbn'     => preg_replace('/[\s-]/', '', bersihkan($input['isbn'] ?? '')),
        'judul'    => bersihkan($input['judul'] ?? ''),
        'penulis'  => bersihkan($input['penulis'] ?? ''),
        'penerbit' => bersihkan($input['penerbit'] ?? ''),
        'tahun'    => bersihkan($input['tahun'] ?? ''),
        'kategori' => bersihkan($input['kategori'] ?? ''),
        'stok'     => bersihkan($input['stok'] ?? ''),
    ];
    $error = [];

    // Kelengkapan data (if-else)
    foreach (['isbn', 'judul', 'penulis', 'penerbit', 'tahun', 'kategori', 'stok'] as $f) {
        if ($data[$f] === '') {
            $error[$f] = t($f) . ' ' . t('err_wajib');
        }
    }

    // Format ISBN + cek duplikat
    if (!isset($error['isbn'])) {
        if (!preg_match('/^(\d{10}|\d{13})$/', $data['isbn'])) {
            $error['isbn'] = t('err_isbn');
        } else {
            $q = $pdo->prepare('SELECT id FROM buku WHERE isbn = ? AND id <> ?');
            $q->execute([$data['isbn'], (int)$id_abaikan]);
            if ($q->fetch()) {
                $error['isbn'] = t('err_isbn_ganda');
            }
        }
    }

    // Tahun terbit
    if (!isset($error['tahun'])) {
        $tahun = filter_var($data['tahun'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1900, 'max_range' => (int)date('Y')]
        ]);
        if ($tahun === false) {
            $error['tahun'] = t('err_tahun');
        } else {
            $data['tahun'] = $tahun;
        }
    }

    // Stok
    if (!isset($error['stok'])) {
        $stok = filter_var($data['stok'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
        if ($stok === false) {
            $error['stok'] = t('err_stok');
        } else {
            $data['stok'] = $stok;
        }
    }

    // Kategori harus salah satu dari daftar
    if (!isset($error['kategori']) && !in_array($data['kategori'], daftar_kategori(), true)) {
        $error['kategori'] = t('err_kategori');
    }

    return [$data, $error];
}
