<?php
// Form input bersama (tambah & ubah). Variabel: $data, $error, $judul_form
?>
<div class="card">
    <h2><?= e($judul_form) ?></h2>
    <form method="POST" novalidate>
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <?php if (!empty($error['csrf'])): ?><div class="alert alert-error"><?= e($error['csrf']) ?></div><?php endif; ?>

        <?php
        $kolom = ['isbn' => 'text', 'judul' => 'text', 'penulis' => 'text', 'penerbit' => 'text', 'tahun' => 'number', 'stok' => 'number'];
        foreach ($kolom as $nama => $tipe): ?>
            <label><?= e(t($nama)) ?></label>
            <input type="<?= $tipe ?>" name="<?= $nama ?>" value="<?= e($data[$nama] ?? '') ?>" class="<?= isset($error[$nama]) ? 'invalid' : '' ?>">
            <?php if (isset($error[$nama])): ?><small class="err"><?= e($error[$nama]) ?></small><?php endif; ?>
        <?php endforeach; ?>

        <label><?= e(t('kategori')) ?></label>
        <select name="kategori" class="<?= isset($error['kategori']) ? 'invalid' : '' ?>">
            <option value=""><?= e(t('pilih')) ?></option>
            <?php foreach (daftar_kategori() as $k): ?>
                <option value="<?= e($k) ?>" <?= (($data['kategori'] ?? '') === $k) ? 'selected' : '' ?>><?= e(t($k)) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (isset($error['kategori'])): ?><small class="err"><?= e($error['kategori']) ?></small><?php endif; ?>

        <div class="form-aksi">
            <button type="submit" class="btn"><?= e(t('simpan')) ?></button>
            <a href="index.php" class="btn btn-abu"><?= e(t('batal')) ?></a>
        </div>
    </form>
</div>
