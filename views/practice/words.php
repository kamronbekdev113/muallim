<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = "So'z Flashcard";
?>
<div class="container" style="max-width:600px;padding-top:2rem;padding-bottom:3rem">
    <a href="<?= Url::to(['/']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:0.85rem">
        <i class="fas fa-arrow-left mr-1"></i> Orqaga
    </a>
    <div class="section-header mt-2">
        <h2>📖 So'z Mashqi</h2>
        <p>Kartani bosing — yoki Space bilan ag'daring</p>
        <div class="gold-underline"></div>
    </div>

    <?php foreach ($words as $i => $w): ?>
    <span class="fc-card-data d-none"
          data-arabic="<?= htmlspecialchars($w->word_ar) ?>"
          data-name="<?= htmlspecialchars($w->translation_uz) ?>"
          data-trans="<?= htmlspecialchars($w->transliteration) ?>"></span>
    <?php endforeach; ?>

    <div class="text-center mb-3" style="font-size:0.85rem;color:var(--mid-text)">
        <span id="fc-counter">1 / <?= count($words) ?></span>
    </div>

    <div class="flashcard-scene">
        <div class="flashcard">
            <div class="flashcard-face flashcard-front">
                <div class="fc-arabic flashcard-arabic"><?= $words[0]->word_ar ?? '' ?></div>
                <div style="font-size:0.78rem;color:var(--light-text);margin-top:4px"><?= Html::encode($words[0]->transliteration ?? '') ?></div>
                <div class="flashcard-hint">Bosing yoki Space</div>
            </div>
            <div class="flashcard-face flashcard-back">
                <div class="fc-name" style="font-size:1.5rem;font-weight:700;color:#fff"><?= Html::encode($words[0]->translation_uz ?? '') ?></div>
                <div class="fc-trans" style="font-size:0.9rem;color:rgba(255,255,255,0.7)">[ <?= Html::encode($words[0]->transliteration ?? '') ?> ]</div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4" style="gap:1rem">
        <button onclick="fcGo(-1)" class="btn-muallim-outline fc-prev-btn"><i class="fas fa-arrow-left"></i></button>
        <button onclick="document.querySelector('.flashcard').classList.toggle('flipped')" class="btn-gold-fill">
            <i class="fas fa-sync-alt"></i>
        </button>
        <button onclick="fcGo(1)" class="btn-muallim fc-next-btn"><i class="fas fa-arrow-right"></i></button>
    </div>
</div>
