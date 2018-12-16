<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Player;
use common\models\Team;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var bool $onBuilding
 * @var Team $team
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
                Тренировочный центр
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Уровень:
                <span class="strong"><?= $team->baseTraining->base_training_level; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Скорость тренировки:
                <span class="strong"><?= $team->baseTraining->base_training_training_speed_min; ?>%</span>
                -
                <span class="strong"><?= $team->baseTraining->base_training_training_speed_max; ?>%</span>
                за тур
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Осталось тренировок силы:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseTraining->base_training_power_count; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Осталось спецвозможностей:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseTraining->base_training_special_count; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Осталось совмещений:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseTraining->base_training_position_count; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center <?php if ($onBuilding) : ?>del<?php endif; ?>">
        <span class="strong">Стоимость тренировок:</span>
        Балл силы
        <span class="strong">
            <?= FormatHelper::asCurrency($team->baseTraining->base_training_power_price); ?>
        </span>
        Спецвозможность
        <span class="strong">
            <?= FormatHelper::asCurrency($team->baseTraining->base_training_special_price); ?>
        </span>
        Совмещение
        <span class="strong">
            <?= FormatHelper::asCurrency($team->baseTraining->base_training_position_price); ?>
        </span>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в тренировочном центре</span> -
        вы можете назначить тренировки силы, спецвозможностей или совмещений своим игрокам:
    </div>
</div>
<?= Html::beginForm(['training/index']); ?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Игрок',
                'format' => 'raw',
                'label' => 'Игрок',
                'value' => function (Player $model): string {
                    return $model->playerLink();
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Нац',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Национальность'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Национальность'],
                'label' => 'Нац',
                'value' => function (Player $model): string {
                    return $model->country->countryImage();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Возраст'],
                'label' => 'В',
                'value' => function (Player $model): string {
                    return $model->player_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Номинальная сила'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-10', 'title' => 'Номинальная сила'],
                'label' => 'С',
                'value' => function (Player $model): string {
                    $result = $model->player_power_nominal;
                    if ($model->player_date_no_action < time()) {
                        $result = $result
                            . ' '
                            . Html::checkbox('power[' . $model->player_id . ']');
                    }
                    return $result;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-15', 'title' => 'Позиция'],
                'label' => 'Поз',
                'value' => function (Player $model): string {
                    $result = '<div class="row"><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">'
                        . $model->position()
                        . '</div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
                    if ($model->player_date_no_action < time()) {
                        $result = $result . ' ' . $model->trainingPositionDropDownList();
                    }
                    $result = $result . '</div></div>';
                    return $result;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Спец',
                'footerOptions' => ['title' => 'Спецвозможности'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-15', 'title' => 'Спецвозможности'],
                'label' => 'Спец',
                'value' => function (Player $model): string {
                    $result = '<div class="row"><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">'
                        . $model->special()
                        . '</div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
                    if ($model->player_date_no_action < time()) {
                        $result = $result . ' ' . $model->trainingSpecialDropDownList();
                    }
                    $result = $result . '</div></div>';
                    return $result;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'showFooter' => true,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Продолжить', ['class' => 'btn margin']); ?>
    </div>
</div>
<?= Html::endForm(); ?>
<?= $this->render('//site/_show-full-table'); ?>
