<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\Game;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var ActiveDataProvider $dataProvider
 * @var Game $game
 * @var int $draw
 * @var int $loose
 * @var int $pass
 * @var int $score
 * @var int $win
 */

?>
<?php if ($game->game_played) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
            <?= Html::a('Результат', ['game/view', 'id' => Yii::$app->request->get('id')]); ?>
            |
            <span class="strong">Перед матчем</span>
        </div>
    </div>
<?php endif; ?>
    <div class="row <?php if (!$game->game_played) : ?>margin-top<?php endif; ?>">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
                            <?= HockeyHelper::teamOrNationalLink($game->teamHome, $game->nationalHome, false, true, 'img'); ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
                            <?= HockeyHelper::teamOrNationalLink($game->teamGuest, $game->nationalGuest, false, true, 'img'); ?>
                        </div>
                    </th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
            <?php if (file_exists(Yii::getAlias('@webroot') . '/img/team/125/' . $game->teamHome->team_id . '.png')) : ?>
                <?= Html::img(
                    '/img/team/125/' . $game->teamHome->team_id . '.png?v=' . filemtime(Yii::getAlias('@webroot') . '/img/team/125/' . $game->teamHome->team_id . '.png'),
                    [
                        'alt' => $game->teamHome->team_name,
                        'class' => 'team-logo-game',
                        'title' => $game->teamHome->team_name,
                    ]
                ); ?>
            <?php endif; ?>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-center">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <?= FormatHelper::asDatetime($game->schedule->schedule_date); ?>,
                    <?= $game->tournamentLink(); ?>
                </div>
            </div>
            <?php if ($game->stadium) : ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <?= Html::a($game->stadium->stadium_name, ['team/view', 'id' => $game->stadium->team->team_id]); ?>
                        (<?= $game->game_played ? $game->game_stadium_capacity : $game->stadium->stadium_capacity; ?>)
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
            <?php if (file_exists(Yii::getAlias('@webroot') . '/img/team/125/' . $game->teamGuest->team_id . '.png')) : ?>
                <?= Html::img(
                    '/img/team/125/' . $game->teamGuest->team_id . '.png?v=' . filemtime(Yii::getAlias('@webroot') . '/img/team/125/' . $game->teamGuest->team_id . '.png'),
                    [
                        'alt' => $game->teamGuest->team_name,
                        'class' => 'team-logo-game',
                        'title' => $game->teamGuest->team_name,
                    ]
                ); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    Прогноз на матч
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 table-responsive">
                    <?php if ($game->teamHome->team_id) : ?>
                        <table class="table table-bordered">
                            <tr>
                                <td
                                        class="text-center
                                <?php if ($game->teamHome->team_power_vs > $game->teamGuest->team_power_vs) : ?>
                                    font-green
                                <?php elseif ($game->teamHome->team_power_vs < $game->teamGuest->team_power_vs) : ?>
                                    font-red
                                <?php endif; ?>"
                                >
                                    <?= $game->teamHome->team_power_vs; ?>
                                </td>
                                <td
                                        class="text-center
                                <?php if ($game->teamHome->team_power_vs < $game->teamGuest->team_power_vs) : ?>
                                    font-green
                                <?php elseif ($game->teamHome->team_power_vs > $game->teamGuest->team_power_vs) : ?>
                                    font-red
                                <?php endif; ?>"
                                >
                                    <?= $game->teamGuest->team_power_vs; ?>
                                </td>
                            </tr>
                        </table>
                    <?php else: ?>
                        <table class="table table-bordered">
                            <tr>
                                <td
                                        class="text-center
                                <?php if ($game->nationalHome->national_power_vs > $game->nationalGuest->national_power_vs) : ?>
                                    font-green
                                <?php elseif ($game->nationalHome->national_power_vs < $game->nationalGuest->national_power_vs) : ?>
                                    font-red
                                <?php endif; ?>"
                                >
                                    <?= $game->nationalHome->national_power_vs; ?>
                                </td>
                                <td
                                        class="text-center
                                <?php if ($game->nationalHome->national_power_vs < $game->nationalGuest->national_power_vs) : ?>
                                    font-green
                                <?php elseif ($game->nationalHome->national_power_vs > $game->nationalGuest->national_power_vs) : ?>
                                    font-red
                                <?php endif; ?>"
                                >
                                    <?= $game->nationalGuest->national_power_vs; ?>
                                </td>
                            </tr>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php

        try {
            $columns = [
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footerOptions' => ['class' => 'hidden'],
                    'header' => 'Дата',
                    'headerOptions' => ['class' => 'col-15'],
                    'value' => function (Game $model) {
                        return FormatHelper::asDate($model->schedule->schedule_date);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footerOptions' => ['class' => 'hidden'],
                    'header' => 'Турнир',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Game $model) {
                        return $model->schedule->tournamentType->tournament_type_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footerOptions' => ['class' => 'hidden'],
                    'header' => 'Стадия',
                    'headerOptions' => ['class' => 'col-15 hidden-xs'],
                    'value' => function (Game $model) {
                        return $model->schedule->stage->stage_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footerOptions' => ['class' => 'hidden'],
                    'format' => 'raw',
                    'header' => 'Игра',
                    'value' => function (Game $model) {
                        return HockeyHelper::teamOrNationalLink($model->teamHome, $model->nationalHome, false)
                            . ' - '
                            . HockeyHelper::teamOrNationalLink($model->teamGuest, $model->nationalGuest, false);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '+' . $win . ' =' . $draw . ' -' . $loose . ' (' . $score . ':' . $pass . ')',
                    'footerOptions' => ['colspan' => '5'],
                    'format' => 'raw',
                    'header' => 'Счёт',
                    'headerOptions' => ['class' => 'col-10'],
                    'value' => function (Game $model) {
                        return Html::a(
                            HockeyHelper::formatScore($model, 'home'),
                            ['game/view', 'id' => $model->game_id]
                        );
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
<?= $this->render('//site/_show-full-table'); ?>