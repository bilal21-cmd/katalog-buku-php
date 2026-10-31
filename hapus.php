<?php
require_once 'auth.php';
require_once 'koneksi.php';
require_once 'fungsi.php';

// Hanya menerima POST + token CSRF valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_valid($_POST['csrf'] ?? '')) {
    $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
    if ($id !== false && $id !== null) {
        // DELETE
        $stmt = $pdo->prepare('DELETE FROM buku WHERE id = ?');
        $stmt->execute([$id]);
        set_flash('sukses_hapus');
    }
}
header('Location: index.php');
exit;
