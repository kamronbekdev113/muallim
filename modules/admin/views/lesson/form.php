<?php
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
?>
<div class="admin-card" style="max-width:800px">
    <div class="admin-card-header">
        <span><?= $model->isNewRecord ? '+ Dars qo\'shish' : 'Dars tahrirlash' ?></span>
        <a href="<?= Url::to(['/admin/lesson']) ?>" style="font-size:0.82rem;color:var(--green-mid)">← Orqaga</a>
    </div>
    <div class="admin-card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'chapter_id')->dropDownList(
                    ArrayHelper::map($chapters, 'id', fn($c) => "Bob {$c->number}: {$c->title_uz}"),
                    ['class' => 'form-control', 'prompt' => 'Bobni tanlang...']
                )->label('Bob') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'number')->textInput(['class' => 'form-control', 'type' => 'number'])->label('Dars raqami') ?>
            </div>
            <div class="col-md-3">
                <?= $form->field($model, 'xp_reward')->textInput(['class' => 'form-control', 'type' => 'number'])->label('XP') ?>
            </div>
        </div>
        <?= $form->field($model, 'title_uz')->textInput(['class' => 'form-control'])->label('Sarlavha') ?>
        <?= $form->field($model, 'content_uz')->textarea(['class' => 'form-control', 'rows' => 3])->label('Mazmun (O\'zbek)') ?>
        <?= $form->field($model, 'arabic_text')->textarea(['class' => 'form-control', 'rows' => 4, 'style' => 'font-family:Amiri,serif;font-size:1.5rem;direction:rtl;text-align:right'])->label('Arab matni') ?>
        <?= $form->field($model, 'transliteration')->textarea(['class' => 'form-control', 'rows' => 2])->label('Transliteratsiya') ?>
        <?= $form->field($model, 'translation_uz')->textarea(['class' => 'form-control', 'rows' => 2])->label("Tarjimasi (O'zbek)") ?>
        <div class="row">
            <div class="col-md-4"><?= $form->field($model, 'sort_order')->textInput(['class' => 'form-control', 'type' => 'number'])->label('Tartib') ?></div>
            <div class="col-md-4"><?= $form->field($model, 'active')->dropDownList([1 => 'Faol', 0 => 'Nofaol'], ['class' => 'form-control'])->label('Holat') ?></div>
        </div>
        <div class="mt-3"><button type="submit" class="btn-save">Saqlash</button></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
