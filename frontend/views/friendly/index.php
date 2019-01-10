<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Schedule;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array $scheduleStatusArray
 * @var \common\models\Team $team
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                <?= $team->team_name; ?>
                (<?= $team->stadium->city->city_name; ?>, <?= $team->stadium->city->country->country_name; ?>)
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= Html::a(
                    $team->friendlyStatus->friendly_status_name,
                    ['friendly/status']
                ); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-right text-size-1">
                Организация товарищеских матчей
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        Ближайшие дни товарищеских матчей:
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-25'],
                'label' => 'День',
                'value' => function (Schedule $model) {
                    return Html::a(
                        FormatHelper::asDate($model->schedule_date),
                        ['friendly/view', 'id' => $model->schedule_id]
                    );
                }
            ],
            [
                'format' => 'raw',
                'label' => 'Статус',
                'value' => function (Schedule $model) use ($scheduleStatusArray) {
                    return $scheduleStatusArray[$model->schedule_id];
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'emptyText' => 'В ближаещие дни не запланировано товарищеских матчей.',
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
