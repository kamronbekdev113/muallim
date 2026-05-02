<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Mening Profilim';
$levelInfo = $user->getLevelInfo();
$nextLevel = $user->getNextLevel();
?>
<div class="container" style="max-width:800px;padding-top:2rem;padding-bottom:3rem">
    <!-- Profile Header -->
    <div class="profile-header arabesque-bg">
        <div class="profile-avatar"><?= mb_strtoupper(mb_substr($user->username, 0, 1)) ?></div>
        <h3 style="margin:0;color:#fff"><?= Html::encode($user->full_name ?: $user->username) ?></h3>
        <div style="color:rgba(255,255,255,0.6);font-size:0.85rem">@<?= Html::encode($user->username) ?></div>
        <div class="profile-level" style="color:<?= $levelInfo['color'] ?>;border-color:<?= $levelInfo['color'] ?>">
            <?= Html::encode($levelInfo['name']) ?>
        </div>
        <div style="font-size:1.6rem;font-weight:800;color:#fff;margin:0.5rem 0"><?= $user->xp ?> XP</div>
        <div class="xp-progress-bar-wrap" style="max-width:300px;margin:0 auto">
            <div class="xp-progress-bar-fill" style="width:<?= $user->getLevelProgress() ?>%;background:<?= $levelInfo['color'] ?>"></div>
        </div>
        <?php if ($nextLevel): ?>
        <div style="font-size:0.72rem;color:rgba(255,255,255,0.55);margin-top:0.4rem">
            <?= $user->xp ?> / <?= $nextLevel['min_xp'] ?> XP — <strong style="color:rgba(255,255,255,0.8)"><?= $nextLevel['name'] ?></strong>
        </div>
        <?php endif; ?>
    </div>

    <!-- Stats -->
    <div class="row mt-3">
        <div class="col-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number streak-flame">🔥 <?= $user->streak ?></div>
                <div class="stat-label">Kun seriyasi</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number"><?= $completedLessons ?></div>
                <div class="stat-label">Dars yakunlandi</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number"><?= $completedLetters ?></div>
                <div class="stat-label">Harf o'rganildi</div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="stat-card">
                <div class="stat-number"><?= $totalQuizzes > 0 ? round($correctQuizzes / $totalQuizzes * 100) : 0 ?>%</div>
                <div class="stat-label">Test to'g'riligi</div>
            </div>
        </div>
    </div>

    <!-- Chapter Progress -->
    <div class="muallim-card mt-3">
        <div class="card-ornament">م</div>
        <h6 style="font-weight:700;color:var(--dark-text);margin-bottom:1.25rem">Muallimi Soniy — Progress</h6>
        <?php foreach ($chapters as $ch): ?>
        <?php
            $total = \app\models\MuallimiLesson::find()->where(['chapter_id' => $ch->id])->count();
            $done  = \app\models\UserProgress::find()->where([
                'user_id' => $user->id, 'content_type' => 'lesson', 'completed' => 1
            ])->andWhere(['in', 'content_id',
                \app\models\MuallimiLesson::find()->select('id')->where(['chapter_id' => $ch->id])->column()
            ])->count();
            $pct = $total ? round($done / $total * 100) : 0;
        ?>
        <div class="mb-3">
            <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:4px">
                <span style="font-weight:600">Bob <?= $ch->number ?>: <?= Html::encode($ch->title_uz) ?></span>
                <span style="color:var(--mid-text)"><?= $done ?>/<?= $total ?></span>
            </div>
            <div class="progress-muallim">
                <div class="bar" style="width:<?= $pct ?>%"></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-3">
        <div class="col-md-4 mb-2">
            <a href="<?= Url::to(['/darslar']) ?>" class="muallim-card d-block text-center text-decoration-none" style="padding:1.25rem">
                <i class="fas fa-book-open fa-2x mb-2" style="color:var(--green-mid)"></i>
                <div style="font-weight:600;font-size:0.88rem">Darslarga o'tish</div>
            </a>
        </div>
        <div class="col-md-4 mb-2">
            <a href="<?= Url::to(['/mashq/harflar']) ?>" class="muallim-card d-block text-center text-decoration-none" style="padding:1.25rem">
                <i class="fas fa-sync-alt fa-2x mb-2" style="color:var(--gold-dark)"></i>
                <div style="font-weight:600;font-size:0.88rem">Harf mashqi</div>
            </a>
        </div>
        <div class="col-md-4 mb-2">
            <a href="<?= Url::to(['/mushaf']) ?>" class="muallim-card d-block text-center text-decoration-none" style="padding:1.25rem">
                <i class="fas fa-quran fa-2x mb-2" style="color:var(--green-deep)"></i>
                <div style="font-weight:600;font-size:0.88rem">Mushafni o'qish</div>
            </a>
        </div>
    </div>
</div>
