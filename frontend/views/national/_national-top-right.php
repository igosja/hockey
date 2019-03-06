<?php

/**
 * @var \frontend\controllers\AbstractController $controller
 * @var \common\models\National $national
 * @var \yii\web\View $this
 */

use common\components\FormatHelper;
use yii\helpers\Html;

?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top-small">
        <?php if (Yii::$app->user->isGuest) : ?>
            <?= Html::a(
                Html::img(
                    '/img/roster/questionnaire.png',
                    ['alt' => 'Зарегистрироваться', 'title' => 'Зарегистрироваться']
                ),
                ['site/sign-up'],
                ['class' => 'no-underline']
            ); ?>
        <?php else: ?>
            <?php if ($national->myTeam()) : ?>
                <?= Html::a(
                    Html::img(
                        '/img/roster/school.png',
                        ['alt' => 'Подготовка молодёжи', 'title' => 'Подготовка молодёжи']
                    ),
                    ['school/index'],
                    ['class' => 'no-underline']
                ); ?>
            <?php endif; ?>
            <?= Html::a(
                Html::img(
                    '/img/roster/questionnaire.png',
                    ['alt' => 'Личные данные', 'title' => 'Личные данные']
                ),
                ['user/questionnaire'],
                ['class' => 'no-underline']
            ); ?>
        <?php endif; ?>
    </div>
    <?php foreach ($national->latestGame() as $item) : ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
            <?= FormatHelper::asDatetime($item->schedule->schedule_date); ?>
            -
            <?= $item->schedule->tournamentType->tournament_type_name; ?>
            -
            <?= $item->game_home_national_id == $national->national_id ? 'Д' : 'Г'; ?>
            -
            <?= Html::a(
                $item->game_home_national_id == $national->national_id ? $item->nationalGuest->country->country_name : $item->nationalHome->country->country_name,
                ['national/view', 'id' => $item->game_home_national_id == $national->national_id ? $item->game_guest_national_id : $item->game_home_national_id]
            ); ?>
            -
            <?= Html::a(
                $item->game_home_national_id == $national->national_id ? $item->game_home_score . ':' . $item->game_guest_score : $item->game_guest_score . ':' . $item->game_home_score,
                ['game/view', 'id' => $item->game_id]
            ); ?>
        </div>
    <?php endforeach; ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row text-size-4">&nbsp;</div>
    </div>
    <?php foreach ($national->nearestGame() as $item) : ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
            <?= FormatHelper::asDatetime($item->schedule->schedule_date); ?>
            -
            <?= $item->schedule->tournamentType->tournament_type_name; ?>
            -
            <?= $item->game_home_national_id == $national->national_id ? 'Д' : 'Г'; ?>
            -
            <?= Html::a(
                $item->game_home_national_id == $national->national_id ? $item->nationalGuest->country->country_name : $item->nationalHome->country->country_name,
                ['national/view', 'id' => $item->game_home_national_id == $national->national_id ? $item->game_guest_national_id : $item->game_home_national_id]
            ); ?>
            -
            <?php if ($national->myTeam()) : ?>
                <?= Html::a(
                    (($item->game_home_national_id == $national->national_id && $item->game_home_tactic_id_1)
                        || ($item->game_guest_national_id == $national->national_id && $item->game_guest_tactic_id_1))
                        ? 'Ред.'
                        : 'Отпр.',
                    ['lineup/view', 'id' => $item->game_id]
                ); ?>
            <?php else: ?>
                <?= Html::a(
                    '?:?',
                    ['game/preview', 'id' => $item->game_id]
                ); ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
