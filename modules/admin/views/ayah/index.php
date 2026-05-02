<?php use yii\helpers\Html; use yii\helpers\Url; use yii\helpers\ArrayHelper; ?>
<div class="admin-card">
    <div class="admin-card-header">
        <span><i class="fas fa-align-left mr-2"></i>Oyatlar (<?= count($models) ?>)</span>
        <a href="<?= Url::to(['/admin/ayah/create']) ?>" class="btn-save">+ Qo'shish</a>
    </div>
    <div class="admin-card-body">
        <!-- Filter by surah -->
        <form method="get" class="mb-3 d-flex" style="gap:0.5rem">
            <select name="surah_id" class="form-control" style="max-width:250px">
                <option value="">— Barcha suralar —</option>
                <?php foreach ($surahs as $s): ?>
                <option value="<?= $s->id ?>" <?= $surahId == $s->id ? 'selected' : '' ?>>
                    <?= $s->number ?>. <?= Html::encode($s->name_uz) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-save">Filter</button>
        </form>
    </div>
    <div class="admin-card-body p-0">
        <table class="admin-table">
            <thead><tr><th>Sura</th><th>#</th><th>Matn (qisqacha)</th><th>Tarjima</th><th>Amallar</th></tr></thead>
            <tbody>
                <?php foreach ($models as $m): ?>
                <tr>
                    <td style="font-size:0.78rem"><?= Html::encode($m->surah->name_uz ?? '-') ?></td>
                    <td><?= $m->number ?></td>
                    <td class="arabic-cell"><?= mb_substr($m->text_uthmani, 0, 30) ?>...</td>
                    <td style="font-size:0.78rem"><?= Html::encode(mb_substr($m->translation_uz ?? '', 0, 40)) ?>...</td>
                    <td>
                        <a href="<?= Url::to(['/admin/ayah/update', 'id' => $m->id]) ?>" class="btn-action btn-edit">Tahrirlash</a>
                        <a href="<?= Url::to(['/admin/ayah/delete', 'id' => $m->id]) ?>" class="btn-action btn-delete" data-method="post" data-confirm="O'chirilsinmi?">O'chirish</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
