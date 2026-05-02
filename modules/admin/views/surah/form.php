<?php use yii\helpers\Url; use yii\widgets\ActiveForm; ?>
<div class="admin-card" style="max-width:600px">
    <div class="admin-card-header">
        <span><?= $model->isNewRecord ? 'Sura qo\'shish' : 'Sura tahrirlash' ?></span>
        <a href="<?= Url::to(['/admin/surah']) ?>" style="font-size:0.82rem">← Orqaga</a>
    </div>
    <div class="admin-card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-3"><?= $form->field($model, 'number')->textInput(['class'=>'form-control','type'=>'number'])->label('Raqam') ?></div>
            <div class="col-md-5"><?= $form->field($model, 'name_ar')->textInput(['class'=>'form-control','style'=>'font-family:Amiri,serif;direction:rtl;font-size:1.3rem'])->label('Arab nomi') ?></div>
            <div class="col-md-4"><?= $form->field($model, 'ayah_count')->textInput(['class'=>'form-control','type'=>'number'])->label('Oyatlar soni') ?></div>
        </div>
        <?= $form->field($model, 'name_uz')->textInput(['class'=>'form-control'])->label("O'zbek nomi") ?>
        <?= $form->field($model, 'name_en')->textInput(['class'=>'form-control'])->label('Inglizcha nomi') ?>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'revelation_type')->dropDownList(['makki'=>'Makki','madani'=>'Madani'],['class'=>'form-control'])->label('Turi') ?></div>
            <div class="col-md-6"><?= $form->field($model, 'bismillah_pre')->dropDownList([1=>'Ha',0=>"Yo'q"],['class'=>'form-control'])->label('Bismillah bormi?') ?></div>
        </div>
        <div class="mt-3"><button type="submit" class="btn-save">Saqlash</button></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
