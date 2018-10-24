<?php

use common\components\ErrorHelper;
use common\models\Loan;
use common\models\Transfer;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProviderLoan
 * @var \yii\data\ActiveDataProvider $dataProviderTransfer
 * @var \yii\web\View $this
 */

print $this->render('_player');

?>
    <div class="row margin-top-small">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $this->render('_links'); ?>
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
                'header' => 'С',
                'headerOptions' => ['title' => 'Сезон'],
                'value' => function (Transfer $model): string {
                    return $model->transfer_season_id;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'header' => 'Поз',
                'headerOptions' => ['title' => 'Позиция'],
                'value' => function (Transfer $model): string {
                    return $model->position();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'header' => 'В',
                'headerOptions' => ['title' => 'Возраст'],
                'value' => function (Transfer $model): string {
                    return $model->transfer_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Сила'],
                'header' => 'С',
                'headerOptions' => ['title' => 'Сила'],
                'value' => function (Transfer $model): string {
                    return $model->transfer_power;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Спец',
                'footerOptions' => ['title' => 'Спецвозможности'],
                'header' => 'Спец',
                'headerOptions' => ['title' => 'Спецвозможности'],
                'value' => function (Transfer $model): string {
                    return $model->special();
                }
            ],
            [
                'footer' => 'Продавец',
                'format' => 'raw',
                'header' => 'Продавец',
                'value' => function (Transfer $model): string {
                    return $model->seller->teamLink();
                }
            ],
            [
                'footer' => 'Покупатель',
                'format' => 'raw',
                'header' => 'Покупатель',
                'value' => function (Transfer $model): string {
                    return $model->buyer->teamLink();
                }
            ],
            [
                'footer' => 'Цена',
                'header' => 'Цена',
                'value' => function (Transfer $model): string {
                    return Yii::$app->formatter->asCurrency($model->transfer_price_buyer, 'USD');
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProviderTransfer,
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
                    'header' => 'С',
                    'headerOptions' => ['title' => 'Сезон'],
                    'value' => function (Loan $model): string {
                        return $model->loan_season_id;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Поз',
                    'footerOptions' => ['title' => 'Позиция'],
                    'header' => 'Поз',
                    'headerOptions' => ['title' => 'Позиция'],
                    'value' => function (Loan $model): string {
                        return $model->position();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'В',
                    'footerOptions' => ['title' => 'Возраст'],
                    'header' => 'В',
                    'headerOptions' => ['title' => 'Возраст'],
                    'value' => function (Loan $model): string {
                        return $model->loan_age;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['title' => 'Сила'],
                    'header' => 'С',
                    'headerOptions' => ['title' => 'Сила'],
                    'value' => function (Loan $model): string {
                        return $model->loan_power;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Спец',
                    'footerOptions' => ['title' => 'Спецвозможности'],
                    'header' => 'Спец',
                    'headerOptions' => ['title' => 'Спецвозможности'],
                    'value' => function (Loan $model): string {
                        return $model->special();
                    }
                ],
                [
                    'footer' => 'Владелец',
                    'format' => 'raw',
                    'header' => 'Владелец',
                    'value' => function (Loan $model): string {
                        return $model->seller->teamLink();
                    }
                ],
                [
                    'footer' => 'Арендатор',
                    'format' => 'raw',
                    'header' => 'Арендатор',
                    'value' => function (Loan $model): string {
                        return $model->buyer->teamLink();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Срок',
                    'header' => 'Срок',
                    'value' => function (Loan $model): string {
                        return $model->loan_day;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-right'],
                    'footer' => 'Цена',
                    'header' => 'Цена',
                    'value' => function (Loan $model): string {
                        return Yii::$app->formatter->asCurrency($model->loan_price_buyer, 'USD');
                    }
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $dataProviderLoan,
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
            <?= $this->render('_links'); ?>
        </div>
    </div>
<?= $this->render('/site/_show-full-table'); ?>