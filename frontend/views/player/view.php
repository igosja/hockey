<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Lineup;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\Player $player
 * @var array $seasonArray
 * @var int $seasonId
 * @var \yii\web\View $this
 */

print $this->render('_player', ['player' => $player]);

?>
<?= Html::beginForm('', 'get'); ?>
<div class="row margin-top-small">
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        <?= $this->render('//player/_links'); ?>
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
                    'label' => 'Дата',
                    'value' => function (Lineup $model): string {
                        return Yii::$app->formatter->asDate($model->game->schedule->schedule_date, 'short');
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Матч',
                    'format' => 'raw',
                    'label' => 'Матч',
                    'value' => function (Lineup $model): string {
                        return $model->game->teamOrNationalLink('home', false)
                            . '-'
                            . $model->game->teamOrNationalLink('guest', false);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Сч',
                    'footerOptions' => ['title' => 'Счёт'],
                    'format' => 'raw',
                    'headerOptions' => ['title' => 'Счёт'],
                    'label' => 'Сч',
                    'value' => function (Lineup $model): string {
                        return Html::a(
                            $model->game->formatScore(),
                            ['game/view', 'id' => $model->game->game_id]
                        );
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Тип матча',
                    'label' => 'Тип матча',
                    'value' => function (Lineup $model): string {
                        return $model->game->schedule->tournamentType->tournament_type_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Стадия',
                    'label' => 'Стадия',
                    'value' => function (Lineup $model): string {
                        return $model->game->schedule->stage->stage_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Поз',
                    'footerOptions' => ['title' => 'Позиция'],
                    'headerOptions' => ['title' => 'Позиция'],
                    'label' => 'Поз',
                    'value' => function (Lineup $model): string {
                        return $model->position->position_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['title' => 'Сила'],
                    'headerOptions' => ['title' => 'Сила'],
                    'label' => 'С',
                    'value' => function (Lineup $model): string {
                        return $model->lineup_power_real;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Ш',
                    'footerOptions' => ['title' => 'Шайбы'],
                    'headerOptions' => ['title' => 'Шайбы'],
                    'label' => 'Ш',
                    'value' => function (Lineup $model): string {
                        return $model->lineup_score;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'П',
                    'footerOptions' => ['title' => 'Голевые передачи'],
                    'headerOptions' => ['title' => 'Голевые передачи'],
                    'label' => 'П',
                    'value' => function (Lineup $model): string {
                        return $model->lineup_score;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '+/-',
                    'footerOptions' => ['title' => 'Плюс/минус'],
                    'headerOptions' => ['title' => 'Плюс/минус'],
                    'label' => '+/-',
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
                'emptyText' => false,
                'showFooter' => true,
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

