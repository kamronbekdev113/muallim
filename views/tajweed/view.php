<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = $rule->name_uz;
?>
<div class="container" style="max-width:780px;padding-top:2rem;padding-bottom:3rem">
    <a href="<?= Url::to(['/tajvid']) ?>" style="color:var(--mid-text);text-decoration:none;font-size:0.85rem">
        <i class="fas fa-arrow-left mr-1"></i> Tajvid qoidalariga qaytish
    </a>
    <div class="muallim-card mt-3">
        <div class="d-flex align-items-center mb-3" style="gap:1rem">
            <div style="width:50px;height:50px;border-radius:50%;background:<?= $rule->color_code ?>;opacity:0.8;flex-shrink:0;box-shadow:0 4px 14px rgba(0,0,0,0.15)"></div>
            <div>
                <h2 style="margin:0;font-weight:800"><?= Html::encode($rule->name_uz) ?></h2>
                <div style="font-family:var(--arabic-font);font-size:1.4rem;color:var(--green-deep)"><?= Html::encode($rule->name_ar) ?></div>
            </div>
            <span style="margin-left:auto;padding:4px 14px;border-radius:20px;font-size:0.8rem;font-weight:700;border:2px solid <?= $rule->color_code ?>;color:<?= $rule->color_code ?>">
                <?= Html::encode($rule->getCategoryLabel()) ?>
            </span>
        </div>
        <p style="color:var(--dark-text);font-size:1rem;line-height:1.8"><?= Html::encode($rule->description_uz) ?></p>
    </div>

    <?php if ($rule->example_ar): ?>
    <div class="muallim-card mt-3">
        <h6 style="font-weight:700;color:var(--mid-text);text-transform:uppercase;font-size:0.75rem;letter-spacing:0.08em;margin-bottom:1rem">MISOL</h6>
        <div class="mushaf-wrapper" style="padding:1.5rem">
            <div class="ayah-text" style="direction:rtl;font-size:1.6rem;line-height:2.4">
                <?= $rule->example_ar ?>
            </div>
            <?php if ($rule->example_translation): ?>
            <div class="ayah-translation"><?= Html::encode($rule->example_translation) ?></div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="lesson-nav">
        <?php if ($prev): ?>
        <a href="<?= Url::to(['/tajvid/' . $prev->id]) ?>" class="btn-muallim-outline">
            <i class="fas fa-arrow-left mr-1"></i> <?= Html::encode($prev->name_uz) ?>
        </a>
        <?php else: ?><span></span><?php endif; ?>
        <?php if ($next): ?>
        <a href="<?= Url::to(['/tajvid/' . $next->id]) ?>" class="btn-muallim">
            <?= Html::encode($next->name_uz) ?> <i class="fas fa-arrow-right ml-1"></i>
        </a>
        <?php endif; ?>
    </div>
</div>
