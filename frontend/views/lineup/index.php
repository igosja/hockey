<?php

use common\components\ErrorHelper;
use common\models\Game;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var Game $game
 * @var \common\models\Lineup[] $lineupArray
 * @var array $substitutionArray
 * @var \yii\web\View $this
 */

//$this->render('_country');

?>
    <div class="row margin-top">
        <?php

        try {
            $columns = [
                [
                    'attribute' => 'date',
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function (Game $model) {
                        return Yii::$app->formatter->asDatetime($model->schedule->schedule_date);
                    }
                ],
                [
                    'attribute' => 'tournamentType',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Game $model) {
                        return $model->schedule->tournamentType->tournament_type_name;
                    }
                ],
                [
                    'attribute' => 'stage',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Game $model) {
                        return $model->schedule->stage->stage_name;
                    }
                ],
                [
                    'attribute' => 'homeGuest',
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function (Game $model) {
                        return $model->game_home_team_id;
                    }
                ],
                [
                    'attribute' => 'opponent',
                    'contentOptions' => ['class' => 'text-center'],
                    'format' => 'raw',
                    'value' => function (Game $model) {
                        return Html::a(
                            $model->teamHome->team_name,
                            ['team/view', 'id' => $model->teamHome->team_id],
                            ['target' => '_blank', 'data-pjax' => 0]
                        );
                    }
                ],
                [
                    'attribute' => 'power',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Game $model) {
                        return $model->teamHome->team_power_vs;
                    }
                ],
                [
                    'attribute' => 'preview',
                    'contentOptions' => ['class' => 'text-center'],
                    'format' => 'raw',
                    'value' => function (Game $model) {
                        return Html::a(
                            '?',
                            ['game/preview', 'id' => $model->game_id],
                            ['target' => '_blank', 'data-pjax' => 0]
                        );
                    }
                ],
                [
                    'attribute' => 'lineup',
                    'contentOptions' => ['class' => 'text-center'],
                    'format' => 'raw',
                    'value' => function (Game $model) {
                        return Html::a(
                            '-',
                            ['lineup/index', 'id' => $model->game_id]
                        );
                    }
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $dataProvider,
                'showOnEmpty' => false,
                'summary' => false,
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
    <div class="row hidden-lg hidden-md hidden-sm">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a class="btn show-full-table" href="javascript:">
                Show full table
            </a>
        </div>
    </div>
<?= Html::a('tactic', ['lineup/tactic', 'id' => $game->game_id]); ?>
<?php foreach ($substitutionArray as $line) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Substitution</th>
                    <th>Player</th>
                </tr>
                <?php foreach ($line as $position) : ?>
                    <tr>
                        <td>
                            <?= Html::a(
                                'Change',
                                [
                                    'lineup/substitution',
                                    'id' => $game->game_id,
                                    'position_id' => $position['position_id'],
                                    'line_id' => $position['line_id'],
                                ]
                            ); ?>
                        </td>
                        <td>
                            <?php foreach ($lineupArray as $lineup) : ?>
                                <?php if ($lineup->lineup_position_id == $position['position_id'] && $lineup->lineup_line_id == $position['line_id']) : ?>
                                    <?= Html::a(
                                        $lineup->player->playerName(),
                                        [
                                            'player/view',
                                            'id' => $lineup->player->player_id,
                                        ]
                                    ); ?>
                                    <?php break; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endforeach; ?>