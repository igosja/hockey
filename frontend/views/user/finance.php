<?php

use common\components\ErrorHelper;
use common\models\Finance;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var int $seasonId
 * @var array $seasonArray
 */

print $this->render('_top');

?>
<?= Html::beginForm('', 'get'); ?>
<div class="row margin-top-small">
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        <?= $this->render('_user-links'); ?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <?= Html::label('Сезон', 'season_id') ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <?= Html::dropDownList(
                    'season_id',
                    $seasonId,
                    $seasonArray,
                    ['class' => 'form-control submit-on-change', 'id' => 'season_id']
                ); ?>
            </div>
        </div>
    </div>
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
                'headerOptions' => ['class' => 'col-15'],
                'value' => function (Finance $model) {
                    return Yii::$app->formatter->asDate($model->finance_date, 'short');
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-right'],
                'footer' => 'Было',
                'footerOptions' => ['class' => 'hidden-xs'],
                'header' => 'Было',
                'headerOptions' => ['class' => 'col-10 hidden-xs'],
                'value' => function (Finance $model) {
                    return Yii::$app->formatter->asCurrency($model->finance_value_before, 'USD');
                }
            ],
            [
                'contentOptions' => ['class' => 'text-right'],
                'footer' => '+/-',
                'header' => '+/-',
                'headerOptions' => ['class' => 'col-10'],
                'value' => function (Finance $model) {
                    return Yii::$app->formatter->asCurrency($model->finance_value, 'USD');
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-right'],
                'footer' => 'Стало',
                'footerOptions' => ['class' => 'hidden-xs'],
                'header' => 'Стало',
                'headerOptions' => ['class' => 'col-10 hidden-xs'],
                'value' => function (Finance $model) {
                    return Yii::$app->formatter->asCurrency($model->finance_value_after, 'USD');
                }
            ],
            [
                'footer' => 'Комментарий',
                'format' => 'raw',
                'header' => 'Комментарий',
                'value' => function (Finance $model) {
                    return $model->getText();
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
<?= $this->render('//site/_show-full-table'); ?>
