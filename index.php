<?php
require_once 'auth.php';
require_once 'koneksi.php';
require_once 'fungsi.php';

// READ: ambil data (dengan pencarian opsional)
$cari = bersihkan($_GET['q'] ?? '');
if ($cari !== '') {
    $stmt = $pdo->prepare('SELECT * FROM buku WHERE judul LIKE ? OR penulis LIKE ? ORDER BY id DESC');
    $like = '%' . $cari . '%';
    $stmt->execute([$like, $like]);
} else {
    $stmt = $pdo->query('SELECT * FROM buku ORDER BY id DESC');
}
$buku  = $stmt->fetchAll();
$flash = ambil_flash();
?>
<?php require 'header.php'; ?>
<div class="toolbar">
    <h2><?= e(t('daftar')) ?></h2>
    <a class="btn" href="tambah.php">+ <?= e(t('tambah')) ?></a>
</div>

<?php if ($flash): ?><div class="alert alert-ok"><?= e(t($flash)) ?></div><?php endif; ?>

<form method="GET" class="search">
    <input type="text" name="q" value="<?= e($cari) ?>" placeholder="<?= e(t('cari')) ?>">
    <button class="btn" type="submit"><?= e(t('tombol_cari')) ?></button>
</form>

<div class="table-wrap">
<table>
    <thead>
        <tr>
            <th><?= e(t('no')) ?></th><th><?= e(t('isbn')) ?></th><th><?= e(t('judul')) ?></th>
            <th><?= e(t('penulis')) ?></th><th><?= e(t('penerbit')) ?></th><th><?= e(t('tahun')) ?></th>
            <th><?= e(t('kategori')) ?></th><th><?= e(t('stok')) ?></th><th><?= e(t('aksi')) ?></th>
        </tr>
    </thead>
    <tbody>
    <?php if (count($buku) === 0): ?>
        <tr><td colspan="9" class="center"><?= e(t('kosong')) ?></td></tr>
    <?php else: $no = 1; foreach ($buku as $b): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= e($b['isbn']) ?></td>
            <td><?= e($b['judul']) ?></td>
            <td><?= e($b['penulis']) ?></td>
            <td><?= e($b['penerbit']) ?></td>
            <td><?= e($b['tahun']) ?></td>
            <td><?= e(t($b['kategori'])) ?></td>
            <td><?= e($b['stok']) ?></td>
            <td class="aksi">
                <a class="btn btn-small" href="edit.php?id=<?= (int)$b['id'] ?>"><?= e(t('ubah')) ?></a>
                <form method="POST" action="hapus.php" onsubmit="return confirm('<?= e(t('konfirmasi')) ?>')">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                    <button class="btn btn-small btn-merah" type="submit"><?= e(t('hapus')) ?></button>
                </form>
            </td>
        </tr>
    <?php endforeach; endif; ?>
    </tbody>
</table>
</div>
<?php require 'footer.php'; ?>
