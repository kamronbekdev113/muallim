<?php use yii\helpers\Html; use yii\helpers\Url; ?>
<div class="admin-card">
    <div class="admin-card-header">
        <span>Muallimi Boblar (<?= count($models) ?>)</span>
        <a href="<?= Url::to(['/admin/chapter/create']) ?>" class="btn-save">+ Qo'shish</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table">
            <thead><tr><th>#</th><th>Sarlavha</th><th>Tavsif</th><th>Holat</th><th>Amallar</th></tr></thead>
            <tbody>
                <?php foreach ($models as $m): ?>
                <tr>
                    <td><?= $m->number ?></td>
                    <td><?= Html::encode($m->title_uz) ?></td>
                    <td style="font-size:0.78rem"><?= Html::encode(mb_substr($m->description_uz ?? '', 0, 60)) ?>...</td>
                    <td><span class="<?= $m->active ? 'badge-active' : 'badge-inactive' ?>"><?= $m->active ? 'Faol' : 'Nofaol' ?></span></td>
                    <td>
                        <a href="<?= Url::to(['/admin/chapter/update', 'id' => $m->id]) ?>" class="btn-action btn-edit">Tahrirlash</a>
                        <a href="<?= Url::to(['/admin/chapter/delete', 'id' => $m->id]) ?>" class="btn-action btn-delete" data-method="post" data-confirm="O'chirilsinmi?">O'chirish</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
