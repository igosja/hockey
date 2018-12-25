<?php

use yii\helpers\Html;

/**
 * @var int $id
 * @var \common\models\Team $team
 * @var \common\models\School $school
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
                Спортшкола
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Уровень:
                <span class="strong"><?= $team->baseSchool->base_school_level; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Время подготовки игрока:
                <span class="strong"><?= $team->baseSchool->base_school_school_speed; ?></span> туров
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось юниоров:
                <span class="strong"><?= $team->availableSchool(); ?></span>
                из
                <span class="strong"><?= $team->baseSchool->base_school_player_count; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Из них со спецвозможностью:
                <span class="strong"><?= $team->availableSchoolWithSpecial(); ?></span>
                из
                <span class="strong"><?= $team->baseSchool->base_school_with_special; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Из них со стилем:
                <span class="strong"><?= $team->availableSchoolWithStyle(); ?></span>
                из
                <span class="strong"><?= $team->baseSchool->base_school_with_style; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в спортшколе</span> -
        вы можете подготовить молодых игроков для основной команды:
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Будет отменена подготовка юниора:
        <ul>
            <li>позиция - <?= $school->position->position_name; ?></li>
            <li>
                спецвозможность -
                <?= $school->school_with_special ? $school->special->special_name : 'неизвестно'; ?>
            </li>
            <li>стиль - <?= $school->school_with_style ? $school->style->style_name : 'неизвестно'; ?></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::a('Отменить подготовку', ['school/cancel', 'id' => $id, 'ok' => 1], ['class' => 'btn margin']); ?>
        <?= Html::a('Отказаться', ['school/index'], ['class' => 'btn margin']); ?>
    </div>
</div>
