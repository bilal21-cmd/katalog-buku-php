<?php
require_once 'bahasa.php';

$bahasa = $_SESSION['bahasa'];   // pertahankan pilihan bahasa
$_SESSION = [];
session_destroy();

session_start();
$_SESSION['bahasa'] = $bahasa;
header('Location: login.php');
exit;
