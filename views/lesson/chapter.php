<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = "Bob {$ch->number}: " . $ch->title_uz;
?>
<div class="container py-section" style="max-width:780px">
    <a href="<?= Url::to(['/darslar']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:0.85rem">
        <i class="fas fa-arrow-left mr-1"></i> Barcha boblar
    </a>
    <div class="section-header mt-2 text-left" style="padding-top:1rem">
        <span class="chapter-number">Bob <?= $ch->number ?></span>
        <h2><?= Html::encode($ch->title_uz) ?></h2>
        <p><?= Html::encode($ch->description_uz ?? '') ?></p>
        <div class="gold-underline" style="margin-left:0"></div>
    </div>

    <?php if (!empty($lessons)): ?>
    <?php
        $done = 0;
        foreach ($lessons as $l) if (isset($completed[$l->id])) $done++;
        $pct = count($lessons) ? round($done / count($lessons) * 100) : 0;
    ?>
    <div class="mb-3">
        <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:6px;color:var(--mid-text)">
            <span><?= $done ?>/<?= count($lessons) ?> dars yakunlandi</span>
            <span><?= $pct ?>%</span>
        </div>
        <div class="progress-muallim"><div class="bar" style="width:<?= $pct ?>%"></div></div>
    </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($lessons as $l): ?>
        <div class="col-12 mb-2">
            <a href="<?= Url::to(['/dars/' . $l->id]) ?>"
               style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1rem;border-radius:12px;border:1px solid var(--border);background:var(--card-bg);text-decoration:none;color:var(--dark-text);transition:all 0.15s"
               onmouseover="this.style.borderColor='var(--gold)';this.style.transform='translateX(4px)'"
               onmouseout="this.style.borderColor='var(--border)';this.style.transform='translateX(0)'">
                <span style="width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.82rem;font-weight:700;flex-shrink:0;<?= isset($completed[$l->id]) ? 'background:var(--green-deep);color:var(--gold)' : 'background:var(--parchment-dark);color:var(--mid-text)' ?>">
                    <?= isset($completed[$l->id]) ? '<i class="fas fa-check"></i>' : $l->number ?>
                </span>
                <div class="flex-grow-1">
                    <div style="font-weight:600"><?= Html::encode($l->title_uz) ?></div>
                    <?php if ($l->arabic_text): ?>
                    <div style="font-family:var(--arabic-font);font-size:0.95rem;color:var(--green-deep);direction:rtl"><?= mb_substr($l->arabic_text, 0, 30) ?>...</div>
                    <?php endif; ?>
                </div>
                <span style="background:rgba(201,168,76,0.15);color:var(--gold-dark);padding:2px 10px;border-radius:10px;font-size:0.72rem;font-weight:600;flex-shrink:0">
                    +<?= $l->xp_reward ?> XP
                </span>
                <i class="fas fa-chevron-right" style="color:var(--border);font-size:0.8rem;flex-shrink:0"></i>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
