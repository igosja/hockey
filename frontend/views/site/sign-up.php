<?php

/**
 * @var ActiveForm $form
 * @var \frontend\models\SignUp $model
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <h1>Регистрация в игре</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $this->render('_sign-up-links'); ?>
        </div>
    </div>
<?php $form = ActiveForm::begin(``); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                Ваша <strong>карьера тренера-менеджера</strong>
                в Виртуальной Хоккейной Лиге начинается прямо здесь и сейчас.<br/>
                Для того, чтобы мы могли отличить вас от других игроков, придумайте себе
                <strong>логин</strong> и <strong>пароль</strong>:
            </p
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
                На <strong>ваш e-mail</strong> отправится код активации аккаунта.
                Потом туда можно запросить пароль, если вы его забудете:
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
            <?= Html::submitButton('Начать карьеру менеджера', ['class' => 'btn margin']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                Начиная карьеру менеджера, вы принимаете соглашение о пользовании сайтом.
            </p>
            <p>
                Обратите внимание, у нас запрещено играть одновременно под несколькими никами.
            </p>
        </div>
    </div>
<?php ActiveForm::end(); ?>