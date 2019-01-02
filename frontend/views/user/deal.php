<?php

use common\components\ErrorHelper;
use common\models\Loan;
use common\models\Transfer;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProviderLoanFrom
 * @var \yii\data\ActiveDataProvider $dataProviderLoanTo
 * @var \yii\data\ActiveDataProvider $dataProviderTransferFrom
 * @var \yii\data\ActiveDataProvider $dataProviderTransferTo
 * @var \yii\web\View $this
 */

print $this->render('_top');

?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_user-links'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-center">Проданы на трансфере:</p>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Дата',
                'label' => 'Дата',
                'value' => function (Transfer $model): string {
                    return Yii::$app->formatter->asDate($model->transfer_date, 'short');
                }
            ],
            [
                'footer' => 'Игрок',
                'format' => 'raw',
                'label' => 'Игрок',
                'value' => function (Transfer $model): string {
                    return Html::a(
                        $model->player->playerName(),
                        ['player/view', 'id' => $model->transfer_player_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs'],
                'footer' => 'Нац',
                'footerOptions' => ['class' => 'hidden-xs'],
                'format' => 'raw',
                'label' => 'Нац',
                'headerOptions' => ['class' => 'col-1 hidden-xs'],
                'value' => function (Transfer $model): string {
                    return Html::a(
                        Html::img(
                            '/img/country/12/' . $model->player->player_country_id . '.png',
                            [
                                'alt' => $model->player->country->country_name,
                                'title' => $model->player->country->country_name,
                            ]
                        ),
                        ['country/news', 'id' => $model->player->player_country_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'label' => 'Поз',
                'headerOptions' => ['title' => 'Позиция'],
                'value' => function (Transfer $model): string {
                    return $model->position();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'label' => 'В',
                'headerOptions' => ['title' => 'Возраст'],
                'value' => function (Transfer $model): string {
                    return $model->transfer_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Сила'],
                'label' => 'С',
                'headerOptions' => ['title' => 'Сила'],
                'value' => function (Transfer $model): string {
                    return $model->transfer_power;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Спец',
                'footerOptions' => ['title' => 'Спецвозможности'],
                'label' => 'Спец',
                'headerOptions' => ['title' => 'Спецвозможности'],
                'value' => function (Transfer $model): string {
                    return $model->special();
                }
            ],
            [
                'footer' => 'Продавец',
                'format' => 'raw',
                'label' => 'Продавец',
                'value' => function (Transfer $model): string {
                    return $model->seller->teamLink('img');
                }
            ],
            [
                'footer' => 'Покупатель',
                'format' => 'raw',
                'label' => 'Покупатель',
                'value' => function (Transfer $model): string {
                    return $model->buyer->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'text-right'],
                'footer' => 'Цена',
                'label' => 'Цена',
                'value' => function (Transfer $model): string {
                    return Yii::$app->formatter->asCurrency($model->transfer_price_buyer, 'USD');
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProviderTransferFrom,
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
        <p class="text-center">Куплены на трансфере:</p>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Дата',
                'label' => 'Дата',
                'value' => function (Transfer $model): string {
                    return Yii::$app->formatter->asDate($model->transfer_date, 'short');
                }
            ],
            [
                'footer' => 'Игрок',
                'format' => 'raw',
                'label' => 'Игрок',
                'value' => function (Transfer $model): string {
                    return Html::a(
                        $model->player->playerName(),
                        ['player/view', 'id' => $model->transfer_player_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs'],
                'footer' => 'Нац',
                'footerOptions' => ['class' => 'hidden-xs'],
                'format' => 'raw',
                'label' => 'Нац',
                'headerOptions' => ['class' => 'col-1 hidden-xs'],
                'value' => function (Transfer $model): string {
                    return Html::a(
                        Html::img(
                            '/img/country/12/' . $model->player->player_country_id . '.png',
                            [
                                'alt' => $model->player->country->country_name,
                                'title' => $model->player->country->country_name,
                            ]
                        ),
                        ['country/news', 'id' => $model->player->player_country_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'label' => 'Поз',
                'headerOptions' => ['title' => 'Позиция'],
                'value' => function (Transfer $model): string {
                    return $model->position();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'label' => 'В',
                'headerOptions' => ['title' => 'Возраст'],
                'value' => function (Transfer $model): string {
                    return $model->transfer_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Сила'],
                'label' => 'С',
                'headerOptions' => ['title' => 'Сила'],
                'value' => function (Transfer $model): string {
                    return $model->transfer_power;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Спец',
                'footerOptions' => ['title' => 'Спецвозможности'],
                'label' => 'Спец',
                'headerOptions' => ['title' => 'Спецвозможности'],
                'value' => function (Transfer $model): string {
                    return $model->special();
                }
            ],
            [
                'footer' => 'Продавец',
                'format' => 'raw',
                'label' => 'Продавец',
                'value' => function (Transfer $model): string {
                    return $model->seller->teamLink('img');
                }
            ],
            [
                'footer' => 'Покупатель',
                'format' => 'raw',
                'label' => 'Покупатель',
                'value' => function (Transfer $model): string {
                    return $model->buyer->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'text-right'],
                'footer' => 'Цена',
                'label' => 'Цена',
                'value' => function (Transfer $model): string {
                    return Yii::$app->formatter->asCurrency($model->transfer_price_buyer, 'USD');
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProviderTransferTo,
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
        <p class="text-center">Отданы в аренду:</p>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Дата',
                'label' => 'Дата',
                'value' => function (Loan $model): string {
                    return Yii::$app->formatter->asDate($model->loan_date, 'short');
                }
            ],
            [
                'footer' => 'Игрок',
                'format' => 'raw',
                'label' => 'Игрок',
                'value' => function (Loan $model): string {
                    return Html::a(
                        $model->player->playerName(),
                        ['player/view', 'id' => $model->loan_player_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs'],
                'footer' => 'Нац',
                'footerOptions' => ['class' => 'hidden-xs'],
                'format' => 'raw',
                'label' => 'Нац',
                'headerOptions' => ['class' => 'col-1 hidden-xs'],
                'value' => function (Loan $model): string {
                    return Html::a(
                        Html::img(
                            '/img/country/12/' . $model->player->player_country_id . '.png',
                            [
                                'alt' => $model->player->country->country_name,
                                'title' => $model->player->country->country_name,
                            ]
                        ),
                        ['country/news', 'id' => $model->player->player_country_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'label' => 'Поз',
                'headerOptions' => ['title' => 'Позиция'],
                'value' => function (Loan $model): string {
                    return $model->position();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'label' => 'В',
                'headerOptions' => ['title' => 'Возраст'],
                'value' => function (Loan $model): string {
                    return $model->loan_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Сила'],
                'label' => 'С',
                'headerOptions' => ['title' => 'Сила'],
                'value' => function (Loan $model): string {
                    return $model->loan_power;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Спец',
                'footerOptions' => ['title' => 'Спецвозможности'],
                'label' => 'Спец',
                'headerOptions' => ['title' => 'Спецвозможности'],
                'value' => function (Loan $model): string {
                    return $model->special();
                }
            ],
            [
                'footer' => 'Владелец',
                'format' => 'raw',
                'label' => 'Владелец',
                'value' => function (Loan $model): string {
                    return $model->seller->teamLink('img');
                }
            ],
            [
                'footer' => 'Арендатор',
                'format' => 'raw',
                'label' => 'Арендатор',
                'value' => function (Loan $model): string {
                    return $model->buyer->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Срок',
                'label' => 'Срок',
                'value' => function (Loan $model): string {
                    return $model->loan_day;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-right'],
                'footer' => 'Цена',
                'label' => 'Цена',
                'value' => function (Loan $model): string {
                    return Yii::$app->formatter->asCurrency($model->loan_price_buyer, 'USD');
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProviderLoanFrom,
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
        <p class="text-center">Взяты в аренду:</p>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Дата',
                'label' => 'Дата',
                'value' => function (Loan $model): string {
                    return Yii::$app->formatter->asDate($model->loan_date, 'short');
                }
            ],
            [
                'footer' => 'Игрок',
                'format' => 'raw',
                'label' => 'Игрок',
                'value' => function (Loan $model): string {
                    return Html::a(
                        $model->player->playerName(),
                        ['player/view', 'id' => $model->loan_player_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs'],
                'footer' => 'Нац',
                'footerOptions' => ['class' => 'hidden-xs'],
                'format' => 'raw',
                'label' => 'Нац',
                'headerOptions' => ['class' => 'col-1 hidden-xs'],
                'value' => function (Loan $model): string {
                    return Html::a(
                        Html::img(
                            '/img/country/12/' . $model->player->player_country_id . '.png',
                            [
                                'alt' => $model->player->country->country_name,
                                'title' => $model->player->country->country_name,
                            ]
                        ),
                        ['country/news', 'id' => $model->player->player_country_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'label' => 'Поз',
                'headerOptions' => ['title' => 'Позиция'],
                'value' => function (Loan $model): string {
                    return $model->position();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'label' => 'В',
                'headerOptions' => ['title' => 'Возраст'],
                'value' => function (Loan $model): string {
                    return $model->loan_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Сила'],
                'label' => 'С',
                'headerOptions' => ['title' => 'Сила'],
                'value' => function (Loan $model): string {
                    return $model->loan_power;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Спец',
                'footerOptions' => ['title' => 'Спецвозможности'],
                'label' => 'Спец',
                'headerOptions' => ['title' => 'Спецвозможности'],
                'value' => function (Loan $model): string {
                    return $model->special();
                }
            ],
            [
                'footer' => 'Владелец',
                'format' => 'raw',
                'label' => 'Владелец',
                'value' => function (Loan $model): string {
                    return $model->seller->teamLink('img');
                }
            ],
            [
                'footer' => 'Арендатор',
                'format' => 'raw',
                'label' => 'Арендатор',
                'value' => function (Loan $model): string {
                    return $model->buyer->teamLink('img');
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Срок',
                'label' => 'Срок',
                'value' => function (Loan $model): string {
                    return $model->loan_day;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-right'],
                'footer' => 'Цена',
                'label' => 'Цена',
                'value' => function (Loan $model): string {
                    return Yii::$app->formatter->asCurrency($model->loan_price_buyer, 'USD');
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProviderLoanTo,
            'showFooter' => true,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<?= $this->render('//site/_show-full-table'); ?>
