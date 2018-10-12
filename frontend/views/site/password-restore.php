<?php

/**
 * @var ActiveForm $form
 * @var \frontend\models\ActivationRepeat $model
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <h1><?= Yii::t('frontend-views-site-password-restore', 'h1'); ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $this->render('_signUpLinks'); ?>
        </div>
    </div>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'fieldConfig' => [
        'errorOptions' => ['class' => 'col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center notification-error'],
        'labelOptions' => ['class' => 'strong'],
        'options' => ['class' => 'row'],
        'template' =>
            '<div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">{label}</div>
            <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">{input}</div>
            {error}',
    ],
]); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= Yii::t('frontend-views-site-password-restore', 'text'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $form->field($model, 'password')->passwordInput(['autoFocus' => true]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= Html::submitButton(
                Yii::t('frontend-views-site-password-restore', 'submit'),
                ['class' => 'btn margin']
            ); ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>