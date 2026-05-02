<?php use yii\helpers\Url; use yii\helpers\ArrayHelper; use yii\widgets\ActiveForm; ?>
<div class="admin-card" style="max-width:800px">
    <div class="admin-card-header">
        <span><?= $model->isNewRecord ? 'Oyat qo\'shish' : 'Oyat tahrirlash' ?></span>
        <a href="<?= Url::to(['/admin/ayah']) ?>" style="font-size:0.82rem">← Orqaga</a>
    </div>
    <div class="admin-card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'surah_id')->dropDownList(ArrayHelper::map($surahs,'id',fn($s)=>"{$s->number}. {$s->name_uz}"),['class'=>'form-control','prompt'=>'Surani tanlang...'])->label('Sura') ?></div>
            <div class="col-md-3"><?= $form->field($model, 'number')->textInput(['class'=>'form-control','type'=>'number'])->label('Oyat raqami') ?></div>
            <div class="col-md-3"><?= $form->field($model, 'juz')->textInput(['class'=>'form-control','type'=>'number'])->label('Juz') ?></div>
        </div>
        <?= $form->field($model, 'text_uthmani')->textarea(['class'=>'form-control','rows'=>3,'style'=>'font-family:Amiri,serif;font-size:1.5rem;direction:rtl;text-align:right'])->label("Uthmoni matni") ?>
        <div class="mb-2" style="font-size:0.78rem;color:#888">
            Tajvid uchun HTML teglaridan foydalaning: &lt;span class="tj-madd"&gt;...&lt;/span&gt;
        </div>
        <?= $form->field($model, 'text_tajweed')->textarea(['class'=>'form-control','rows'=>4,'style'=>'font-family:Amiri,serif;font-size:1.3rem;direction:rtl;text-align:right'])->label("Tajvidli matn (HTML)") ?>
        <?= $form->field($model, 'translation_uz')->textarea(['class'=>'form-control','rows'=>3])->label("O'zbekcha tarjima") ?>
        <div class="mt-3"><button type="submit" class="btn-save">Saqlash</button></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
