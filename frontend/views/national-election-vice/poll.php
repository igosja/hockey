<?php

use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\ElectionNationalViceApplication;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\ElectionNationalVice $electionNationalVice
 * @var \common\models\ElectionNationalViceVote $model
 */

print $this->render('//country/_country');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h4>Выборы заместителя тренера национальной сборной</h4>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $electionNationalVice->electionStatus->election_status_name; ?>
            </div>
        </div>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'errorOptions' => ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 notification-error'],
                'labelOptions' => ['class' => 'strong'],
                'options' => ['class' => 'row'],
                'template' =>
                    '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">{label}</div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{input}</div>
                    {error}',
            ],
        ]); ?>
        <?= $form
            ->field($model, 'election_national_vote_application_id')
            ->radioList($electionNationalVice->application, [
                'item' => function ($index, ElectionNationalViceApplication $model, $name, $checked) {
                    $result = '<div class="row border-top"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'
                        . Html::radio($name, $checked, [
                            'index' => $index,
                            'label' => $model->election_national_vice_application_user_id ? $model->user->userLink() : 'Потив всех',
                            'value' => $model->election_national_vice_application_id,
                        ])
                        . '</div></div>';
                    if ($model->election_national_vice_application_user_id) {
                        $result = $result . '<div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Дата регистрации: '
                            . FormatHelper::asDate($model->user->user_date_register)
                            . '</div></div>
                            <div class="row margin-top-small">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'
                            . HockeyHelper::bbDecode($model->election_national_vice_application_text)
                            . '</div></div>';
                    }
                    return $result;
                }
            ])
            ->label(false); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Голосовать', ['class' => 'btn margin']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
