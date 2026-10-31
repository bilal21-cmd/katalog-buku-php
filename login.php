<?php
require_once 'koneksi.php';
require_once 'fungsi.php';

// Sudah login -> ke halaman utama
if (!empty($_SESSION['login'])) {
    header('Location: index.php');
    exit;
}

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = bersihkan($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (!csrf_valid($_POST['csrf'] ?? '')) {
        $pesan = t('err_csrf');
    } elseif ($user === '' || $pass === '') {
        $pesan = t('login_kosong');
    } else {
        $q = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $q->execute([$user]);
        $row = $q->fetch();

        if ($row && password_verify($pass, $row['password'])) {
            session_regenerate_id(true);          // cegah session fixation
            $_SESSION['login']    = true;
            $_SESSION['user_id']  = $row['id'];
            $_SESSION['nama']     = $row['nama'];
            header('Location: index.php');
            exit;
        }
        $pesan = t('login_gagal');
    }
}
?>
<?php require 'header.php'; ?>
<div class="card login-card">
    <h2><?= e(t('login')) ?></h2>
    <?php if ($pesan): ?><div class="alert alert-error"><?= e($pesan) ?></div><?php endif; ?>
    <form method="POST" action="login.php">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <label><?= e(t('username')) ?></label>
        <input type="text" name="username" value="<?= e($_POST['username'] ?? '') ?>" autofocus>
        <label><?= e(t('password')) ?></label>
        <input type="password" name="password">
        <button type="submit" class="btn"><?= e(t('login')) ?></button>
    </form>
    <p class="hint"></p>
</div>
<?php require 'footer.php'; ?>
