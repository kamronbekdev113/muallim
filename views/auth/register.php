<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = "Ro'yxatdan o'tish";
?>
<div class="auth-wrapper arabesque-bg">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="brand-icon mx-auto">م</div>
            <h3>Yangi hisob yaratish</h3>
            <p>Bepul ro'yxatdan o'ting va o'rganishni boshlang</p>
        </div>
        <?php $form = ActiveForm::begin(['options' => ['novalidate' => true]]); ?>
        <div class="form-group">
            <label class="form-label-muallim">Foydalanuvchi nomi *</label>
            <?= $form->field($model, 'username', ['template' => '{input}{error}'])
                ->textInput(['class' => 'form-control-muallim', 'placeholder' => 'foydalanuvchi_nomi']) ?>
        </div>
        <div class="form-group">
            <label class="form-label-muallim">To'liq ism</label>
            <?= $form->field($model, 'full_name', ['template' => '{input}{error}'])
                ->textInput(['class' => 'form-control-muallim', 'placeholder' => 'Ismingiz']) ?>
        </div>
        <div class="form-group">
            <label class="form-label-muallim">Email</label>
            <?= $form->field($model, 'email', ['template' => '{input}{error}'])
                ->input('email', ['class' => 'form-control-muallim', 'placeholder' => 'email@example.com']) ?>
        </div>
        <div class="form-group">
            <label class="form-label-muallim">Parol *</label>
            <?= $form->field($model, 'password', ['template' => '{input}{error}'])
                ->passwordInput(['class' => 'form-control-muallim', 'placeholder' => 'Kamida 6 belgi']) ?>
        </div>
        <div class="form-group">
            <label class="form-label-muallim">Parolni tasdiqlang *</label>
            <?= $form->field($model, 'password_confirm', ['template' => '{input}{error}'])
                ->passwordInput(['class' => 'form-control-muallim', 'placeholder' => '••••••']) ?>
        </div>
        <button type="submit" class="btn-gold-fill w-100 py-2 mt-2">
            <i class="fas fa-user-plus mr-1"></i> Ro'yxatdan o'tish
        </button>
        <?php ActiveForm::end(); ?>
        <div class="text-center mt-3" style="font-size:0.85rem;color:var(--mid-text)">
            Hisobingiz bormi?
            <a href="<?= Url::to(['/kirish']) ?>" style="color:var(--green-mid);font-weight:600">Kirish</a>
        </div>
    </div>
</div>
