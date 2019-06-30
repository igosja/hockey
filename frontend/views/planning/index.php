<?php

use common\components\ErrorHelper;
use common\models\Player;
use common\models\Schedule;
use common\models\Team;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var int $countSchedule
 * @var ActiveDataProvider $dataProvider
 * @var bool $onBuilding
 * @var array $opponentArray
 * @var array $playerTireArray
 * @var Schedule[] $scheduleArray
 * @var Team $team
 * @var View $this
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Планирование усталости
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Центр физподготовки:
                <span class="strong"><?= $team->basePhysical->base_physical_level; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Бонус к изменению усталости:
                <span class="strong"><?= $team->basePhysical->base_physical_tire_bonus; ?>%</span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Медицинский центр:
                <span class="strong"><?= $team->baseMedical->base_medical_level; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Базовый уровень усталости:
                <span class="strong"><?= $team->baseMedical->base_medical_base_level; ?>%</span>
            </div>
        </div>
        <span class="strong" id="planning-available" data-url="<?= Url::to(['planning/change']); ?>">
        </span>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь вы можете <span class="strong">планировать усталость</span> своих игроков на протяжении сезона:
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'squad',
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
                'attribute' => 'position',
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
                'attribute' => 'age',
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
                'attribute' => 'power',
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
                'contentOptions' => function (Player $model) use ($i, $playerTireArray) {
                    return [
                        'class' => 'text-center ' . $playerTireArray[$model->player_id][$i]['class'],
                        'data' => [
                            'tire' => $playerTireArray[$model->player_id][$i]['tire'],
                            'age' => $playerTireArray[$model->player_id][$i]['age'],
                            'game_row' => $playerTireArray[$model->player_id][$i]['game_row'],
                            'game_row_old' => $playerTireArray[$model->player_id][$i]['game_row_old'],
                            'player' => $playerTireArray[$model->player_id][$i]['player_id'],
                            'schedule' => $playerTireArray[$model->player_id][$i]['schedule_id'],
                        ],
                        'id' => $playerTireArray[$model->player_id][$i]['id'],
                    ];
                },
                'footer' => Html::img(
                    [
                        'planning/image',
                        'team' => $opponentArray[$i],
                    ],
                    [
                        'alt' => $opponentArray[$i],
                        'title' => $opponentArray[$i],
                    ]
                ),
                'format' => 'raw',
                'header' => Html::img(
                    [
                        'planning/image',
                        'stage' => $scheduleArray[$i]->stage->stage_name,
                        'tournament' => $scheduleArray[$i]->tournamentType->tournament_type_name,
                    ],
                    [
                        'alt' => $scheduleArray[$i]->tournamentType->tournament_type_name . ' ' . $scheduleArray[$i]->stage->stage_name,
                        'title' => $scheduleArray[$i]->tournamentType->tournament_type_name . ' ' . $scheduleArray[$i]->stage->stage_name,
                    ]
                ),
                'value' => function (Player $model) use ($playerTireArray, $i) {
                    return $playerTireArray[$model->player_id][$i]['tire'];
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
