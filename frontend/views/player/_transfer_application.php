<?php

use common\components\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \frontend\models\TransferApplicationTo $model
 * @var \frontend\models\TransferApplicationFrom $modelFrom
 */

try {
    $modelFromClassName = $modelFrom->formName();
} catch (Exception $e) {
    ErrorHelper::log($e);
    $modelFromClassName = 'TransferApplicationFrom';
}

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                Your team:
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <span class="strong">
                    <?= Html::a(
                        $model->team->team_name . ' <span class="hidden-xs">(' . $model->team->stadium->city->city_name . ')</span>',
                        ['team/view', 'id' => $model->team->team_id]
                    ); ?>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                Team finances:
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <span class="strong">
                    <?php

                    try {
                        print Yii::$app->formatter->asCurrency($model->team->team_finance);
                    } catch (Exception $e) {
                        ErrorHelper::log($e);
                    }

                    ?>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                Starting price:
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <span class="strong">
                    <?php

                    try {
                        print Yii::$app->formatter->asCurrency($model->minPrice);
                    } catch (Exception $e) {
                        ErrorHelper::log($e);
                    }

                    ?>
                </span>
            </div>
        </div>
        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center notification-error',
                    'tag' => 'div',
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
            <?= $form->field($model, 'onlyOne', [
                'template' => '
                <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">{input}</div>
                </div>
                <div class="row">{error}</div>'
            ])->checkbox(); ?>
        </div>
        <p class="text-center">
            <?php if ($model->transferApplication) : ?>
                <?= Html::submitButton('Edit application', ['class' => 'btn']); ?>
                <?= Html::a(
                    'Remove application',
                    'javascript:',
                    ['class' => 'btn', 'id' => 'btn' . $modelFromClassName]
                ); ?>
            <?php else: ?>
                <?= Html::submitButton('Apply', ['class' => 'btn']); ?>
            <?php endif; ?>
        </p>
        <?php $form->end(); ?>
        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
            'options' => [
                'id' => 'form' . $modelFromClassName,
                'style' => [
                    'display' => 'none',
                ],
            ],
        ]); ?>
        <?= $form->field($modelFrom, 'off')->hiddenInput(['value' => true])->label(false); ?>
        <?php $form->end(); ?>
    </div>
</div>
