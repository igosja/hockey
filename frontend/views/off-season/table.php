<?php

use common\components\ErrorHelper;
use common\models\OffSeason;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var array $countryArray
 * @var int $countryId
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array $seasonArray
 * @var int $seasonId
 * @var \common\models\User $user
 */

$user = Yii::$app->user->identity;

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Кубок межсезонья</h1>
    </div>
</div>
<?= Html::beginForm(['off-season/table'], 'get'); ?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
        <?= Html::label('Сезон', 'seasonId'); ?>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
        <?= Html::dropDownList(
            'seasonId',
            $seasonId,
            $seasonArray,
            ['class' => 'form-control submit-on-change', 'id' => 'seasonId']
        ); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
        <?= Html::label('Страна', 'countryId'); ?>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
        <?= Html::dropDownList(
            'countryId',
            $countryId,
            $countryArray,
            ['class' => 'form-control submit-on-change', 'id' => 'countryId', 'prompt' => 'Все']
        ); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
</div>
<?= Html::endForm(); ?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'М',
                'footerOptions' => ['title' => 'Место'],
                'header' => 'М',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Место'],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_place;
                }
            ],
            [
                'footer' => 'Команда',
                'format' => 'raw',
                'header' => 'Команда',
                'value' => function (OffSeason $model): string {
                    return $model->team->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'И',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Игры'],
                'header' => 'И',
                'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Игры'],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_game;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'B',
                'footerOptions' => ['title' => 'Победы'],
                'header' => 'B',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы'],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_win;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ВО',
                'footerOptions' => ['title' => 'Победы в овертайте'],
                'header' => 'ВО',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы в овертайте'],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_win_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ВБ',
                'footerOptions' => ['title' => 'Победы по буллитам'],
                'header' => 'ВБ',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы по буллитам'],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_win_shootout;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ПБ',
                'footerOptions' => ['title' => 'Поражения по буллитам'],
                'header' => 'ПБ',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения по буллитам'],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_loose_shootout;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ПО',
                'footerOptions' => ['title' => 'Поражения в овертайте'],
                'header' => 'ПО',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения в овертайте'],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_loose_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'П',
                'footerOptions' => ['title' => 'Поражения'],
                'header' => 'П',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения'],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_loose;
                }
            ],
            [
                'contentOptions' => ['class' => 'col-5 hidden-xs text-center'],
                'footer' => 'Ш',
                'footerOptions' => ['class' => 'hidden-xs', 'colspan' => 2, 'title' => 'Шайбы'],
                'header' => 'Ш',
                'headerOptions' => ['class' => 'hidden-xs', 'colspan' => 2, 'title' => 'Шайбы'],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_score;
                }
            ],
            [
                'contentOptions' => ['class' => 'col-5 hidden-xs text-center'],
                'footer' => 'Ш',
                'footerOptions' => ['style' => ['display' => 'none']],
                'header' => 'Ш',
                'headerOptions' => ['style' => ['display' => 'none']],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_pass;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'О',
                'footerOptions' => ['title' => 'Очки'],
                'header' => 'О',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Очки'],
                'value' => function (OffSeason $model): string {
                    return $model->off_season_point;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Vs',
                'footerOptions' => ['title' => 'Рейтинг силы команды'],
                'header' => 'Vs',
                'headerOptions' => ['class' => 'col-5', 'title' => 'Рейтинг силы команды'],
                'value' => function (OffSeason $model): string {
                    return $model->team->team_power_vs;
                },
                'visible' => $user->isVip(),
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
