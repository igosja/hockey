<?php

use common\components\ErrorHelper;
use common\models\Player;
use common\models\Team;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var Player $model
 * @var bool $showHiddenParams
 * @var \yii\web\View $this
 */

$team = Team::find()->where(['team_id' => Yii::$app->request->get('id', 1)])->one();

print $this->render('_team-top');

?>
<div class="row margin-top-small">
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
                'headerOptions' => ['class' => 'hidden-xs col-1'],
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
<div class="row margin-top">
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-size-2">
        <span class="italic">Показатели команды:</span>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Рейтинг силы команды (Vs)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $team->team_power_vs; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 21 лучшего (s21)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $team->team_power_s_21; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 26 лучших (s26)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $team->team_power_s_26; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 32 лучших (s32)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $team->team_power_s_32; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Стоимость строений
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?php

                try {
                    print Yii::$app->formatter->asCurrency($team->team_price_base, 'USD');
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Общая стоимость
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?php

                try {
                    print Yii::$app->formatter->asCurrency($team->team_price_total, 'USD');
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?>
            </div>
        </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs"></div>
    <?php

    /**
     * @var \frontend\controllers\BaseController $controller
     */
    $controller = Yii::$app->controller;

    if ($controller->myTeam) {
        if ($controller->myTeam->team_id == Yii::$app->request->get('id', 1)) {
            print $this->render('_team-bottom-forum');
        } else {
            print $this->render('_team-bottom-my-team');
        }
    }

    ?>
