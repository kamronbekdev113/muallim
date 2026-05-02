<?php use yii\helpers\Html; use yii\helpers\Url; ?>
<div class="admin-card">
    <div class="admin-card-header">
        <span><i class="fas fa-star-and-crescent mr-2"></i>Tajvid Qoidalari (<?= count($models) ?>)</span>
        <a href="<?= Url::to(['/admin/tajweed/create']) ?>" class="btn-save">+ Qo'shish</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table">
            <thead><tr><th>Rang</th><th>Nom</th><th>Arab nomi</th><th>Kategoriya</th><th>Faol</th><th>Amallar</th></tr></thead>
            <tbody>
                <?php foreach ($models as $m): ?>
                <tr>
                    <td><span style="display:inline-block;width:24px;height:24px;border-radius:50%;background:<?= $m->color_code ?>;box-shadow:0 2px 6px rgba(0,0,0,0.2)"></span></td>
                    <td><?= Html::encode($m->name_uz) ?></td>
                    <td class="arabic-cell"><?= Html::encode($m->name_ar) ?></td>
                    <td><?= Html::encode($m->category) ?></td>
                    <td><span class="<?= $m->active ? 'badge-active' : 'badge-inactive' ?>"><?= $m->active ? 'Ha' : 'Yo\'q' ?></span></td>
                    <td>
                        <a href="<?= Url::to(['/admin/tajweed/update', 'id' => $m->id]) ?>" class="btn-action btn-edit">Tahrirlash</a>
                        <a href="<?= Url::to(['/admin/tajweed/delete', 'id' => $m->id]) ?>" class="btn-action btn-delete" data-method="post" data-confirm="O'chirilsinmi?">O'chirish</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
