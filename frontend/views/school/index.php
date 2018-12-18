<?php

use common\models\School;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var bool $onBuilding
 * @var array $positionArray
 * @var \common\models\School[] $schoolArray
 * @var array $specialArray
 * @var array $styleArray
 * @var \common\models\Team $team
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Уровень:
                <span class="strong"><?= $team->baseSchool->base_school_level; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Время подготовки игрока:
                <span class="strong"><?= $team->baseSchool->base_school_school_speed; ?></span> туров
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Осталось юниоров:
                <span class="strong"><?= $team->availableSchool(); ?></span>
                из
                <span class="strong"><?= $team->baseSchool->base_school_player_count; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Из них со спецвозможностью:
                <span class="strong"><?= $team->availableSchoolWithSpecial(); ?></span>
                из
                <span class="strong"><?= $team->baseSchool->base_school_with_special; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
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
<?php if ($schoolArray) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            Сейчас происходит подготовка юниора:
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Игрок</th>
                    <th class="col-1 hidden-xs" title="Национальность">Нац</th>
                    <th class="col-10" title="Позиция">Поз</th>
                    <th class="col-5" title="Возраст">В</th>
                    <th class="col-15" title="Спецвозможности">Спец</th>
                    <th class="col-15">Стиль</th>
                    <th class="col-15">Осталось туров</th>
                    <th class="col-1"></th>
                </tr>
                <?php foreach ($schoolArray as $item) : ?>
                    <tr>
                        <td>Молодой игрок</td>
                        <td class="hidden-xs text-center">
                            <?= $team->stadium->city->country->countryImageLink(); ?>
                        </td>
                        <td class="text-center"><?= $item->position->position_name; ?></td>
                        <td class="text-center"><?= School::AGE; ?></td>
                        <td class="text-center"><?= $item->special->special_name; ?></td>
                        <td class="text-center"><?= $item->school_with_style ? $item->style->style_name : '?'; ?></td>
                        <td class="text-center"><?= $item->scout_percent; ?>%</td>
                        <td class="text-center">
                            <?= Html::a(
                                '<i class="fa fa-times-circle"></i>',
                                ['school/cancel', 'id' => $item->school_id],
                                ['title' => 'Отменить подготовку игрока']
                            ); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th>Игрок</th>
                    <th class="hidden-xs" title="Национальность">Нац</th>
                    <th title="Позиция">Поз</th>
                    <th title="Возраст">В</th>
                    <th class="col-15" title="Спецвозможности">Спец</th>
                    <th class="col-10">Изучение</th>
                    <th class="col-10" title="Прогресс изучения">%</th>
                    <th></th>
                </tr>
            </table>
        </div>
    </div>
<?php else : ?>
    <?= Html::beginForm(['school/index'], 'get'); ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Игрок</th>
                    <th class="col-1" title="Национальность">Нац</th>
                    <th class="col-5" title="Возраст">В</th>
                    <th class="col-15" title="Позиция">Поз</th>
                    <th class="col-15" title="Спецвозможности">Спец</th>
                    <th class="col-15">Стиль</th>
                </tr>
                <tr>
                    <td>
                        Молодой игрок
                    </td>
                    <td class="text-center">
                        <?= $team->stadium->city->country->countryImageLink(); ?>
                    </td>
                    <td class="text-center"><?= School::AGE; ?></td>
                    <td class="text-center">
                        <?= Html::dropDownList(
                            'School[position_id]',
                            null,
                            $positionArray,
                            ['class' => 'form-control']
                        ); ?>
                    </td>
                    <td class="text-center">
                        <?= Html::dropDownList(
                            'School[special_id]',
                            null,
                            $specialArray,
                            ['class' => 'form-control', 'prompt' => '-']
                        ); ?>
                    </td>
                    <td class="text-center">
                        <?= Html::dropDownList(
                            'School[style_id]',
                            null,
                            $styleArray,
                            ['class' => 'form-control', 'prompt' => '-']
                        ); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <input class="btn margin" type="submit" value="Продолжить"/>
        </div>
    </div>
<?php endif; ?>
