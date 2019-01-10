<?php

use common\components\ErrorHelper;
use common\models\Player;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var int $countSchedule
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var bool $onBuilding
 * @var array $playerPhysicalArray
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
                <span class="strong" id="physical-available" data-url="<?= Url::to(['physical/change']); ?>">
                    <?= $team->availablePhysical(); ?>
                </span>
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
                'contentOptions' => function (Player $model) {
                    if ($model->squad) {
                        return ['style' => ['background-color' => '#' . $model->squad->squad_color]];
                    }
                    return [];
                },
                'footer' => 'Игрок',
                'format' => 'raw',
                'label' => 'Игрок',
                'value' => function (Player $model) {
                    return $model->playerLink();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'headerOptions' => ['title' => 'Позиция'],
                'label' => 'Поз',
                'value' => function (Player $model) {
                    return $model->position();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'headerOptions' => ['title' => 'Возраст'],
                'label' => 'В',
                'value' => function (Player $model) {
                    return $model->player_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Номинальная сила'],
                'headerOptions' => ['title' => 'Номинальная сила'],
                'label' => 'С',
                'value' => function (Player $model) {
                    return $model->player_power_nominal;
                }
            ],
        ];

        for ($i = 0; $i < $countSchedule; $i++) {
            $columns[] = [
                'contentOptions' => function (Player $model) use ($i, $playerPhysicalArray) {
                    return [
                        'class' => 'text-center ' . $playerPhysicalArray[$model->player_id][$i]['class'],
                        'data' => [
                            'physical' => $playerPhysicalArray[$model->player_id][$i]['physical_id'],
                            'player' => $playerPhysicalArray[$model->player_id][$i]['player_id'],
                            'schedule' => $playerPhysicalArray[$model->player_id][$i]['schedule_id'],
                        ],
                        'id' => $playerPhysicalArray[$model->player_id][$i]['id'],
                    ];
                },
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
                        'stage' => $scheduleArray[$i]->stage->stage_name,
                        'tournament' => $scheduleArray[$i]->tournamentType->tournament_type_name,
                    ],
                    [
                        'alt' => $scheduleArray[$i]->tournamentType->tournament_type_name . ' ' . $scheduleArray[$i]->stage->stage_name,
                        'title' => $scheduleArray[$i]->tournamentType->tournament_type_name . ' ' . $scheduleArray[$i]->stage->stage_name,
                    ]
                ),
                'value' => function (Player $model) use ($playerPhysicalArray, $i) {
                    return Html::img(
                        '/img/physical/' . $playerPhysicalArray[$model->player_id][$i]['physical_id'] . '.png',
                        [
                            'alt' => $playerPhysicalArray[$model->player_id][$i]['physical_name'],
                            'title' => $playerPhysicalArray[$model->player_id][$i]['physical_name'],
                        ]
                    );
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
