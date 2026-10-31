<?php
require 'bahasa.php';

$lang = $_GET['lang'] ?? 'id';

// Percabangan switch untuk memilih bahasa
switch ($lang) {
    case 'en':
        $_SESSION['bahasa'] = 'en';
        break;
    case 'id':
    default:
        $_SESSION['bahasa'] = 'id';
        break;
}

// Kembali ke halaman sebelumnya (hanya jika berasal dari situs yang sama)
$kembali = 'index.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $ref = parse_url($_SERVER['HTTP_REFERER']);
    if (($ref['host'] ?? '') === ($_SERVER['HTTP_HOST'] ?? '') ) {
        $kembali = $_SERVER['HTTP_REFERER'];
    }
}
header('Location: ' . $kembali);
exit;
