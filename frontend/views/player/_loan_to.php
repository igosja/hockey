<?php

use common\components\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \frontend\models\LoanTo $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            Here you can <span class="strong">put your player on the rental market</span>.
        </p>
        <p>
            The initial loan price of the player must be at least
            <span class="strong"><?php

                try {
                    print Yii::$app->formatter->asCurrency($model->minPrice);
                } catch (Throwable $e) {
                    ErrorHelper::log($e);
                }

                ?></span>.
        </p>
        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center notification-error',
                    'tag' => 'div'
                ],
            ],
        ]); ?>
        <?= $form->field($model, 'price', [
            'template' => '
                <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">{label}</div>
                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-6">{input}</div>
                </div>
                <div class="row">{error}</div>'
        ])->textInput(); ?>
        <?= $form->field($model, 'minDay', [
            'template' => '
                <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">{label}</div>
                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-6">{input}</div>
                </div>
                <div class="row">{error}</div>'
        ])->textInput(); ?>
        <?= $form->field($model, 'maxDay', [
            'template' => '
                <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">{label}</div>
                <div class="col-lg-1 col-md-2 col-sm-2 col-xs-6">{input}</div>
                </div>
                <div class="row">{error}</div>'
        ])->textInput(); ?>
        <p class="text-center">
            <?= Html::submitButton('Put on the rental market', ['class' => 'btn']); ?>
        </p>
        <?php $form->end(); ?>
    </div>
</div>