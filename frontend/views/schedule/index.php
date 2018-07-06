<?php

use common\components\ErrorHelper;
use common\models\Schedule;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\Season[] $season
 * @var integer $seasonId
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Schedule</h1>
    </div>
</div>
<?= Html::beginForm('', 'get'); ?>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
        <?= Html::label('Season:', 'seasonId'); ?>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
        <?= Html::dropDownList(
            'seasonId',
            $seasonId,
            ArrayHelper::map($season, 'season_id', 'season_id'),
            ['class' => 'form-control submit-on-change', 'id' => 'seasonId']
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
                'attribute' => 'schedule_date',
                'contentOptions' => ['class' => 'text-center'],
                'enableSorting' => false,
                'value' => function (Schedule $model) {
                    return Yii::$app->formatter->asDatetime($model->schedule_date);
                }
            ],
            [
                'attribute' => 'tournamentType',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'value' => function (Schedule $model) {
                    return Html::a($model->tournamentType->tournament_type_name, ['view', 'id' => $model->schedule_id]);
                }
            ],
            [
                'attribute' => 'stage',
                'contentOptions' => ['class' => 'text-center'],
                'value' => function (Schedule $model) {
                    return $model->stage->stage_name;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive'],
            'summary' => false,
            'tableOptions' => ['class' => 'table table-bordered table-hover'],
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
