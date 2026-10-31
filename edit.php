<?php
require_once 'auth.php';
require_once 'koneksi.php';
require_once 'fungsi.php';

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: index.php');
    exit;
}

$q = $pdo->prepare('SELECT * FROM buku WHERE id = ?');
$q->execute([$id]);
$buku = $q->fetch();

if (!$buku) {
    require 'header.php';
    echo '<div class="alert alert-error">' . e(t('tdk_ditemukan')) . '</div><a class="btn" href="index.php">&larr;</a>';
    require 'footer.php';
    exit;
}

$data  = $buku;
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid($_POST['csrf'] ?? '')) {
        $error['csrf'] = t('err_csrf');
        $data = $_POST;
    } else {
        [$bersih, $error] = validasi_buku($pdo, $_POST, $id);

        if (empty($error)) {
            // UPDATE berdasarkan id (identitas unik)
            $stmt = $pdo->prepare(
                'UPDATE buku SET isbn=?, judul=?, penulis=?, penerbit=?, tahun=?, kategori=?, stok=? WHERE id=?'
            );
            $stmt->execute([$bersih['isbn'], $bersih['judul'], $bersih['penulis'], $bersih['penerbit'],
                            $bersih['tahun'], $bersih['kategori'], $bersih['stok'], $id]);
            set_flash('sukses_ubah');
            header('Location: index.php');
            exit;
        }
        $data = $_POST;
    }
}

$judul_form = t('edit');
require 'header.php';
require 'form_buku.php';
require 'footer.php';
