<?php
require_once 'auth.php';
require_once 'koneksi.php';
require_once 'fungsi.php';

$data  = [];
$error = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valid($_POST['csrf'] ?? '')) {
        $error['csrf'] = t('err_csrf');
    } else {
        [$data, $error] = validasi_buku($pdo, $_POST);

        if (empty($error)) {
            // CREATE
            $stmt = $pdo->prepare(
                'INSERT INTO buku (isbn, judul, penulis, penerbit, tahun, kategori, stok)
                 VALUES (?, ?, ?, ?, ?, ?, ?)'
            );
            $stmt->execute([$data['isbn'], $data['judul'], $data['penulis'], $data['penerbit'],
                            $data['tahun'], $data['kategori'], $data['stok']]);
            set_flash('sukses_tambah');
            header('Location: index.php');
            exit;
        }
    }
    $data = $_POST;
}

$judul_form = t('tambah');
require 'header.php';
require 'form_buku.php';
require 'footer.php';
