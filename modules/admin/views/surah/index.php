<?php use yii\helpers\Html; use yii\helpers\Url; ?>
<div class="admin-card">
    <div class="admin-card-header">
        <span><i class="fas fa-quran mr-2"></i>Suralar (<?= count($models) ?>)</span>
        <a href="<?= Url::to(['/admin/surah/create']) ?>" class="btn-save">+ Qo'shish</a>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table">
            <thead><tr><th>#</th><th>Arab nomi</th><th>O'zbek nomi</th><th>Oyatlar</th><th>Turi</th><th>Amallar</th></tr></thead>
            <tbody>
                <?php foreach ($models as $m): ?>
                <tr>
                    <td><?= $m->number ?></td>
                    <td class="arabic-cell"><?= $m->name_ar ?></td>
                    <td><?= Html::encode($m->name_uz) ?></td>
                    <td><?= $m->ayah_count ?></td>
                    <td><span class="<?= $m->revelation_type === 'makki' ? 'badge-active' : 'badge-inactive' ?>"><?= $m->revelation_type ?></span></td>
                    <td>
                        <a href="<?= Url::to(['/admin/surah/update', 'id' => $m->id]) ?>" class="btn-action btn-edit">Tahrirlash</a>
                        <a href="<?= Url::to(['/admin/ayah', 'surah_id' => $m->id]) ?>" class="btn-action btn-edit">Oyatlar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
