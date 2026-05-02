<?php use yii\helpers\Html; use yii\helpers\Url; ?>
<div class="admin-card">
    <div class="admin-card-header">
        <span><i class="fas fa-font mr-2"></i>Arab Harflari (<?= count($models) ?>)</span>
        <a href="<?= Url::to(['/admin/letter/create']) ?>" class="btn-save">+ Qo'shish</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table">
            <thead><tr><th>#</th><th>Harf</th><th>Nom</th><th>Transliteratsiya</th><th>Shakllari</th><th>Amallar</th></tr></thead>
            <tbody>
                <?php foreach ($models as $m): ?>
                <tr>
                    <td><?= $m->sort_order ?></td>
                    <td><span style="font-family:var(--arabic-font);font-size:2rem"><?= $m->letter ?></span></td>
                    <td><?= Html::encode($m->name_uz) ?></td>
                    <td><?= Html::encode($m->transliteration) ?></td>
                    <td style="font-family:var(--arabic-font);font-size:1.1rem">
                        <?= $m->isolated ?> | <?= $m->initial ?> | <?= $m->medial ?> | <?= $m->final ?>
                    </td>
                    <td>
                        <a href="<?= Url::to(['/admin/letter/update', 'id' => $m->id]) ?>" class="btn-action btn-edit">Tahrirlash</a>
                        <a href="<?= Url::to(['/admin/letter/delete', 'id' => $m->id]) ?>" class="btn-action btn-delete"
                           data-method="post" data-confirm="O'chirilsinmi?">O'chirish</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
