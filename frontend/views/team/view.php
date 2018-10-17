<?php

use common\components\ErrorHelper;
use common\models\Player;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var Player $model
 * @var bool $showHiddenParams
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
                    'footer' => $model->getAttributeLabel('player'),
                    'format' => 'raw',
                    'value' => function (Player $model): string {
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
                    'footer' => $model->getAttributeLabel('country'),
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Player $model): string {
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
                    'footer' => $model->getAttributeLabel('position'),
                    'value' => function (Player $model): string {
                        return $model->position();
                    }
                ],
                [
                    'attribute' => 'age',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => $model->getAttributeLabel('age'),
                    'value' => function (Player $model): string {
                        return $model->player_age;
                    }
                ],
                [
                    'attribute' => 'power_nominal',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => $model->getAttributeLabel('power_nominal'),
                    'value' => function (Player $model): string {
                        return $model->player_power_nominal;
                    }
                ],
                [
                    'attribute' => 'tire',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => $model->getAttributeLabel('tire'),
                    'value' => function (Player $model) use ($showHiddenParams): string {
                        return $showHiddenParams ? $model->player_tire : '?';
                    }
                ],
                [
                    'attribute' => 'physical',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => $model->getAttributeLabel('physical'),
                    'format' => 'raw',
                    'value' => function (Player $model) use ($showHiddenParams): string {
                        return $showHiddenParams ? Html::img(
                            '/img/physical/' . $model->player_physical_id . '.png',
                            [
                                'alt' => $model->physical->physical_name,
                                'title' => $model->physical->physical_name,
                            ]
                        ) : '?';
                    }
                ],
                [
                    'attribute' => 'power_real',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => $model->getAttributeLabel('power_real'),
                    'value' => function (Player $model) use ($showHiddenParams): string {
                        return $showHiddenParams ? $model->player_power_real : '~' . $model->player_power_nominal;
                    }
                ],
                [
                    'attribute' => 'special',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => $model->getAttributeLabel('special'),
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Player $model) use ($showHiddenParams): string {
                        return $model->special();
                    }
                ],
                [
                    'attribute' => 'plus_minus',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => $model->getAttributeLabel('plus_minus'),
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Player $model): string {
                        return $model->statisticPlayer->statistic_player_plus_minus ?? 0;
                    }
                ],
                [
                    'attribute' => 'game',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => $model->getAttributeLabel('game'),
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Player $model): string {
                        return $model->statisticPlayer->statistic_player_game ?? 0;
                    }
                ],
                [
                    'attribute' => 'score',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => $model->getAttributeLabel('score'),
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Player $model): string {
                        return $model->statisticPlayer->statistic_player_score ?? 0;
                    }
                ],
                [
                    'attribute' => 'assist',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => $model->getAttributeLabel('assist'),
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Player $model): string {
                        return $model->statisticPlayer->statistic_player_assist ?? 0;
                    }
                ],
                [
                    'attribute' => 'player_price',
                    'contentOptions' => ['class' => 'hidden-xs text-right'],
                    'footer' => $model->getAttributeLabel('player_price'),
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Player $model) {
                        return Yii::$app->formatter->asCurrency($model->player_price, 'USD');
                    }
                ],
                [
                    'attribute' => 'style',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => $model->getAttributeLabel('style'),
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Player $model): string {
                        return $model->iconStyle(true);
                    }
                ],
                [
                    'attribute' => 'game_row',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => $model->getAttributeLabel('game_row'),
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'value' => function (Player $model): string {
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
<?= $this->render('/site/_show-full-table'); ?>