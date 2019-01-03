<?php

use common\components\ErrorHelper;
use common\models\LeagueDistribution;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

print $this->render('_country');

?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Сезон',
                'headerOptions' => ['class' => 'col-20'],
                'label' => 'Сезон',
                'value' => function (LeagueDistribution $model): string {
                    return $model->league_distribution_season_id;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Групповой этап',
                'headerOptions' => ['class' => 'col-20'],
                'label' => 'Групповой этап',
                'value' => function (LeagueDistribution $model): string {
                    return $model->league_distribution_group;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ОР3',
                'headerOptions' => ['class' => 'col-20'],
                'label' => 'ОР3',
                'value' => function (LeagueDistribution $model): string {
                    return $model->league_distribution_qualification_3;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ОР2',
                'headerOptions' => ['class' => 'col-20'],
                'label' => 'ОР2',
                'value' => function (LeagueDistribution $model): string {
                    return $model->league_distribution_qualification_2;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'ОР1',
                'headerOptions' => ['class' => 'col-20'],
                'label' => 'ОР1',
                'value' => function (LeagueDistribution $model): string {
                    return $model->league_distribution_qualification_1;
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
