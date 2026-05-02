<?php use yii\helpers\Url; use yii\widgets\ActiveForm; ?>
<div class="admin-card" style="max-width:700px">
    <div class="admin-card-header">
        <span><?= $model->isNewRecord ? '+ Qoida qo\'shish' : 'Qoida tahrirlash' ?></span>
        <a href="<?= Url::to(['/admin/tajweed']) ?>" style="font-size:0.82rem;color:var(--green-mid)">← Orqaga</a>
    </div>
    <div class="admin-card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'name_uz')->textInput(['class' => 'form-control'])->label('Nomi (O\'zbek)') ?></div>
            <div class="col-md-6"><?= $form->field($model, 'name_ar')->textInput(['class' => 'form-control', 'style' => 'font-family:Amiri,serif;direction:rtl;font-size:1.2rem'])->label('Nomi (Arab)') ?></div>
        </div>
        <?= $form->field($model, 'description_uz')->textarea(['class' => 'form-control', 'rows' => 3])->label('Tavsif') ?>
        <div class="row">
            <div class="col-md-4"><?= $form->field($model, 'color_code')->input('color', ['class' => 'form-control', 'style' => 'height:42px'])->label('Rang') ?></div>
            <div class="col-md-4"><?= $form->field($model, 'css_class')->textInput(['class' => 'form-control', 'placeholder' => 'tj-qalqala'])->label('CSS klassi') ?></div>
            <div class="col-md-4">
                <?= $form->field($model, 'category')->dropDownList([
                    'madd'=>'Madd','ghunna'=>'Ghunna','qalqala'=>'Qalqala',
                    'ikhfa'=>'Ikhfa','idgham'=>'Idgham','iqlab'=>'Iqlab','izhar'=>'Izhar','other'=>'Boshqa'
                ], ['class' => 'form-control'])->label('Kategoriya') ?>
            </div>
        </div>
        <?= $form->field($model, 'example_ar')->textarea(['class' => 'form-control', 'rows' => 2, 'style' => 'font-family:Amiri,serif;direction:rtl;font-size:1.3rem'])->label('Misol (Arab, HTML mumkin)') ?>
        <?= $form->field($model, 'example_translation')->textarea(['class' => 'form-control', 'rows' => 2])->label("Misol tarjimasi") ?>
        <div class="row">
            <div class="col-md-4"><?= $form->field($model, 'sort_order')->textInput(['class' => 'form-control', 'type' => 'number'])->label('Tartib') ?></div>
            <div class="col-md-4"><?= $form->field($model, 'active')->dropDownList([1=>'Faol',0=>'Nofaol'],['class'=>'form-control'])->label('Holat') ?></div>
        </div>
        <div class="mt-3"><button type="submit" class="btn-save">Saqlash</button></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
