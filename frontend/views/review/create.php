<?php

use coderlex\wysibb\WysiBB;
use common\components\HockeyHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\Country $country
 * @var \common\models\Division $division
 * @var \common\models\Game[] $gameArray
 * @var \frontend\models\CreateReview $model
 * @var \common\models\Schedule $schedule
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Написать обзор прошедшего тура
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= $country->country_name; ?>,
        <?= $division->division_name; ?>,
        <?= $schedule->stage->stage_name; ?>,
        <?= $schedule->schedule_season_id; ?> сезон
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-justify">
            Текст обзора должен быть информативным, выдержанным в тоне публикаций в спортивных СМИ,
            освещать все матчи игрового дня в дивизионе, не должен содержать бурного выражения личных эмоций,
            ненормативной лексики и оскорблений в чей-либо адрес,
            не должен являться ответом на другой обзор или высказывание участника игры.
        </p>
        <p class="text-justify">
            Будьте внимательны! Обзор нельзя отредактировать после сохранения.
        </p>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'errorOptions' => [
            'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center notification-error',
            'tag' => 'div'
        ],
        'options' => ['class' => 'row'],
        'template' =>
            '<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">{label}</div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{input}</div>
            </div>
            <div class="row">{error}</div>',
    ],
]); ?>
<?= $form->field($model, 'title')->textInput(['class' => 'form-control']); ?>
<?= $form->field($model, 'text')->widget(WysiBB::class); ?>
<?php foreach ($gameArray as $item) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table">
                <tr>
                    <td class="text-right col-45">
                        <?= $item->teamHome->teamLink('string', true); ?>
                        <?= HockeyHelper::formatAuto($item->game_home_auto); ?>
                    </td>
                    <td class="text-center col-10">
                        <?= Html::a(
                            $item->formatScore(),
                            ['game/view', 'id' => $item->game_id]
                        ); ?>
                    </td>
                    <td>
                        <?= $item->teamGuest->teamLink('string', true); ?>
                        <?= HockeyHelper::formatAuto($item->game_guest_auto); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?= $form->field($model, 'gameText[' . $item->game_id . ']')->widget(WysiBB::class)->label(false); ?>
<?php endforeach; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Сохранить', ['class' => 'btn margin']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
