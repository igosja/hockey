<?php

/**
 * @var $model \common\models\LoginForm
 */

use common\components\ErrorHelper;
use common\widgets\Alert;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-8 col-sm-10 col-xs-12 col-lg-offset-4 col-md-offset-2 col-sm-offset-1">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">Login</h3>
            </div>
            <div class="panel-body">
                <?php

                try {
                    Alert::widget();
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?>
                <?php $form = ActiveForm::begin(); ?>
                <fieldset>
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]); ?>
                    <div class="form-group">
                        <input class="form-control" placeholder="Логин" name="data[login]" autofocus/>
                    </div>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                    <div class="form-group">
                        <input class="form-control" placeholder="Пароль" name="data[password]" type="password"/>
                    </div>
                    <?= Html::submitButton(
                        'Login',
                        ['class' => 'btn btn-lg btn-primary btn-block']
                    ) ?>
                    <button class="btn btn-lg btn-primary btn-block">Вход</button>
                </fieldset>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
