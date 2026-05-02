<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Tajvid Qoidalari';
?>
<div class="container py-section">
    <div class="section-header">
        <h2>🌟 Tajvid Qoidalari</h2>
        <p>Quronni to'g'ri o'qish uchun zarur 12 asosiy qoida</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Color Legend -->
    <div class="tajweed-legend justify-content-center mb-4">
        <span class="legend-item"><span class="legend-dot qalqala"></span>Qalqala</span>
        <span class="legend-item"><span class="legend-dot ghunna"></span>Ghunna</span>
        <span class="legend-item"><span class="legend-dot madd"></span>Madd</span>
        <span class="legend-item"><span class="legend-dot ikhfa"></span>Ikhfa</span>
        <span class="legend-item"><span class="legend-dot idgham"></span>Idgham</span>
        <span class="legend-item"><span class="legend-dot iqlab"></span>Iqlab</span>
        <span class="legend-item"><span class="legend-dot izhar"></span>Izhar</span>
    </div>

    <?php foreach ($grouped as $category => $categoryRules): ?>
    <h5 style="color:var(--green-deep);font-weight:700;margin:2rem 0 1rem;padding-bottom:0.5rem;border-bottom:2px solid var(--border)">
        <?= Html::encode($category) ?>
    </h5>
    <div class="row">
        <?php foreach ($categoryRules as $rule): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <a href="<?= Url::to(['/tajvid/' . $rule->id]) ?>" class="tajweed-card h-100">
                <div class="d-flex align-items-center mb-2" style="gap:0.75rem">
                    <div class="tajweed-color-dot" style="background:<?= $rule->color_code ?>"></div>
                    <div>
                        <div style="font-weight:700;font-size:0.95rem"><?= Html::encode($rule->name_uz) ?></div>
                        <div class="tajweed-arabic" style="font-size:1.1rem;color:var(--green-deep)"><?= Html::encode($rule->name_ar) ?></div>
                    </div>
                </div>
                <p style="font-size:0.82rem;color:var(--mid-text);margin:0"><?= Html::encode(mb_substr($rule->description_uz, 0, 100)) ?>...</p>
                <?php if ($rule->example_ar): ?>
                <div style="margin-top:0.75rem;padding:0.5rem;background:var(--parchment);border-radius:8px;text-align:right;font-family:var(--arabic-font);font-size:1.1rem;direction:rtl">
                    <?= $rule->example_ar ?>
                </div>
                <?php endif; ?>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>

    <div class="text-center mt-4">
        <a href="<?= Url::to(['/mushaf/1']) ?>" class="btn-muallim">
            <i class="fas fa-quran mr-1"></i> Tajvidli mushafda ko'rish
        </a>
    </div>
</div>
