<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Loan;
use common\models\Transfer;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProviderLoan
 * @var \yii\data\ActiveDataProvider $dataProviderTransfer
 * @var \common\models\Player $player
 * @var \yii\web\View $this
 */

print $this->render('//player/_player', ['player' => $player]);

?>
    <div class="row margin-top-small">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $this->render('//player/_links'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p class="text-center">Трансферы:</p>
        </div>
    </div>
    <div class="row">
        <?php

        try {
            $columns = [
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['title' => 'Сезон'],
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Сезон'],
                    'label' => 'С',
                    'value' => function (Transfer $model) {
                        return $model->transfer_season_id;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Поз',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Позиция'],
                    'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Позиция'],
                    'label' => 'Поз',
                    'value' => function (Transfer $model) {
                        return $model->position();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'В',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Возраст'],
                    'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Возраст'],
                    'label' => 'В',
                    'value' => function (Transfer $model) {
                        return $model->transfer_age;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Сила'],
                    'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Сила'],
                    'label' => 'С',
                    'value' => function (Transfer $model) {
                        return $model->transfer_power;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Спец',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Спецвозможности'],
                    'headerOptions' => ['class' => 'col-10 hidden-xs', 'title' => 'Спецвозможности'],
                    'label' => 'Спец',
                    'value' => function (Transfer $model) {
                        return $model->special();
                    }
                ],
                [
                    'footer' => 'Продавец',
                    'format' => 'raw',
                    'label' => 'Продавец',
                    'value' => function (Transfer $model) {
                        return $model->seller->teamLink('img');
                    }
                ],
                [
                    'footer' => 'Покупатель',
                    'format' => 'raw',
                    'label' => 'Покупатель',
                    'headerOptions' => ['class' => 'col-25'],
                    'value' => function (Transfer $model) {
                        return $model->buyer->teamLink('img');
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-right'],
                    'footer' => 'Цена',
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'col-15'],
                    'label' => 'Цена',
                    'value' => function (Transfer $model) {
                        return Html::a(
                            FormatHelper::asCurrency($model->transfer_price_buyer),
                            ['transfer/view', 'id' => $model->transfer_id]
                        );
                    }
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $dataProviderTransfer,
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
            <p class="text-center">Аренды:</p>
        </div>
    </div>
    <div class="row">
        <?php

        try {
            $columns = [
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['title' => 'Сезон'],
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Сезон'],
                    'label' => 'С',
                    'value' => function (Loan $model) {
                        return $model->loan_season_id;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Поз',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Позиция'],
                    'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Позиция'],
                    'label' => 'Поз',
                    'value' => function (Loan $model) {
                        return $model->position();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'В',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Возраст'],
                    'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Возраст'],
                    'label' => 'В',
                    'value' => function (Loan $model) {
                        return $model->loan_age;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Сила'],
                    'headerOptions' => ['class' => 'col-5 hidden-xs', 'title' => 'Сила'],
                    'label' => 'С',
                    'value' => function (Loan $model) {
                        return $model->loan_power;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Спец',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Спецвозможности'],
                    'headerOptions' => ['class' => 'col-10 hidden-xs', 'title' => 'Спецвозможности'],
                    'label' => 'Спец',
                    'value' => function (Loan $model) {
                        return $model->special();
                    }
                ],
                [
                    'footer' => 'Владелец',
                    'format' => 'raw',
                    'label' => 'Владелец',
                    'value' => function (Loan $model) {
                        return $model->seller->teamLink('img');
                    }
                ],
                [
                    'footer' => 'Арендатор',
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'col-25'],
                    'label' => 'Арендатор',
                    'value' => function (Loan $model) {
                        return $model->buyer->teamLink('img');
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Срок',
                    'headerOptions' => ['class' => 'col-5'],
                    'label' => 'Срок',
                    'value' => function (Loan $model) {
                        return $model->loan_day;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-right'],
                    'footer' => 'Цена',
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'col-15'],
                    'label' => 'Цена',
                    'value' => function (Loan $model) {
                        return Html::a(
                            FormatHelper::asCurrency($model->loan_price_buyer),
                            ['loan/view', 'id' => $model->loan_id]
                        );
                    }
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $dataProviderLoan,
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
            <?= $this->render('//player/_links'); ?>
        </div>
    </div>
<?= $this->render('//site/_show-full-table'); ?>