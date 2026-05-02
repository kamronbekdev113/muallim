<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Tajvidli Mushaf';
?>
<div class="container py-section">
    <div class="section-header">
        <h2>📖 Tajvidli Mushaf</h2>
        <p>Rangli tajvid belgilari bilan — 114 sura</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Legend -->
    <div class="tajweed-legend justify-content-center mb-4">
        <span class="legend-item"><span class="legend-dot qalqala"></span>Qalqala</span>
        <span class="legend-item"><span class="legend-dot ghunna"></span>Ghunna</span>
        <span class="legend-item"><span class="legend-dot madd"></span>Madd</span>
        <span class="legend-item"><span class="legend-dot ikhfa"></span>Ikhfa</span>
        <span class="legend-item"><span class="legend-dot idgham"></span>Idgham</span>
        <span class="legend-item"><span class="legend-dot iqlab"></span>Iqlab</span>
    </div>

    <!-- Search -->
    <div class="mb-4" style="max-width:400px;margin:0 auto">
        <input type="text" id="surahSearch" class="form-control-muallim" placeholder="Sura nomini qidiring...">
    </div>

    <div id="surahList">
        <?php foreach ($surahs as $s): ?>
        <a href="<?= Url::to(['/mushaf/' . $s->number]) ?>" class="surah-item" data-name="<?= strtolower($s->name_uz) ?>">
            <div class="surah-num"><?= $s->number ?></div>
            <div>
                <div class="surah-name-ar"><?= $s->name_ar ?></div>
                <div class="surah-name-uz"><?= Html::encode($s->name_uz) ?></div>
            </div>
            <div class="surah-ayahs">
                <?= $s->ayah_count ?> oyat
                <span class="ml-2 badge <?= $s->revelation_type === 'makki' ? 'badge-makki' : 'badge-madani' ?>">
                    <?= $s->revelation_type === 'makki' ? 'Makki' : 'Madani' ?>
                </span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.getElementById('surahSearch').addEventListener('input', function() {
    var q = this.value.toLowerCase();
    document.querySelectorAll('.surah-item').forEach(function(el) {
        el.style.display = el.dataset.name.includes(q) ? '' : 'none';
    });
});
</script>
