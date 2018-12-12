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

print $this->render('_team-top');

?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_team-links'); ?>
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
                'header' => 'Дата',
                'value' => function (Transfer $model): string {
                    return Yii::$app->formatter->asDate($model->transfer_date, 'short');
                }
            ],
            [
                'footer' => 'Игрок',
                'header' => 'Игрок',
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
                'header' => 'Нац',
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
                'footer' => 'Покупатель',
                'format' => 'raw',
                'header' => 'Покупатель',
                'value' => function (Transfer $model): string {
                    return Html::a(
                        $model->buyer->team_name
                        . ' <span class="hidden-xs">('
                        . $model->buyer->stadium->city->city_name
                        . ', '
                        . $model->buyer->stadium->city->country->country_name
                        . ')</span>',
                        ['team/view', 'id' => $model->transfer_team_buyer_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'text-right'],
                'footer' => 'Цена',
                'header' => 'Цена',
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
                'header' => 'Дата',
                'value' => function (Transfer $model): string {
                    return Yii::$app->formatter->asDate($model->transfer_date, 'short');
                }
            ],
            [
                'footer' => 'Игрок',
                'header' => 'Игрок',
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
                'header' => 'Нац',
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
                    return Html::a(
                        $model->seller->team_name
                        . ' <span class="hidden-xs">('
                        . $model->seller->stadium->city->city_name
                        . ', '
                        . $model->seller->stadium->city->country->country_name
                        . ')</span>',
                        ['team/view', 'id' => $model->transfer_team_seller_id]
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'text-right'],
                'footer' => 'Цена',
                'header' => 'Цена',
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
                'header' => 'Дата',
                'value' => function (Loan $model): string {
                    return Yii::$app->formatter->asDate($model->loan_date, 'short');
                }
            ],
            [
                'footer' => 'Игрок',
                'header' => 'Игрок',
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
                'header' => 'Нац',
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
                'footer' => 'Арендатор',
                'format' => 'raw',
                'header' => 'Арендатор',
                'value' => function (Loan $model): string {
                    return Html::a(
                        $model->buyer->team_name
                        . ' <span class="hidden-xs">('
                        . $model->buyer->stadium->city->city_name
                        . ', '
                        . $model->buyer->stadium->city->country->country_name
                        . ')</span>',
                        ['team/view', 'id' => $model->loan_team_buyer_id]
                    );
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
                'header' => 'Дата',
                'value' => function (Loan $model): string {
                    return Yii::$app->formatter->asDate($model->loan_date, 'short');
                }
            ],
            [
                'footer' => 'Игрок',
                'header' => 'Игрок',
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
                'header' => 'Нац',
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
                    return Html::a(
                        $model->seller->team_name
                        . ' <span class="hidden-xs">('
                        . $model->seller->stadium->city->city_name
                        . ', '
                        . $model->seller->stadium->city->country->country_name
                        . ')</span>',
                        ['team/view', 'id' => $model->loan_team_seller_id]
                    );
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
            'dataProvider' => $dataProviderLoanTo,
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
        <?= $this->render('_team-links'); ?>
    </div>
</div>
<?= $this->render('//site/_show-full-table'); ?>
