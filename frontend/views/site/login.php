<?php

/**
 * @var ActiveForm $form
 * @var LoginForm $model
 * @var View $this
 */

use common\models\LoginForm;
use frontend\models\OAuthFacebook;
use frontend\models\OAuthGoogle;
use frontend\models\OAuthVk;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Вход</h1>
    </div>
</div>
<?php $form = ActiveForm::begin([
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Вход', ['class' => 'btn margin']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Или войдите при помощи социальных сетей:
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::a(
            '<i class="fa fa-facebook-square fa-2x"></i>',
            OAuthFacebook::getConnectUrl('login'),
            ['title' => 'Facebook']
        ); ?>
        <?= Html::a(
            '<i class="fa fa-google-plus-square fa-2x"></i>',
            OAuthGoogle::getConnectUrl('login'),
            ['title' => 'Google+']
        ); ?>
        <?= Html::a(
            '<i class="fa fa-vk fa-2x"></i>',
            OAuthVk::getConnectUrl('login'),
            ['title' => 'ВКонтакте']
        ); ?>
    </div>
</div>
