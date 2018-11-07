<?php

use common\components\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \frontend\models\TransferTo $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            Here you can <span class="strong">put your player on the transfer market</span>.
        </p>
        <p>
            The initial transfer price of the player must be at least
            <span class="strong"><?php

                try {
                    print Yii::$app->formatter->asCurrency($model->minPrice);
                } catch (Exception $e) {
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
        <div class="row">
            <?= $form->field($model, 'toLeague', [
                'template' => '
                <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">{input}</div>
                </div>
                <div class="row">{error}</div>'
            ])->checkbox(); ?>
        </div>
        <p class="text-center">
            <?= Html::submitButton('Put on a transfer', ['class' => 'btn']); ?>
        </p>
        <?php $form->end(); ?>
    </div>
</div>