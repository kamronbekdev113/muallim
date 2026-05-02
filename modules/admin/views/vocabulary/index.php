<?php use yii\helpers\Html; use yii\helpers\Url; ?>
<div class="admin-card">
    <div class="admin-card-header">
        <span>Lug'at (<?= count($models) ?>)</span>
        <a href="<?= Url::to(['/admin/vocabulary/create']) ?>" class="btn-save">+ Qo'shish</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table">
            <thead><tr><th>So'z</th><th>Transliteratsiya</th><th>Tarjima</th><th>Kategoriya</th><th>Qiyinlik</th><th>Amallar</th></tr></thead>
            <tbody>
                <?php foreach ($models as $m): ?>
                <tr>
                    <td class="arabic-cell"><?= $m->word_ar ?></td>
                    <td><?= Html::encode($m->transliteration) ?></td>
                    <td><?= Html::encode($m->translation_uz) ?></td>
                    <td><?= Html::encode($m->category) ?></td>
                    <td><?= $m->difficulty ?></td>
                    <td>
                        <a href="<?= Url::to(['/admin/vocabulary/update', 'id' => $m->id]) ?>" class="btn-action btn-edit">Tahrirlash</a>
                        <a href="<?= Url::to(['/admin/vocabulary/delete', 'id' => $m->id]) ?>" class="btn-action btn-delete" data-method="post" data-confirm="O'chirilsinmi?">O'chirish</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
