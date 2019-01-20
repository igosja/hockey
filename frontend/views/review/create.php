<?php

use common\components\HockeyHelper;
use yii\helpers\Html;

/**
 * @var \common\models\Country $country
 * @var \common\models\Division $division
 * @var \common\models\Game[] $gameArray
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            <?= $country->country_name; ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= $country->country_name; ?>, <?= $division->division_name; ?>, <?= $schedule->stage->stage_name; ?>
        , <?= $schedule->schedule_season_id; ?> сезон
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
<form action="/review_create.php?<?= http_build_query(array_merge($_GET, array('edit' => 0))); ?>" method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table">
                <?php foreach ($gameArray as $item) { ?>
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
                <?php } ?>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 text-right">
            <label for="title">Заголовок:</label>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">
            <input class="form-control" id="title" name="data[title]"/>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center title-error notification-error"></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <label class="hidden" for="text"></label>
            <textarea class="form-control" id="text" name="data[text]" rows="20">
            </textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-error notification-error"></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <input class="btn margin" type="submit" value="Предварительный просмотр">
        </div>
    </div>
</form>
