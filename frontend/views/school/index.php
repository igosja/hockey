<?php

use common\components\ErrorHelper;
use common\models\Player;
use common\models\Team;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var Team $team
 * @var \yii\web\View $this
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team, 'teamId' => $team->team_id]); ?>
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
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseSchool->base_school_player_count; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Из них со спецвозможностью:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseSchool->base_school_with_special; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Из них со стилем:
                <span class="strong"><?= 0; ?></span>
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
                'headerOptions' => ['class' => 'col-10', 'title' => 'Номинальная сила'],
                'label' => 'С',
                'value' => function (Player $model): string {
                    return $model->player_power_nominal;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'headerOptions' => ['class' => 'col-15', 'title' => 'Позиция'],
                'label' => 'Поз',
                'value' => function (Player $model): string {
                    return $model->position();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Спец',
                'footerOptions' => ['title' => 'Спецвозможности'],
                'headerOptions' => ['class' => 'col-15', 'title' => 'Спецвозможности'],
                'label' => 'Спец',
                'value' => function (Player $model): string {
                    return $model->special();
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
<?= $this->render('/site/_show-full-table'); ?>
