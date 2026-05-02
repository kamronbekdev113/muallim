<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $s->name_uz . ' — ' . $s->name_ar;

function arabicNum($n) {
    return strtr((string)$n, ['0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩']);
}
?>
<div class="container py-4" style="max-width:820px">

    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap" style="gap:.5rem">
        <a href="<?= Url::to(['/mushaf']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:.85rem">
            <i class="fas fa-arrow-left mr-1"></i> Barcha suralar
        </a>
        <div class="tajweed-legend" style="margin:0;font-size:.75rem">
            <span class="legend-item"><span class="legend-dot" style="background:#B8860B"></span>Qalqala</span>
            <span class="legend-item"><span class="legend-dot" style="background:#155724"></span>Ghunna</span>
            <span class="legend-item"><span class="legend-dot" style="background:#003087"></span>Madd</span>
            <span class="legend-item"><span class="legend-dot" style="background:#4a0080"></span>Idgham</span>
            <span class="legend-item"><span class="legend-dot" style="background:#855103"></span>Ikhfa</span>
            <span class="legend-item"><span class="legend-dot" style="background:#8b0000"></span>Iqlab</span>
        </div>
    </div>

    <div class="mushaf-wrapper">
        <!-- Surah header -->
        <div style="text-align:center;margin-bottom:1.5rem;padding-bottom:1.5rem;border-bottom:2px solid var(--gold-light,#e8c97a)">
            <div style="font-family:var(--arabic-font);font-size:2.5rem;color:var(--green-deep);line-height:1.4"><?= $s->name_ar ?></div>
            <div style="font-size:1.05rem;font-weight:700;color:var(--dark-text);margin-top:4px"><?= Html::encode($s->name_uz) ?></div>
            <div style="font-size:.82rem;color:var(--mid-text);margin-top:3px">
                <?= arabicNum($s->ayah_count) ?> oyat
                <span class="badge <?= $s->revelation_type==='makki'?'badge-makki':'badge-madani' ?> ml-2">
                    <?= $s->revelation_type==='makki'?'Makki':'Madani' ?>
                </span>
            </div>
        </div>

        <?php if ($s->bismillah_pre && $s->number !== 1): ?>
        <div class="mushaf-bismillah" style="font-size:1.8rem;font-family:var(--quran-font,var(--arabic-font))">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
        <?php endif; ?>

        <?php if (empty($ayahs)): ?>
        <div style="text-align:center;padding:3rem;color:var(--mid-text)">
            <i class="fas fa-spinner fa-spin fa-2x mb-2"></i>
            <p>Oyatlar yuklanmoqda... Iltimos <code>php yii quran/fetch</code> buyrug'ini ishlatib qayta kiring.</p>
        </div>
        <?php else: ?>

        <?php foreach ($ayahs as $ayah): ?>
        <div class="ayah-row" style="border-bottom:1px solid rgba(201,168,76,.15);padding:1rem 0">

            <!-- Arabcha (tajvidli) matn -->
            <div class="ayah-text" style="font-size:1.8rem;line-height:2.2;padding:.25rem .75rem;font-family:var(--quran-font,var(--arabic-font))">
                <?php if ($ayah->text_tajweed): ?>
                    <?= $ayah->text_tajweed ?>
                <?php else: ?>
                    <?= Html::encode($ayah->text_uthmani) ?>
                    <span class="end"><?= arabicNum($ayah->number) ?></span>
                <?php endif; ?>
            </div>

            <!-- Transliteratsiya -->
            <?php if ($ayah->transliteration): ?>
            <div style="font-size:1rem;color:var(--mid-text);padding:.35rem .75rem .1rem;direction:ltr;text-align:left;font-style:italic;line-height:1.7">
                <?= Html::encode($ayah->transliteration) ?>
            </div>
            <?php endif; ?>

            <!-- Tarjima -->
            <?php if ($ayah->translation_uz): ?>
            <div class="ayah-translation" style="font-size:.95rem;padding:.4rem .75rem .25rem">
                <span style="color:var(--gold-dark);font-weight:700;margin-right:5px"><?= arabicNum($ayah->number) ?>.</span>
                <?= Html::encode($ayah->translation_uz) ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <?php endif; ?>
    </div>

    <!-- Nav -->
    <div class="lesson-nav mt-3">
        <?php if ($prev): ?>
        <a href="<?= Url::to(['/mushaf/'.$prev->number]) ?>" class="btn-muallim-outline">
            <i class="fas fa-arrow-left mr-1"></i> <?= Html::encode($prev->name_uz) ?>
        </a>
        <?php else: ?><span></span><?php endif; ?>
        <?php if ($next): ?>
        <a href="<?= Url::to(['/mushaf/'.$next->number]) ?>" class="btn-muallim">
            <?= Html::encode($next->name_uz) ?> <i class="fas fa-arrow-right ml-1"></i>
        </a>
        <?php endif; ?>
    </div>
</div>
