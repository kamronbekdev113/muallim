<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $letter->name_uz . ' — ' . $letter->letter;
?>
<div class="container" style="max-width:780px;padding-top:2rem;padding-bottom:3rem">
    <!-- Back -->
    <a href="<?= Url::to(['/alifbo']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:0.85rem">
        <i class="fas fa-arrow-left mr-1"></i> Alifboga qaytish
    </a>

    <!-- Hero -->
    <div class="letter-hero mt-3">
        <div class="letter-display"><?= $letter->letter ?></div>
        <div class="letter-transliteration">[ <?= Html::encode($letter->transliteration) ?> ]</div>
        <div style="color:rgba(255,255,255,0.8);font-size:1.1rem;margin-top:0.5rem;font-weight:500"><?= Html::encode($letter->name_uz) ?></div>
        <button class="tts-btn mt-3"
                data-text="<?= htmlspecialchars($letter->letter) ?>"
                data-lang="ar-SA"
                style="background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.3);color:#fff">
            <i class="fas fa-volume-up mr-1"></i> Eshitish
        </button>
    </div>

    <!-- 4 Forms -->
    <div class="muallim-card">
        <div class="card-ornament">م</div>
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:1rem">HARF SHAKLLARI</h6>
        <div class="letter-forms-grid">
            <?php
            $forms = [
                ['Yakka', $letter->isolated, 'So\'z tashqarida'],
                ['Boshida', $letter->initial, 'So\'z boshida'],
                ["O'rtada", $letter->medial, "So'z o'rtasida"],
                ['Oxirida', $letter->final, 'So\'z oxirida'],
            ];
            foreach ($forms as $f): ?>
            <div class="letter-form-item">
                <div class="form-label-small"><?= $f[0] ?></div>
                <div class="form-arabic-text"><?= $f[1] ?></div>
                <div style="font-size:0.65rem;color:var(--light-text);margin-top:2px"><?= $f[2] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Pronunciation Note -->
    <?php if ($letter->pronunciation_note): ?>
    <div class="muallim-card mt-3">
        <div class="card-ornament">📢</div>
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:0.75rem">TALAFFUZ</h6>
        <p style="color:var(--dark-text)"><?= Html::encode($letter->pronunciation_note) ?></p>
    </div>
    <?php endif; ?>

    <!-- Examples -->
    <?php $examples = $letter->getExamples(); if ($examples): ?>
    <div class="muallim-card mt-3">
        <div class="card-ornament">م</div>
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:1rem">MISOLLAR</h6>
        <div class="row">
            <?php foreach ($examples as $ex): ?>
            <div class="col-6 mb-2">
                <div style="background:var(--parchment);border:1px solid var(--border);border-radius:10px;padding:0.75rem;text-align:center">
                    <div style="font-family:var(--arabic-font);font-size:1.8rem;color:var(--green-deep);direction:rtl">
                        <?= $ex['word'] ?>
                    </div>
                    <div style="font-size:0.78rem;color:var(--mid-text);margin-top:4px"><?= Html::encode($ex['meaning']) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Nav -->
    <div class="lesson-nav">
        <?php if ($prev): ?>
        <a href="<?= Url::to(['/alifbo/' . $prev->id]) ?>" class="btn-muallim-outline">
            <i class="fas fa-arrow-left mr-1"></i> <?= $prev->letter ?> (<?= Html::encode($prev->name_uz) ?>)
        </a>
        <?php else: ?><span></span><?php endif; ?>
        <?php if ($next): ?>
        <a href="<?= Url::to(['/alifbo/' . $next->id]) ?>" class="btn-muallim">
            <?= $next->letter ?> (<?= Html::encode($next->name_uz) ?>) <i class="fas fa-arrow-right ml-1"></i>
        </a>
        <?php endif; ?>
    </div>
</div>
