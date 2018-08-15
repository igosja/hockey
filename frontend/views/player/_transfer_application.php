<?php

use common\components\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \frontend\models\TransferApplication $model
 */

$team = $model->getTeam();

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
                        $team->team_name . ' <span class="hidden-xs">(' . $team->stadium->city->city_name . ')</span>',
                        ['team/view', 'id' => $team->team_id]
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
                        print Yii::$app->formatter->asCurrency($team->team_finance);
                    } catch (Throwable $e) {
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
                        print Yii::$app->formatter->asCurrency($model->getMinPrice());
                    } catch (Throwable $e) {
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
            <?= $form->field($model, 'onlyOne', [
                'template' => '
                <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">{input}</div>
                </div>
                <div class="row">{error}</div>'
            ])->checkbox(); ?>
        </div>
        <p class="text-center">
            <?php if (true) : ?>
                <?= Html::submitButton('Edit application', ['class' => 'btn']); ?>
                <?= Html::a('Remove application', 'javascript:', ['class' => 'btn']); ?>
            <?php else: ?>
                <?= Html::submitButton('Edit Apply', ['class' => 'btn']); ?>
            <?php endif; ?>
        </p>
        <?php $form->end(); ?>
    </div>
</div>