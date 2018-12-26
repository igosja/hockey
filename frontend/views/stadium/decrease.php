<?php

use common\components\FormatHelper;
use frontend\models\Stadium;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var Stadium $model
 * @var \common\models\Team $team
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Строительство стадиона
            </div>
        </div>
    </div>
</div>
<?php if ($team->buildingStadium) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert info">
            На стадионе сейчас идет строительство.
            Дата окончания строительства - <?= $team->buildingStadium->endDate(); ?>
            <br/>
            <?= Html::a(
                'Отменить строительство',
                ['stadium/cancel', 'id' => $team->buildingStadium->building_stadium_id]
            ); ?>
        </div>
    </div>
<?php endif; ?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= $this->render('//stadium/_links'); ?>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'action' => ['stadium/destroy'],
    'fieldConfig' => [
        'errorOptions' => [
            'class' => 'col-lg-4 col-md-4 col-sm-3 col-xs-12 xs-text-center notification-error',
            'tag' => 'div'
        ],
        'options' => ['class' => 'row'],
        'template' =>
            '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">{label}</div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">{input}</div>
            {error}',
    ],
    'method' => 'get',
]); ?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
        Текушая вместимость
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
        <?= Yii::$app->formatter->asInteger($team->stadium->stadium_capacity); ?>
    </div>
</div>
<?= $form
    ->field($model, 'capacity')
    ->textInput([
        'class' => 'form-control',
        'data' => [
            'current' => $team->stadium->stadium_capacity,
            'sit_price' => Stadium::ONE_SIT_PRICE_SELL,
            'url' => Url::to(['format/currency']),
        ],
        'id' => 'stadium-decrease-input',
        'type' => 'integer',
    ])
    ->label('Новая вместимость'); ?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
        Финансы команды
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
        <?= FormatHelper::asCurrency($team->team_finance); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
        Компенсация
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
        <span id="stadium-decrease-price"><?= FormatHelper::asCurrency(0); ?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Уменьшить стадион', ['class' => 'btn margin']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
