<?php use yii\helpers\Html; use yii\helpers\Url; use yii\helpers\ArrayHelper; use yii\widgets\ActiveForm; ?>
<div class="admin-card" style="max-width:800px">
    <div class="admin-card-header">
        <span><?= $model->isNewRecord ? 'Test qo\'shish' : 'Test tahrirlash' ?></span>
        <a href="<?= Url::to(['/admin/quiz']) ?>" style="font-size:0.82rem">← Orqaga</a>
    </div>
    <div class="admin-card-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'lesson_id')->dropDownList(ArrayHelper::map($lessons,'id',fn($l)=>"Bob {$l->chapter_id} — {$l->title_uz}"),['class'=>'form-control','prompt'=>"Darsni tanlang (ixtiyoriy)"])->label('Dars') ?></div>
            <div class="col-md-3"><?= $form->field($model, 'type')->dropDownList(['multiple'=>'Ko\'p variantli','translate'=>'Tarjima','fill'=>"Bo'sh to'ldirish"],['class'=>'form-control'])->label('Turi') ?></div>
            <div class="col-md-3"><?= $form->field($model, 'xp_reward')->textInput(['class'=>'form-control','type'=>'number'])->label('XP') ?></div>
        </div>
        <?= $form->field($model, 'question_uz')->textarea(['class'=>'form-control','rows'=>2])->label("Savol (O'zbek)") ?>
        <?= $form->field($model, 'question_ar')->textarea(['class'=>'form-control','rows'=>2,'style'=>'font-family:Amiri,serif;direction:rtl;font-size:1.2rem'])->label('Savol (Arab, ixtiyoriy)') ?>

        <h6 class="mt-3 mb-2" style="font-weight:700">Javob variantlari</h6>
        <div class="mb-2" style="font-size:0.78rem;color:#888">To'g'ri variant radio buttonidan birini tanlang</div>
        <?php
        $opts = $model->isNewRecord ? [] : $model->options;
        $correctIdx = 0;
        foreach ($opts as $i => $o) { if ($o->is_correct) { $correctIdx = $i; break; } }
        for ($i = 0; $i < 4; $i++):
            $opt = $opts[$i] ?? null;
        ?>
        <div class="d-flex align-items-center mb-2" style="gap:0.5rem">
            <input type="radio" name="correct_option" value="<?= $i ?>" <?= $i == $correctIdx && $opt ? 'checked' : '' ?> title="To'g'ri javob">
            <input type="text" name="options[<?= $i ?>][text_uz]" class="form-control"
                   value="<?= Html::encode($opt->text_uz ?? '') ?>" placeholder="O'zbek variantni kiritng...">
            <input type="text" name="options[<?= $i ?>][text_ar]" class="form-control"
                   style="font-family:Amiri,serif;direction:rtl;max-width:150px"
                   value="<?= Html::encode($opt->text_ar ?? '') ?>" placeholder="Arab (ixtiyoriy)">
        </div>
        <?php endfor; ?>
        <div class="row mt-3">
            <div class="col-md-3"><?= $form->field($model, 'active')->dropDownList([1=>'Faol',0=>'Nofaol'],['class'=>'form-control'])->label('Holat') ?></div>
        </div>
        <div class="mt-3"><button type="submit" class="btn-save">Saqlash</button></div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
