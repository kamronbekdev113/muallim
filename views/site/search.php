<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = "Qidiruv: $q";
?>
<div class="container py-section" style="max-width:780px">
    <div class="section-header">
        <h2>🔍 Qidiruv natijalari</h2>
        <div class="gold-underline"></div>
    </div>
    <form method="get" action="<?= Url::to(['/qidiruv']) ?>" class="mb-4 d-flex" style="gap:0.5rem">
        <input type="text" name="q" value="<?= Html::encode($q) ?>" class="form-control-muallim flex-grow-1" placeholder="Qidirish...">
        <button type="submit" class="btn-muallim">Qidirish</button>
    </form>
    <?php if ($q && empty($lessons) && empty($surahs)): ?>
        <p style="color:var(--mid-text)">Hech narsa topilmadi.</p>
    <?php endif; ?>
    <?php if (!empty($lessons)): ?>
    <h5 style="font-weight:700;color:var(--green-deep);margin-bottom:1rem">Darslar</h5>
    <?php foreach ($lessons as $l): ?>
    <a href="<?= Url::to(['/dars/' . $l->id]) ?>" class="chapter-card">
        <strong><?= Html::encode($l->title_uz) ?></strong>
        <div class="lesson-arabic mt-1" style="font-size:1rem;padding:0.5rem"><?= Html::encode(mb_substr($l->arabic_text ?? '', 0, 40)) ?>...</div>
    </a>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php if (!empty($surahs)): ?>
    <h5 style="font-weight:700;color:var(--green-deep);margin:1.5rem 0 1rem">Suralar</h5>
    <?php foreach ($surahs as $s): ?>
    <a href="<?= Url::to(['/mushaf/' . $s->number]) ?>" class="surah-item">
        <div class="surah-num"><?= $s->number ?></div>
        <div><div class="surah-name-ar"><?= $s->name_ar ?></div><div class="surah-name-uz"><?= Html::encode($s->name_uz) ?></div></div>
    </a>
    <?php endforeach; ?>
    <?php endif; ?>
</div>
