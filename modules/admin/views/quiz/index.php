<?php use yii\helpers\Html; use yii\helpers\Url; ?>
<div class="admin-card">
    <div class="admin-card-header">
        <span>Testlar (<?= count($models) ?>)</span>
        <a href="<?= Url::to(['/admin/quiz/create']) ?>" class="btn-save">+ Qo'shish</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table">
            <thead><tr><th>Savol</th><th>Turi</th><th>XP</th><th>Variantlar</th><th>Faol</th><th>Amallar</th></tr></thead>
            <tbody>
                <?php foreach ($models as $m): ?>
                <tr>
                    <td><?= Html::encode(mb_substr($m->question_uz, 0, 60)) ?>...</td>
                    <td><?= $m->type ?></td>
                    <td><?= $m->xp_reward ?></td>
                    <td><?= count($m->options) ?></td>
                    <td><span class="<?= $m->active ? 'badge-active' : 'badge-inactive' ?>"><?= $m->active ? 'Ha' : "Yo'q" ?></span></td>
                    <td>
                        <a href="<?= Url::to(['/admin/quiz/update', 'id' => $m->id]) ?>" class="btn-action btn-edit">Tahrirlash</a>
                        <a href="<?= Url::to(['/admin/quiz/delete', 'id' => $m->id]) ?>" class="btn-action btn-delete" data-method="post" data-confirm="O'chirilsinmi?">O'chirish</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
