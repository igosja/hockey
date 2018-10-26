<?php

use common\components\ErrorHelper;
use common\models\Schedule;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array $seasonArray
 * @var int $seasonId
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Рассписание</h1>
    </div>
</div>
<?= Html::beginForm('', 'get'); ?>
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
<?= Html::endForm(); ?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Дата',
                'header' => 'Дата',
                'headerOptions' => ['class' => 'col-20'],
                'value' => function (Schedule $model): string {
                    return Yii::$app->formatter->asDate($model->schedule_date, 'short');
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Турнир',
                'format' => 'raw',
                'header' => 'Турнир',
                'value' => function (Schedule $model): string {
                    return Html::a(
                        $model->tournamentType->tournament_type_name,
                        ['schedule/view', 'id' => $model->schedule_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Стадия',
                'footerOptions' => ['class' => 'hidden-xs'],
                'header' => 'Стадия',
                'headerOptions' => ['class' => 'col-20 hidden-xs'],
                'value' => function (Schedule $model): string {
                    return $model->stage->stage_name;
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
<?= $this->render('/site/_show-full-table'); ?>
