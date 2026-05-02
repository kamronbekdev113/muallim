<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Arab Alifbosi';
?>
<div class="container py-section">
    <div class="section-header">
        <h2>🔤 Arab Alifbosi</h2>
        <p>28 harf — shakllari, talaffuzi, yozilishi va misollari bilan</p>
        <div class="gold-underline"></div>
    </div>

    <?php if (!empty($completed)): ?>
    <div class="text-center mb-4">
        <span class="badge" style="background:var(--green-deep);color:#fff;padding:6px 16px;border-radius:20px;font-size:0.85rem">
            <i class="fas fa-check-circle mr-1"></i> <?= count($completed) ?>/28 harf o'rganildi
        </span>
    </div>
    <?php endif; ?>

    <div class="letter-grid">
        <?php foreach ($letters as $l): ?>
        <a href="<?= Url::to(['/alifbo/' . $l->id]) ?>"
           class="letter-card <?= isset($completed[$l->id]) ? 'completed' : '' ?>">
            <span class="letter-arabic"><?= $l->letter ?></span>
            <span class="letter-name"><?= Html::encode($l->name_uz) ?></span>
            <span class="letter-number"><?= $l->transliteration ?></span>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- Mashqlar paneli -->
    <div class="mt-5">
        <h5 style="font-weight:700;color:var(--green-deep);text-align:center;margin-bottom:1.25rem">
            <i class="fas fa-dumbbell mr-2" style="color:var(--gold)"></i>Mashq turlari
        </h5>
        <div class="row" style="gap:.75rem;margin:0;justify-content:center">
            <a href="<?= Url::to(['/mashq/harflar']) ?>" style="min-width:150px;flex:1;max-width:200px;text-align:center;background:var(--card-bg);border:1.5px solid rgba(201,168,76,.35);border-radius:14px;padding:1.25rem .75rem;text-decoration:none;color:var(--dark-text);transition:.2s" class="mashq-tile">
                <div style="font-size:1.8rem;margin-bottom:.4rem">🃏</div>
                <div style="font-weight:600;font-size:.9rem">Flashcard</div>
                <div style="font-size:.75rem;color:var(--mid-text);margin-top:2px">Kartani ag'darish</div>
            </a>
            <a href="<?= Url::to(['/mashq/shakl']) ?>" style="min-width:150px;flex:1;max-width:200px;text-align:center;background:var(--card-bg);border:1.5px solid rgba(201,168,76,.35);border-radius:14px;padding:1.25rem .75rem;text-decoration:none;color:var(--dark-text);transition:.2s" class="mashq-tile">
                <div style="font-size:1.8rem;margin-bottom:.4rem">🔷</div>
                <div style="font-weight:600;font-size:.9rem">Harf Shakllari</div>
                <div style="font-size:.75rem;color:var(--mid-text);margin-top:2px">4 shaklni farqlash</div>
            </a>
            <a href="<?= Url::to(['/mashq/talaffuz']) ?>" style="min-width:150px;flex:1;max-width:200px;text-align:center;background:var(--card-bg);border:1.5px solid rgba(201,168,76,.35);border-radius:14px;padding:1.25rem .75rem;text-decoration:none;color:var(--dark-text);transition:.2s" class="mashq-tile">
                <div style="font-size:1.8rem;margin-bottom:.4rem">🎙️</div>
                <div style="font-weight:600;font-size:.9rem">Talaffuz</div>
                <div style="font-size:.75rem;color:var(--mid-text);margin-top:2px">Ismini aniqlash</div>
            </a>
            <a href="<?= Url::to(['/mashq/boglash']) ?>" style="min-width:150px;flex:1;max-width:200px;text-align:center;background:var(--card-bg);border:1.5px solid rgba(201,168,76,.35);border-radius:14px;padding:1.25rem .75rem;text-decoration:none;color:var(--dark-text);transition:.2s" class="mashq-tile">
                <div style="font-size:1.8rem;margin-bottom:.4rem">🔗</div>
                <div style="font-weight:600;font-size:.9rem">Bog'lanish</div>
                <div style="font-size:.75rem;color:var(--mid-text);margin-top:2px">Qanday birikadi</div>
            </a>
            <a href="<?= Url::to(['/mashq/soz-test']) ?>" style="min-width:150px;flex:1;max-width:200px;text-align:center;background:var(--card-bg);border:1.5px solid rgba(201,168,76,.35);border-radius:14px;padding:1.25rem .75rem;text-decoration:none;color:var(--dark-text);transition:.2s" class="mashq-tile">
                <div style="font-size:1.8rem;margin-bottom:.4rem">📝</div>
                <div style="font-weight:600;font-size:.9rem">So'z Mashqi</div>
                <div style="font-size:.75rem;color:var(--mid-text);margin-top:2px">So'z va ma'nolar</div>
            </a>
        </div>
    </div>
</div>
<style>
.mashq-tile:hover{border-color:var(--gold)!important;background:rgba(201,168,76,.06)!important;transform:translateY(-2px);box-shadow:0 4px 12px rgba(201,168,76,.15)}
</style>
