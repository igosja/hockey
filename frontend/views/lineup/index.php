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

?>
    <div class="row margin-top">
        <?php

        try {
            $columns = [
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'header' => 'Дата',
                    'value' => function (Game $model) {
                        return Yii::$app->formatter->asDatetime($model->schedule->schedule_date);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'header' => 'Турнир',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Game $model) {
                        return $model->schedule->tournamentType->tournament_type_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'header' => 'Стадия',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Game $model) {
                        return $model->schedule->stage->stage_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'value' => function (Game $model) {
                        return $model->game_home_team_id == Yii::$app->controller->myTeam->team_id ? 'Д' : 'Г';
                    }
                ],
                [
                    'attribute' => 'opponent',
                    'contentOptions' => ['class' => 'text-center'],
                    'format' => 'raw',
                    'header' => '',
                    'value' => function (Game $model) {
                        if ($model->game_home_team_id == Yii::$app->controller->myTeam->team_id) {
                            return Html::a(
                                $model->teamGuest->team_name,
                                ['team/view', 'id' => $model->teamGuest->team_id],
                                ['target' => '_blank']
                            );
                        } else {
                            return Html::a(
                                $model->teamHome->team_name,
                                ['team/view', 'id' => $model->teamHome->team_id],
                                ['target' => '_blank']
                            );
                        }
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'header' => 'C/C',
                    'headerOptions' => [
                        'class' => 'hidden-xs',
                        'title' => 'Соотношение сил (чем больше это число, тем сильнее ваш соперник)',
                    ],
                    'value' => function (Game $model) {
                        return $model->teamHome->team_power_vs;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'format' => 'raw',
                    'header' => '',
                    'value' => function (Game $model) {
                        return Html::a(
                            '?',
                            ['game/preview', 'id' => $model->game_id],
                            ['target' => '_blank']
                        );
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'format' => 'raw',
                    'header' => '',
                    'value' => function (Game $model) {
                        return Html::a(
                            $model->game_home_tactic_id_1 ? '+' : '-',
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
<?= $this->render('/site/_show-full-table'); ?>
<?= Html::a('tactic', ['lineup/tactic', 'id' => $game->game_id]); ?>
<?php foreach ($substitutionArray as $line) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Замена</th>
                    <th>Игрок</th>
                </tr>
                <?php foreach ($line as $position) : ?>
                    <tr>
                        <td>
                            <?= Html::a(
                                'Заменить',
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