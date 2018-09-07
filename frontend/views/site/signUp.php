<?php

/**
 * @var ActiveForm $form
 * @var frontend\models\SignUp $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

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
            <p>
                Your <span class="strong">career as a coach-manager</span>
                in the Virtual Hockey League begins right here and now.<br/>
                In order for us to distinguish you from other players, come up with a
                <span class="strong">username</span> and <span class="strong">password</span>:
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $form->field($model, 'username')->textInput(['autoFocus' => true]); ?>
            <?= $form->field($model, 'password')->passwordInput(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                Your activation code will be sent to your <span class="strong">e-mail</span>.
                Then you can request a password if you forget it:
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $form->field($model, 'email')->textInput(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= Html::submitButton('Start a career as a manager', ['class' => 'btn']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                Starting a manager's career, you accept an agreement on using the site.
            </p>
            <p>
                Please note, we are not allowed to play simultaneously with multiple nicknames.
            </p>
        </div>
    </div>
<?php ActiveForm::end(); ?>