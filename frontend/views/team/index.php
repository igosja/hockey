<?php

use common\components\ErrorHelper;
use common\models\Team;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var Team $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Команды
        </h1>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-1'],
                'value' => function (Team $model) {
                    return Html::a(
                        Html::img(
                            '/img/country/12/' . $model->stadium->city->city_country_id . '.png',
                            [
                                'alt' => $model->stadium->city->country->country_name,
                                'title' => $model->stadium->city->country->country_name,
                            ]
                        ),
                        ['country/team', 'id' => $model->stadium->city->city_country_id]
                    );
                }
            ],
            [
                'attribute' => 'country',
                'footer' => $model->getAttributeLabel('country'),
                'format' => 'raw',
                'value' => function (Team $model) {
                    return Html::a(
                        $model->stadium->city->country->country_name,
                        ['country/team', 'id' => $model->stadium->city->city_country_id]
                    );
                }
            ],
            [
                'attribute' => 'count_team',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'col-25'],
                'footer' => $model->getAttributeLabel('count_team'),
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
