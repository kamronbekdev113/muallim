<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Harf Flashcard Mashqi';
?>
<div class="container" style="max-width:600px;padding-top:2rem;padding-bottom:3rem">
    <a href="<?= Url::to(['/alifbo']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:0.85rem">
        <i class="fas fa-arrow-left mr-1"></i> Alifboga qaytish
    </a>
    <div class="section-header mt-2">
        <h2>🔤 Harf Flashcard</h2>
        <p>Kartani bosing — yoki Space tugmasi bilan ag'daring</p>
        <div class="gold-underline"></div>
    </div>

    <!-- Hidden data -->
    <?php foreach ($letters as $i => $l): ?>
    <span class="fc-card-data d-none"
          data-arabic="<?= htmlspecialchars($l->letter) ?>"
          data-name="<?= htmlspecialchars($l->name_uz) ?>"
          data-trans="<?= htmlspecialchars($l->transliteration) ?>"></span>
    <?php endforeach; ?>

    <!-- Counter -->
    <div class="text-center mb-3" style="font-size:0.85rem;color:var(--mid-text)">
        <span id="fc-counter">1 / <?= count($letters) ?></span>
    </div>

    <!-- Flashcard -->
    <div class="flashcard-scene">
        <div class="flashcard">
            <div class="flashcard-face flashcard-front">
                <div class="fc-arabic flashcard-arabic"><?= $letters[0]->letter ?? '' ?></div>
                <div class="flashcard-hint">Bosing yoki Space bilan ag'daring</div>
            </div>
            <div class="flashcard-face flashcard-back">
                <div class="fc-name" style="font-size:1.4rem;font-weight:700;color:#fff;margin-bottom:0.25rem">
                    <?= Html::encode($letters[0]->name_uz ?? '') ?>
                </div>
                <div class="fc-trans" style="font-size:1.1rem;color:var(--gold)">
                    <?= Html::encode($letters[0]->transliteration ?? '') ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <div class="d-flex justify-content-center mt-4" style="gap:1rem">
        <button onclick="fcGo(-1)" class="btn-muallim-outline fc-prev-btn">
            <i class="fas fa-arrow-left"></i>
        </button>
        <button onclick="document.querySelector('.flashcard').classList.toggle('flipped')"
                class="btn-gold-fill">
            <i class="fas fa-sync-alt"></i> Ag'darish
        </button>
        <button onclick="fcGo(1)" class="btn-muallim fc-next-btn">
            <i class="fas fa-arrow-right"></i>
        </button>
    </div>
    <div class="text-center mt-2" style="font-size:0.72rem;color:var(--light-text)">
        ← → klavishlar bilan ham boshqarishingiz mumkin
    </div>
</div>
