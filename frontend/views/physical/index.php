<?php

use common\components\ErrorHelper;
use common\models\Player;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var bool $onBuilding
 * @var \common\models\Schedule[] $scheduleArray
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
                Центр физподготовки
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Уровень:
                <span class="strong"><?= $team->basePhysical->base_physical_level; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Бонус к изменению усталости:
                <span class="strong"><?= $team->basePhysical->base_physical_tire_bonus; ?>%</span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Осталось изменений формы:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->basePhysical->base_physical_change_count; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в физцентре</span> -
        вы можете поменять физическую форму для игроков своей команды:
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
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'headerOptions' => ['title' => 'Позиция'],
                'label' => 'Поз',
                'value' => function (Player $model): string {
                    return $model->position();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'headerOptions' => ['title' => 'Возраст'],
                'label' => 'В',
                'value' => function (Player $model): string {
                    return $model->player_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Номинальная сила'],
                'headerOptions' => ['title' => 'Номинальная сила'],
                'label' => 'С',
                'value' => function (Player $model): string {
                    return $model->player_power_nominal;
                }
            ],
        ];

        foreach ($scheduleArray as $item) {
            $columns[] = [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => Html::img(
                    [
                        'physical/image',
                        'team' => $team->team_name,
                    ],
                    [
                        'alt' => $team->team_name,
                        'title' => $team->team_name,
                    ]
                ),
                'format' => 'raw',
                'header' => Html::img(
                    [
                        'physical/image',
                        'stage' => $item->stage->stage_name,
                        'tournament' => $item->tournamentType->tournament_type_name,
                    ],
                    [
                        'alt' => $item->tournamentType->tournament_type_name . ' ' . $item->stage->stage_name,
                        'title' => $item->tournamentType->tournament_type_name . ' ' . $item->stage->stage_name,
                    ]
                ),
                'value' => function (Player $model): string {
                    return '?';
                }
            ];
        }
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
<?= $this->render('//site/_show-full-table'); ?>
