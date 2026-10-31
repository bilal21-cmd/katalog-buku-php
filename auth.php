<?php
// Dipasang di bagian atas setiap halaman CRUD untuk proteksi akses
require_once 'bahasa.php';

if (empty($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('Location: login.php');
    exit;
}
