<?php

use common\components\ErrorHelper;
use common\models\Player;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 */

print $this->render('_team-top');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_team-links'); ?>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'player',
                'footer' => 'Player',
                'format' => 'raw',
                'value' => function (Player $model) {
                    return Html::a(
                            $model->playerName(),
                            ['player/view', 'id' => $model->player_id]
                        )
                        . $model->iconPension()
                        . $model->iconInjury()
                        . $model->iconNational()
                        . $model->iconDeal()
                        . $model->iconTraining();
                }
            ],
            [
                'attribute' => 'country',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Country',
                'format' => 'raw',
                'value' => function (Player $model) {
                    return Html::a(
                        Html::img(
                            '/img/country/12/' . $model->country->country_id . '.png',
                            [
                                'alt' => $model->country->country_name,
                                'title' => $model->country->country_name,
                            ]
                        ),
                        ['country/team', 'id' => $model->country->country_id]
                    );
                }
            ],
            [
                'attribute' => 'position',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Position',
                'value' => function (Player $model) {
                    return $model->position();
                }
            ],
            [
                'attribute' => 'age',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Age',
                'value' => function (Player $model) {
                    return $model->player_age;
                }
            ],
            [
                'attribute' => 'power',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Power',
                'value' => function (Player $model) {
                    return $model->player_power_nominal;
                }
            ],
            [
                'attribute' => 'tire',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Tire',
                'value' => function (Player $model) {
                    return $model->player_tire;
                }
            ],
            [
                'attribute' => 'physical',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Physical',
                'format' => 'raw',
                'value' => function (Player $model) {
                    return Html::img(
                        '/img/physical/' . $model->physical->physical_id . '.png',
                        [
                            'alt' => $model->physical->physical_name,
                            'title' => $model->physical->physical_name,
                        ]
                    );
                }
            ],
            [
                'attribute' => 'power_real',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Power Real',
                'value' => function (Player $model) {
                    return $model->player_power_real;
                }
            ],
            [
                'attribute' => 'special',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Special',
                'value' => function (Player $model) {
                    return $model->special();
                }
            ],
            [
                'attribute' => 'plus_minus',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Special',
                'value' => function (Player $model) {
                    return $model->statisticPlayer->statistic_player_plus_minus ?? 0;
                }
            ],
            [
                'attribute' => 'game',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Special',
                'value' => function (Player $model) {
                    return $model->statisticPlayer->statistic_player_game ?? 0;
                }
            ],
            [
                'attribute' => 'score',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Special',
                'value' => function (Player $model) {
                    return $model->statisticPlayer->statistic_player_score ?? 0;
                }
            ],
            [
                'attribute' => 'assist',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Special',
                'value' => function (Player $model) {
                    return $model->statisticPlayer->statistic_player_assist ?? 0;
                }
            ],
            [
                'attribute' => 'price',
                'contentOptions' => ['class' => 'hidden-xs text-right'],
                'footer' => 'Price',
                'value' => function (Player $model) {
                    return Yii::$app->formatter->asCurrency($model->player_price, 'USD');
                }
            ],
            [
                'attribute' => 'style',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Style',
                'format' => 'raw',
                'value' => function (Player $model) {
                    return $model->iconStyle(true);
                }
            ],
            [
                'attribute' => 'game_row',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Game Row',
                'value' => function (Player $model) {
                    return $model->player_game_row;
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
        <?= $this->render('_team-links'); ?>
    </div>
</div>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Show full table
        </a>
    </div>
</div>