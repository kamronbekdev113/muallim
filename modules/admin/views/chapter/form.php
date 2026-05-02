<?php use yii\helpers\Url; use yii\widgets\ActiveForm; ?>
<div class="admin-card" style="max-width:600px">
    <div class="admin-card-header">
        <span><?= $model->isNewRecord ? 'Bob qo\'shish' : 'Bob tahrirlash' ?></span>
        <a href="<?= Url::to(['/admin/chapter']) ?>" style="font-size:0.82rem">← Orqaga</a>
    </div>
    <div class="admin-card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-3"><?= $form->field($model, 'number')->textInput(['class'=>'form-control','type'=>'number'])->label('Bob raqami') ?></div>
            <div class="col-md-3"><?= $form->field($model, 'sort_order')->textInput(['class'=>'form-control','type'=>'number'])->label('Tartib') ?></div>
            <div class="col-md-3"><?= $form->field($model, 'icon')->textInput(['class'=>'form-control','placeholder'=>'book'])->label('FA Icon') ?></div>
            <div class="col-md-3"><?= $form->field($model, 'active')->dropDownList([1=>'Faol',0=>'Nofaol'],['class'=>'form-control'])->label('Holat') ?></div>
        </div>
        <?= $form->field($model, 'title_uz')->textInput(['class'=>'form-control'])->label('Sarlavha') ?>
        <?= $form->field($model, 'description_uz')->textarea(['class'=>'form-control','rows'=>3])->label('Tavsif') ?>
        <div class="mt-3"><button type="submit" class="btn-save">Saqlash</button></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
