<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Lineup;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array $seasonArray
 * @var int $seasonId
 * @var \yii\web\View $this
 */

print $this->render('_player');

?>
<?= Html::beginForm('', 'get'); ?>
        <div class="row margin-top-small">
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                <?= $this->render('_links'); ?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                        <?= Html::label('Сезон', 'seasonId') ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <?= Html::dropDownList(
                            'season_id',
                            $seasonId,
                            $seasonArray,
                            ['class' => 'form-control submit-on-change', 'id' => 'seasonId']
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
<?= Html::endForm(); ?>
    <div class="row">
        <?php

        try {
            $columns = [
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Дата',
                    'header' => 'Дата',
                    'value' => function (Lineup $model): string {
                        return Yii::$app->formatter->asDate($model->game->schedule->schedule_date, 'short');
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Матч',
                    'format' => 'raw',
                    'header' => 'Матч',
                    'value' => function (Lineup $model): string {
                        return HockeyHelper::teamOrNationalLink(
                                $model->game->teamHome,
                                $model->game->nationalHome,
                                false
                            )
                            . '-'
                            . HockeyHelper::teamOrNationalLink(
                                $model->game->teamGuest,
                                $model->game->nationalGuest,
                                false
                            );
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Сч',
                    'footerOptions' => ['title' => 'Счёт'],
                    'format' => 'raw',
                    'header' => 'Сч',
                    'headerOptions' => ['title' => 'Счёт'],
                    'value' => function (Lineup $model): string {
                        return Html::a(
                            $model->game->game_home_score . ':' . $model->game->game_guest_score,
                            ['game/view', 'id' => $model->game->game_id]
                        );
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Тип матча',
                    'header' => 'Тип матча',
                    'value' => function (Lineup $model): string {
                        return $model->game->schedule->tournamentType->tournament_type_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Стадия',
                    'header' => 'Стадия',
                    'value' => function (Lineup $model): string {
                        return $model->game->schedule->stage->stage_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Поз',
                    'footerOptions' => ['title' => 'Позиция'],
                    'header' => 'Поз',
                    'headerOptions' => ['title' => 'Позиция'],
                    'value' => function (Lineup $model): string {
                        return $model->position->position_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['title' => 'Сила'],
                    'header' => 'С',
                    'headerOptions' => ['title' => 'Сила'],
                    'value' => function (Lineup $model): string {
                        return $model->lineup_power_real;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Ш',
                    'footerOptions' => ['title' => 'Шайбы'],
                    'header' => 'Ш',
                    'headerOptions' => ['title' => 'Шайбы'],
                    'value' => function (Lineup $model): string {
                        return $model->lineup_score;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'П',
                    'footerOptions' => ['title' => 'Голевые передачи'],
                    'header' => 'П',
                    'headerOptions' => ['title' => 'Голевые передачи'],
                    'value' => function (Lineup $model): string {
                        return $model->lineup_score;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '+/-',
                    'footerOptions' => ['title' => 'Плюс/минус'],
                    'header' => '+/-',
                    'headerOptions' => ['title' => 'Плюс/минус'],
                    'value' => function (Lineup $model): string {
                        return HockeyHelper::plusNecessary($model->lineup_plus_minus);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footerOptions' => ['title' => 'Изменение силы'],
                    'format' => 'raw',
                    'headerOptions' => ['title' => 'Изменение силы'],
                    'value' => function (Lineup $model): string {
                        return $model->iconPowerChange();
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
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $this->render('_links'); ?>
        </div>
    </div>
<?= $this->render('/site/_show-full-table'); ?>