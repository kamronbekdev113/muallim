<?php use yii\helpers\Html; use yii\helpers\Url; ?>
<div class="admin-card">
    <div class="admin-card-header">
        <span><i class="fas fa-book-open mr-2"></i>Darslar (<?= count($models) ?>)</span>
        <a href="<?= Url::to(['/admin/lesson/create']) ?>" class="btn-save">+ Qo'shish</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table">
            <thead><tr><th>Bob</th><th>#</th><th>Sarlavha</th><th>Arab matni</th><th>XP</th><th>Holat</th><th>Amallar</th></tr></thead>
            <tbody>
                <?php foreach ($models as $m): ?>
                <tr>
                    <td style="font-size:0.78rem"><?= Html::encode($m->chapter->title_uz ?? '-') ?></td>
                    <td><?= $m->number ?></td>
                    <td><?= Html::encode($m->title_uz) ?></td>
                    <td class="arabic-cell"><?= mb_substr($m->arabic_text ?? '', 0, 20) ?>...</td>
                    <td><?= $m->xp_reward ?></td>
                    <td><span class="<?= $m->active ? 'badge-active' : 'badge-inactive' ?>"><?= $m->active ? 'Faol' : 'Nofaol' ?></span></td>
                    <td>
                        <a href="<?= Url::to(['/admin/lesson/update', 'id' => $m->id]) ?>" class="btn-action btn-edit">Tahrirlash</a>
                        <a href="<?= Url::to(['/admin/lesson/delete', 'id' => $m->id]) ?>" class="btn-action btn-delete" data-method="post" data-confirm="O'chirilsinmi?">O'chirish</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
