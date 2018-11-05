<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Game;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var Game $game
 * @var \yii\data\ActiveDataProvider $dataProvider
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
                            <?= HockeyHelper::teamOrNationalLink($game->teamHome, $game->nationalHome, false); ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
                            <?= HockeyHelper::teamOrNationalLink($game->teamGuest, $game->nationalGuest, false); ?>
                        </div>
                    </th>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?php

            try {
                print Yii::$app->formatter->asDatetime($game->schedule->schedule_date, 'short');
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>,
            <?= $game->tournamentLink(); ?>
        </div>
    </div>
<?php if ($game->stadium) : ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= Html::a($game->stadium->stadium_name, ['team/view', $game->stadium->team->team_id]); ?>
            (<?= $game->stadium->stadium_capacity; ?>)
        </div>
    </div>
<?php endif; ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    Прогноз на матч
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 table-responsive">
                    <?php if ($game->teamHome) : ?>
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
                    'footer' => 'Дата',
                    'header' => 'Дата',
                    'headerOptions' => ['class' => 'col-15'],
                    'value' => function (Game $model): string {
                        return Yii::$app->formatter->asDate($model->schedule->schedule_date, 'short');
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Турнир',
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'header' => 'Турнир',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Game $model): string {
                        return $model->schedule->tournamentType->tournament_type_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Стадия',
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'header' => 'Стадия',
                    'headerOptions' => ['class' => 'col-15 hidden-xs'],
                    'value' => function (Game $model): string {
                        return $model->schedule->stage->stage_name;
                    }
                ],
                [
                    'footer' => 'Игра',
                    'format' => 'raw',
                    'header' => 'Игра',
                    'value' => function (Game $model): string {
                        return HockeyHelper::teamOrNationalLink($model->teamHome, $model->nationalHome, false)
                            . ' - '
                            . HockeyHelper::teamOrNationalLink($model->teamGuest, $model->nationalGuest, false);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Результат',
                    'format' => 'raw',
                    'header' => 'Результат',
                    'headerOptions' => ['class' => 'col-10'],
                    'value' => function (Game $model): string {
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
                'showOnEmpty' => false,
                'summary' => false,
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
<?= $this->render('/site/_show-full-table'); ?>