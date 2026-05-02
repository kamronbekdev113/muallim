<?php
$this->title = $name ?? 'Xato';
?>
<div class="container py-5 text-center">
    <div style="font-family:var(--arabic-font);font-size:4rem;color:var(--gold);margin-bottom:1rem">خطأ</div>
    <h1 style="font-size:2rem;color:var(--dark-text)"><?= htmlspecialchars($name ?? 'Xato') ?></h1>
    <p style="color:var(--mid-text)"><?= htmlspecialchars($message ?? '') ?></p>
    <a href="<?= yii\helpers\Url::to(['/']) ?>" class="btn-muallim mt-3">Bosh sahifaga qaytish</a>
</div>
