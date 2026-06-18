<?php
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="admin-card" style="max-width:700px">
    <div class="admin-card-header">
        <span><?= $model->isNewRecord ? '+ Harf qo\'shish' : 'Harf tahrirlash' ?></span>
        <a href="<?= Url::to(['/admin/letter']) ?>" style="font-size:0.82rem;color:var(--green-mid)">← Orqaga</a>
    </div>
    <div class="admin-card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'letter')->textInput(['class' => 'form-control', 'style' => 'font-family:Amiri,serif;font-size:2rem;direction:rtl'])->label('Harf (arab)') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'name_uz')->textInput(['class' => 'form-control'])->label('Nomi (uz)') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'transliteration')->textInput(['class' => 'form-control'])->label('Transliteratsiya') ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'sort_order')->textInput(['class' => 'form-control', 'type' => 'number'])->label('Tartib') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3"><?= $form->field($model, 'isolated')->textInput(['class' => 'form-control', 'style' => 'font-family:Amiri,serif;font-size:1.5rem;direction:rtl'])->label('Yakka') ?></div>
            <div class="col-md-3"><?= $form->field($model, 'initial')->textInput(['class' => 'form-control', 'style' => 'font-family:Amiri,serif;font-size:1.5rem;direction:rtl'])->label('Boshida') ?></div>
            <div class="col-md-3"><?= $form->field($model, 'medial')->textInput(['class' => 'form-control', 'style' => 'font-family:Amiri,serif;font-size:1.5rem;direction:rtl'])->label("O'rtada") ?></div>
            <div class="col-md-3"><?= $form->field($model, 'final')->textInput(['class' => 'form-control', 'style' => 'font-family:Amiri,serif;font-size:1.5rem;direction:rtl'])->label('Oxirida') ?></div>
        </div>
        <?= $form->field($model, 'pronunciation_note')->textarea(['class' => 'form-control', 'rows' => 2])->label('Talaffuz izohi') ?>
        <?= $form->field($model, 'examples_json')->textarea(['class' => 'form-control', 'rows' => 3, 'placeholder' => '[{"ar":"بَيْت","uz":"uy"}]'])->label('Misollar (JSON)') ?>
        <div class="mt-3"><button type="submit" class="btn-save">Saqlash</button></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
