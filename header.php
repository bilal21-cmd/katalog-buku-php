<?php require_once 'fungsi.php'; ?>
<!DOCTYPE html>
<html lang="<?= e($_SESSION['bahasa']) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e(t('judul_app')) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
    <a class="brand" href="index.php">📚 <?= e(t('judul_app')) ?></a>
    <div class="nav-right">
        <span class="lang">
            <?= e(t('bahasa')) ?>:
            <a href="ganti_bahasa.php?lang=id" class="<?= $_SESSION['bahasa'] === 'id' ? 'aktif' : '' ?>">ID</a> |
            <a href="ganti_bahasa.php?lang=en" class="<?= $_SESSION['bahasa'] === 'en' ? 'aktif' : '' ?>">EN</a>
        </span>
        <?php if (!empty($_SESSION['login'])): ?>
            <span><?= e(t('halo')) ?>, <b><?= e($_SESSION['nama']) ?></b></span>
            <a class="btn btn-small btn-abu" href="logout.php"><?= e(t('logout')) ?></a>
        <?php endif; ?>
    </div>
</nav>
<main class="container">
