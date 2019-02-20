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
                'headerOptions' => ['class' => 'col-5', 'title' => 'Место'],
                'label' => 'М',
                'value' => function (OffSeason $model) {
                    return $model->off_season_place;
                }
            ],
            [
                'footer' => 'Команда',
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (OffSeason $model) {
                    return $model->team->iconFreeTeam() . $model->team->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'И',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Игры'],
                'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Игры'],
                'label' => 'И',
                'value' => function (OffSeason $model) {
                    return $model->off_season_game;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'B',
                'footerOptions' => ['title' => 'Победы'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы'],
                'label' => 'B',
                'value' => function (OffSeason $model) {
                    return $model->off_season_win;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ВО',
                'footerOptions' => ['title' => 'Победы в овертайте'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы в овертайте'],
                'label' => 'ВО',
                'value' => function (OffSeason $model) {
                    return $model->off_season_win_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ВБ',
                'footerOptions' => ['title' => 'Победы по буллитам'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Победы по буллитам'],
                'label' => 'ВБ',
                'value' => function (OffSeason $model) {
                    return $model->off_season_win_shootout;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ПБ',
                'footerOptions' => ['title' => 'Поражения по буллитам'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения по буллитам'],
                'label' => 'ПБ',
                'value' => function (OffSeason $model) {
                    return $model->off_season_loose_shootout;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ПО',
                'footerOptions' => ['title' => 'Поражения в овертайте'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения в овертайте'],
                'label' => 'ПО',
                'value' => function (OffSeason $model) {
                    return $model->off_season_loose_overtime;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'П',
                'footerOptions' => ['title' => 'Поражения'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Поражения'],
                'label' => 'П',
                'value' => function (OffSeason $model) {
                    return $model->off_season_loose;
                }
            ],
            [
                'contentOptions' => ['class' => 'col-5 hidden-xs text-center'],
                'footer' => 'ЗШ',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Заброшенные шайбы'],
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Заброшенные шайбы'],
                'label' => 'ЗШ',
                'value' => function (OffSeason $model) {
                    return $model->off_season_score;
                }
            ],
            [
                'contentOptions' => ['class' => 'col-5 hidden-xs text-center'],
                'footer' => 'ПШ',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Пропущенные шайбы'],
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Пропущенные шайбы'],
                'label' => 'ПШ',
                'value' => function (OffSeason $model) {
                    return $model->off_season_pass;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'О',
                'footerOptions' => ['title' => 'Очки'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Очки'],
                'label' => 'О',
                'value' => function (OffSeason $model) {
                    return $model->off_season_point;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Vs',
                'footerOptions' => ['title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Рейтинг силы команды в длительных соревнованиях'],
                'label' => 'Vs',
                'value' => function (OffSeason $model) {
                    return $model->team->team_power_vs;
                },
                'visible' => $user && $user->isVip(),
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
