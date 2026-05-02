<?php use yii\helpers\Url; use yii\widgets\ActiveForm; ?>
<div class="admin-card" style="max-width:600px">
    <div class="admin-card-header">
        <span><?= $model->isNewRecord ? "So'z qo'shish" : "So'z tahrirlash" ?></span>
        <a href="<?= Url::to(['/admin/vocabulary']) ?>" style="font-size:0.82rem">← Orqaga</a>
    </div>
    <div class="admin-card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-4"><?= $form->field($model, 'word_ar')->textInput(['class'=>'form-control','style'=>'font-family:Amiri,serif;direction:rtl;font-size:1.3rem'])->label("So'z (Arab)") ?></div>
            <div class="col-md-4"><?= $form->field($model, 'root')->textInput(['class'=>'form-control','style'=>'font-family:Amiri,serif;direction:rtl'])->label('Ildiz') ?></div>
            <div class="col-md-4"><?= $form->field($model, 'transliteration')->textInput(['class'=>'form-control'])->label('Transliteratsiya') ?></div>
        </div>
        <?= $form->field($model, 'translation_uz')->textInput(['class'=>'form-control'])->label("Tarjimasi (O'zbek)") ?>
        <div class="row">
            <div class="col-md-4"><?= $form->field($model, 'category')->textInput(['class'=>'form-control','placeholder'=>'general'])->label('Kategoriya') ?></div>
            <div class="col-md-4"><?= $form->field($model, 'difficulty')->dropDownList([1=>'Oson',2=>"O'rta",3=>'Qiyin'],['class'=>'form-control'])->label('Qiyinlik') ?></div>
        </div>
        <?= $form->field($model, 'examples_json')->textarea(['class'=>'form-control','rows'=>3,'placeholder'=>'[{"ar":"...","uz":"..."}]'])->label('Misollar (JSON)') ?>
        <div class="mt-3"><button type="submit" class="btn-save">Saqlash</button></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
