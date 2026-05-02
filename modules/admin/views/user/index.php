<?php use yii\helpers\Html; use yii\helpers\Url; ?>
<div class="admin-card">
    <div class="admin-card-header">
        <span><i class="fas fa-users mr-2"></i>Foydalanuvchilar (<?= count($models) ?>)</span>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table">
            <thead><tr><th>Username</th><th>To'liq ism</th><th>Rol</th><th>XP</th><th>Seriya</th><th>Ro'yxat</th><th>Amallar</th></tr></thead>
            <tbody>
                <?php foreach ($models as $m): ?>
                <tr>
                    <td><strong><?= Html::encode($m->username) ?></strong></td>
                    <td><?= Html::encode($m->full_name) ?></td>
                    <td><span class="<?= $m->role === 'admin' ? 'badge-active' : 'badge-inactive' ?>"><?= $m->role ?></span></td>
                    <td><?= $m->xp ?></td>
                    <td><?= $m->streak ?> 🔥</td>
                    <td style="font-size:0.78rem"><?= date('d.m.Y', $m->created_at) ?></td>
                    <td>
                        <a href="<?= Url::to(['/admin/user/toggle-role', 'id' => $m->id]) ?>" class="btn-action btn-edit" data-method="post">
                            <?= $m->role === 'admin' ? 'Student qil' : 'Admin qil' ?>
                        </a>
                        <?php if ($m->id !== Yii::$app->user->id): ?>
                        <a href="<?= Url::to(['/admin/user/delete', 'id' => $m->id]) ?>" class="btn-action btn-delete" data-method="post" data-confirm="O'chirilsinmi?">O'chirish</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
