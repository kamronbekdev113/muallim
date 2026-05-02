<?php use yii\helpers\Html; use yii\helpers\Url; ?>
<div class="row mb-4">
    <?php
    $tiles = [
        ['Foydalanuvchilar', $stats['users'],   'fas fa-users',          '#1B4332', '/admin/user'],
        ['Harflar',          $stats['letters'], 'fas fa-font',           '#C9A84C', '/admin/letter'],
        ['Darslar',          $stats['lessons'], 'fas fa-book-open',      '#2D6A4F', '/admin/lesson'],
        ['Tajvid',           $stats['tajweed'], 'fas fa-star-and-crescent','#8B5E3C','/admin/tajweed'],
        ['Suralar',          $stats['surahs'],  'fas fa-quran',          '#1B4332', '/admin/surah'],
        ['Testlar',          $stats['quizzes'], 'fas fa-question-circle','#C9A84C', '/admin/quiz'],
    ];
    foreach ($tiles as $t): ?>
    <div class="col-6 col-md-4 col-lg-2 mb-3">
        <a href="<?= $t[4] ?>" class="stat-mini d-block text-decoration-none">
            <i class="<?= $t[2] ?> fa-2x mb-2" style="color:<?= $t[3] ?>"></i>
            <div class="stat-mini-num"><?= $t[1] ?></div>
            <div class="stat-mini-label"><?= $t[0] ?></div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <span><i class="fas fa-users mr-2"></i>So'nggi foydalanuvchilar</span>
        <a href="<?= Url::to(['/admin/user']) ?>" style="font-size:0.8rem;color:var(--green-mid)">Barchasi</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table">
            <thead>
                <tr><th>Foydalanuvchi</th><th>Rol</th><th>XP</th><th>Ro'yxat</th></tr>
            </thead>
            <tbody>
                <?php foreach ($recentUsers as $u): ?>
                <tr>
                    <td><?= Html::encode($u->username) ?> <span style="color:#888;font-size:0.8rem"><?= Html::encode($u->full_name) ?></span></td>
                    <td><span class="<?= $u->role === 'admin' ? 'badge-active' : 'badge-inactive' ?>"><?= $u->role ?></span></td>
                    <td><?= $u->xp ?></td>
                    <td style="font-size:0.8rem"><?= date('d.m.Y', $u->created_at) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
