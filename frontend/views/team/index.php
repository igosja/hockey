<?php

use common\components\ErrorHelper;
use common\models\Team;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Команды</h1>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Страна',
                'format' => 'raw',
                'label' => 'Страна',
                'value' => function (Team $model): string {
                    return $model->stadium->city->country->countryImage()
                        . ' ' . Html::a(
                            $model->stadium->city->country->country_name,
                            ['country/team', 'id' => $model->stadium->city->country->country_id]
                        );
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Команды',
                'headerOptions' => ['class' => 'col-25'],
                'label' => 'Команды',
                'value' => function (Team $model): int {
                    return $model->count_team;
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
