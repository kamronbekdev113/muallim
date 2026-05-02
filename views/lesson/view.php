<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $lesson->title_uz;
?>
<div class="container" style="max-width:780px;padding-top:2rem;padding-bottom:3rem">
    <!-- Breadcrumb -->
    <div style="font-size:0.82rem;color:var(--mid-text);margin-bottom:1rem">
        <a href="<?= Url::to(['/darslar']) ?>" style="color:var(--mid-text);text-decoration:none">Darslar</a>
        <i class="fas fa-chevron-right mx-2" style="font-size:0.6rem"></i>
        <a href="<?= Url::to(['/darslar/' . $lesson->chapter->number]) ?>" style="color:var(--mid-text);text-decoration:none">
            Bob <?= $lesson->chapter->number ?>
        </a>
        <i class="fas fa-chevron-right mx-2" style="font-size:0.6rem"></i>
        <span><?= Html::encode($lesson->title_uz) ?></span>
    </div>

    <!-- XP Badge if new -->
    <?php if ($isNew): ?>
    <div style="background:linear-gradient(135deg,var(--gold),var(--gold-light));color:var(--green-deep);border-radius:12px;padding:0.75rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:0.75rem;font-weight:700">
        <span style="font-size:1.5rem">⭐</span>
        <div>
            <div>Dars yakunlandi!</div>
            <div style="font-size:0.85rem;font-weight:500">+<?= $lesson->xp_reward ?> XP qo'shildi</div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Lesson header -->
    <div class="muallim-card mb-3">
        <div class="card-ornament">م</div>
        <div class="d-flex align-items-center mb-1" style="gap:0.5rem">
            <span class="chapter-number">Bob <?= $lesson->chapter->number ?> — Dars <?= $lesson->number ?></span>
            <span style="background:rgba(201,168,76,0.15);color:var(--gold-dark);border:1px solid rgba(201,168,76,0.3);padding:2px 10px;border-radius:10px;font-size:0.72rem;font-weight:600">
                +<?= $lesson->xp_reward ?> XP
            </span>
        </div>
        <h2 style="font-weight:800;color:var(--dark-text);font-size:1.6rem"><?= Html::encode($lesson->title_uz) ?></h2>
        <?php if ($lesson->content_uz): ?>
        <p style="color:var(--mid-text)"><?= Html::encode($lesson->content_uz) ?></p>
        <?php endif; ?>
    </div>

    <!-- Arabic Text -->
    <?php if ($lesson->arabic_text): ?>
    <div class="muallim-card mb-3">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 style="margin:0;font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.72rem;letter-spacing:0.08em">ARAB MATNI</h6>
            <button class="tts-btn" data-text="<?= htmlspecialchars($lesson->arabic_text) ?>" data-lang="ar-SA">
                <i class="fas fa-volume-up mr-1"></i> Eshitish
            </button>
        </div>
        <div class="lesson-arabic"><?= Html::encode($lesson->arabic_text) ?></div>
    </div>
    <?php endif; ?>

    <!-- Transliteration -->
    <?php if ($lesson->transliteration): ?>
    <div class="lesson-transliteration">
        <i class="fas fa-microphone mr-2" style="color:var(--green-mid)"></i>
        <strong>Talaffuz:</strong> <?= Html::encode($lesson->transliteration) ?>
    </div>
    <?php endif; ?>

    <!-- Translation -->
    <?php if ($lesson->translation_uz): ?>
    <div class="lesson-translation">
        <i class="fas fa-language mr-2" style="color:var(--gold-dark)"></i>
        <strong>Ma'nosi:</strong> <?= Html::encode($lesson->translation_uz) ?>
    </div>
    <?php endif; ?>

    <!-- Nav -->
    <div class="lesson-nav">
        <?php if ($prev): ?>
        <a href="<?= Url::to(['/dars/' . $prev->id]) ?>" class="btn-muallim-outline">
            <i class="fas fa-arrow-left mr-1"></i> Oldingi
        </a>
        <?php else: ?><span></span><?php endif; ?>

        <div class="d-flex" style="gap:0.75rem">
            <?php $quizzes = $lesson->getQuizzes()->count(); if ($quizzes): ?>
            <a href="<?= Url::to(['/dars/' . $lesson->id . '/test']) ?>" class="btn-gold-fill">
                <i class="fas fa-question-circle mr-1"></i> Test (<?= $quizzes ?>)
            </a>
            <?php endif; ?>
            <?php if ($next): ?>
            <a href="<?= Url::to(['/dars/' . $next->id]) ?>" class="btn-muallim">
                Keyingi <i class="fas fa-arrow-right ml-1"></i>
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
