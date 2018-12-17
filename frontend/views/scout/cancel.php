<?php

use common\components\FormatHelper;
use yii\helpers\Html;

/**
 * @var int $id
 * @var \common\models\Team $team
 * @var \common\models\Scout $scout
 * @var \yii\web\View $this
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Скаут центр
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Уровень:
                <span class="strong"><?= $team->baseScout->base_scout_level; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Скорость изучения:
                <span class="strong"><?= $team->baseScout->base_scout_scout_speed_min; ?>%</span>
                -
                <span class="strong"><?= $team->baseScout->base_scout_scout_speed_max; ?>%</span>
                за тур
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось изучений стилей:
                <span class="strong"><?= $team->availableScout(); ?></span>
                из
                <span class="strong"><?= $team->baseScout->base_scout_my_style_count; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <span class="strong">Стоимость изучения:</span>
        Стиля
        <span class="strong">
            <?= FormatHelper::asCurrency($team->baseScout->base_scout_my_style_price); ?>
        </span>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в скаут центре</span> -
        вы можете изучить любимые стили игроков:
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Будут отменены следующие изучения:
        <ul>
            <li>
                <?= $scout->player->playerName(); ?> - любимый стиль
            </li>
        </ul>
        Общая компенсация за отмену тренировок
        <span class="strong"><?= FormatHelper::asCurrency($team->baseScout->base_scout_my_style_price); ?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::a('Отменить изучение', ['scout/cancel', 'id' => $id, 'ok' => 1], ['class' => 'btn margin']); ?>
        <?= Html::a('Отказаться', ['scout/index'], ['class' => 'btn margin']); ?>
    </div>
</div>
