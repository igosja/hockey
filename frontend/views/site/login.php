<?php

/**
 * @var ActiveForm $form
 * @var \common\models\LoginForm $model
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Sign Up</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Ссылки
    </div>
</div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'fieldConfig' => [
        'errorOptions' => ['class' => 'col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center notification-error', 'tag' => 'div'],
        'labelOptions' => ['class' => 'strong'],
        'options' => ['class' => 'row'],
        'template' =>
            '<div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">{label}</div>
            <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">{input}</div>
            {error}',
    ],
]); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $form->field($model, 'username')->textInput(['autoFocus' => true]); ?>
        <?= $form->field($model, 'password')->passwordInput(); ?>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Login', ['class' => 'btn']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>