<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = "Muallimi Soniy Darslari";
?>
<div class="container py-section">
    <div class="section-header">
        <h2>📚 Muallimi Soniy</h2>
        <p>Arab tilini 0'dan o'rganishning an'anaviy yo'li — 8 bob, 40+ dars</p>
        <div class="gold-underline"></div>
    </div>

    <?php foreach ($chapters as $ch): ?>
    <?php
        $lessons = $ch->getLessons()->all();
        $done = 0;
        foreach ($lessons as $l) { if (isset($completed[$l->id])) $done++; }
        $pct = count($lessons) ? round($done / count($lessons) * 100) : 0;
    ?>
    <div class="muallim-card mb-3">
        <div class="d-flex align-items-start" style="gap:1rem;flex-wrap:wrap">
            <div class="chapter-icon" style="margin-top:2px">
                <i class="fas fa-<?= htmlspecialchars($ch->icon ?? 'book') ?>"></i>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex align-items-center" style="gap:0.5rem;flex-wrap:wrap;margin-bottom:0.3rem">
                    <span class="chapter-number">Bob <?= $ch->number ?></span>
                    <h5 style="margin:0;font-weight:700"><?= Html::encode($ch->title_uz) ?></h5>
                    <?php if ($done > 0): ?>
                    <span style="background:var(--green-deep);color:var(--gold);padding:2px 10px;border-radius:10px;font-size:0.72rem;font-weight:600">
                        <?= $done ?>/<?= count($lessons) ?>
                    </span>
                    <?php endif; ?>
                </div>
                <p style="color:var(--mid-text);font-size:0.85rem;margin-bottom:0.75rem"><?= Html::encode($ch->description_uz ?? '') ?></p>
                <?php if (!empty($lessons)): ?>
                <div class="progress-muallim mb-3" style="max-width:300px">
                    <div class="bar" style="width:<?= $pct ?>%"></div>
                </div>
                <div class="row">
                    <?php foreach ($lessons as $l): ?>
                    <div class="col-12 col-md-6 mb-2">
                        <a href="<?= Url::to(['/dars/' . $l->id]) ?>"
                           style="display:flex;align-items:center;gap:0.6rem;padding:0.5rem 0.75rem;border-radius:8px;border:1px solid var(--border);background:var(--parchment);text-decoration:none;color:var(--dark-text);transition:all 0.15s"
                           onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">
                            <span style="width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;flex-shrink:0;<?= isset($completed[$l->id]) ? 'background:var(--green-deep);color:var(--gold)' : 'background:var(--parchment-dark);color:var(--mid-text)' ?>">
                                <?= isset($completed[$l->id]) ? '<i class="fas fa-check"></i>' : $l->number ?>
                            </span>
                            <span style="font-size:0.83rem;font-weight:500"><?= Html::encode($l->title_uz) ?></span>
                            <span style="margin-left:auto;font-size:0.7rem;color:var(--gold)">+<?= $l->xp_reward ?> XP</span>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
