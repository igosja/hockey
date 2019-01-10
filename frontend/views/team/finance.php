<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Finance;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var array $seasonArray
 * @var int $seasonId
 * @var \common\models\Team $team
 * @var \yii\web\View $this
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?= $this->render('//team/_team-top-right', ['team' => $team]); ?>
    </div>
</div>
<?= Html::beginForm('', 'get'); ?>
    <div class="row margin-top-small">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <?= $this->render('//team/_team-links'); ?>
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
                'headerOptions' => ['class' => 'col-15'],
                'label' => 'Дата',
                'value' => function (Finance $model) {
                    return FormatHelper::asDate($model->finance_date);
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-right'],
                'footer' => 'Было',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'col-10 hidden-xs'],
                'label' => 'Было',
                'value' => function (Finance $model) {
                    return FormatHelper::asCurrency($model->finance_value_before);
                }
            ],
            [
                'contentOptions' => ['class' => 'text-right'],
                'footer' => '+/-',
                'headerOptions' => ['class' => 'col-10'],
                'label' => '+/-',
                'value' => function (Finance $model) {
                    return FormatHelper::asCurrency($model->finance_value);
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-right'],
                'footer' => 'Стало',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'col-10 hidden-xs'],
                'label' => 'Стало',
                'value' => function (Finance $model) {
                    return FormatHelper::asCurrency($model->finance_value_after);
                }
            ],
            [
                'footer' => 'Комментарий',
                'format' => 'raw',
                'label' => 'Комментарий',
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('//team/_team-links'); ?>
    </div>
</div>
<?= $this->render('//site/_show-full-table'); ?>
