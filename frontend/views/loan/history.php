<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Loan;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>Список хоккеистов, проданных на трансфере</h1>
        </div>
    </div>
    <div class="row margin-top-small text-center">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $this->render('//loan/_links'); ?>
        </div>
    </div>
    <div class="row">
        <?php

        try {
            $columns = [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '№',
                    'header' => '№',
                ],
                [
                    'footer' => 'Игрок',
                    'format' => 'raw',
                    'label' => 'Игрок',
                    'value' => function (Loan $model) {
                        return Html::a(
                            $model->player->playerName(),
                            ['loan/view', 'id' => $model->loan_id]
                        );
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Нац',
                    'footerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Национальность'],
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Национальность'],
                    'label' => 'Нац',
                    'value' => function (Loan $model) {
                        return $model->player->country->countryImageLink();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Поз',
                    'footerOptions' => ['title' => 'Позиция'],
                    'format' => 'raw',
                    'headerOptions' => ['title' => 'Позиция'],
                    'label' => 'Поз',
                    'value' => function (Loan $model) {
                        return $model->position();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'В',
                    'footerOptions' => ['title' => 'Возраст'],
                    'headerOptions' => ['title' => 'Возраст'],
                    'label' => 'В',
                    'value' => function (Loan $model) {
                        return $model->loan_age;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['title' => 'Сила'],
                    'headerOptions' => ['title' => 'Сила'],
                    'label' => 'С',
                    'value' => function (Loan $model) {
                        return $model->loan_power;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center hidden-xs'],
                    'footer' => 'Спец',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Спецвозможности'],
                    'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Спецвозможности'],
                    'label' => 'Спец',
                    'value' => function (Loan $model) {
                        return $model->special();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs'],
                    'footer' => 'Продавец',
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'label' => 'Продавец',
                    'value' => function (Loan $model) {
                        return $model->seller->teamLink('img');
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs'],
                    'footer' => 'Покупатель',
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'label' => 'Покупатель',
                    'value' => function (Loan $model) {
                        return $model->buyer->teamLink('img');
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-right'],
                    'footer' => 'Цена',
                    'footerOptions' => ['title' => 'Общая стоимость аренды'],
                    'headerOptions' => ['title' => 'Общая стоимость аренды'],
                    'label' => 'Цена',
                    'value' => function (Loan $model) {
                        return FormatHelper::asCurrency($model->loan_price_buyer);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => '+/-',
                    'footerOptions' => ['title' => 'Оценка сделки менеджерами'],
                    'format' => 'raw',
                    'headerOptions' => ['title' => 'Оценка сделки менеджерами'],
                    'label' => '+/-',
                    'value' => function (Loan $model) {
                        return $model->rating();
                    }
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $dataProvider,
                'showFooter' => true,
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
<?= $this->render('//site/_show-full-table'); ?>