<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\PollUser $model
 * @var \common\models\Poll $poll
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1>Опрос</h1>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <span class="strong"><?= $poll->poll_text; ?></span>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $poll->pollStatus->poll_status_name; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Автор:
                <?= Html::a(
                    $poll->user->user_login,
                    ['user/view', 'id' => $poll->poll_user_id]
                ); ?>
            </div>
        </div>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 notification-error',
                    'tag' => 'div'
                ],
            ],
        ]); ?>
        <?= $form
            ->field($model, 'poll_user_poll_answer_id')
            ->radioList(
                ArrayHelper::map($poll->pollAnswer, 'poll_answer_id', 'poll_answer_text'),
                [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        return '<div class="row ' . $index . '"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'
                            . Html::radio($name, $checked, ['label' => $label, 'value' => $value])
                            . '</div></div>';
                    }
                ]
            )
            ->label(false); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Голосовать', ['class' => 'btn margin']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
