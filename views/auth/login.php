<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = 'Kirish';
?>
<div class="auth-wrapper arabesque-bg">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="brand-icon mx-auto">م</div>
            <h3>Muallimga kirish</h3>
            <p>O'rganishni davom ettirish uchun kiring</p>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['novalidate' => true]]); ?>
        <div class="form-group">
            <label class="form-label-muallim">Foydalanuvchi nomi</label>
            <?= $form->field($model, 'username', ['template' => '{input}{error}'])
                ->textInput(['class' => 'form-control-muallim', 'placeholder' => 'username', 'autofocus' => true]) ?>
        </div>
        <div class="form-group">
            <label class="form-label-muallim">Parol</label>
            <?= $form->field($model, 'password', ['template' => '{input}{error}'])
                ->passwordInput(['class' => 'form-control-muallim', 'placeholder' => '••••••']) ?>
        </div>
        <div class="form-group d-flex align-items-center justify-content-between">
            <?= $form->field($model, 'rememberMe', ['template' => '{input} {label}', 'options' => ['class' => 'form-check']])
                ->checkbox(['class' => 'form-check-input', 'label' => 'Eslab qolish']) ?>
        </div>
        <button type="submit" class="btn-gold-fill w-100 py-2 mt-2">
            <i class="fas fa-sign-in-alt mr-1"></i> Kirish
        </button>
        <?php ActiveForm::end(); ?>
        <div class="text-center mt-3" style="font-size:0.85rem;color:var(--mid-text)">
            Hisobingiz yo'qmi?
            <a href="<?= Url::to(['/royxat']) ?>" style="color:var(--green-mid);font-weight:600">Ro'yxatdan o'ting</a>
        </div>
    </div>
</div>
