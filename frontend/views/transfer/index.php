<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Transfer;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>Список хоккеистов, выставленных на трансфер</h1>
        </div>
    </div>
    <div class="row margin-top-small text-center">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $this->render('//transfer/_links'); ?>
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
                    'value' => function (Transfer $model) {
                        return Html::a(
                            $model->player->playerName(),
                            ['player/transfer', 'id' => $model->player->player_id]
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
                    'value' => function (Transfer $model) {
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
                    'value' => function (Transfer $model) {
                        return $model->player->position();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'В',
                    'footerOptions' => ['title' => 'Возраст'],
                    'headerOptions' => ['title' => 'Возраст'],
                    'label' => 'В',
                    'value' => function (Transfer $model) {
                        return $model->player->player_age;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['title' => 'Сила'],
                    'headerOptions' => ['title' => 'Сила'],
                    'label' => 'С',
                    'value' => function (Transfer $model) {
                        return $model->player->player_power_nominal;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center hidden-xs'],
                    'footer' => 'Спец',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Спецвозможности'],
                    'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Спецвозможности'],
                    'label' => 'Спец',
                    'value' => function (Transfer $model) {
                        return $model->player->special();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs'],
                    'footer' => 'Команда',
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'label' => 'Команда',
                    'value' => function (Transfer $model) {
                        return $model->seller->teamLink('img');
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-right'],
                    'footer' => 'Цена',
                    'footerOptions' => ['title' => 'Минимальная запрашиваемая цена'],
                    'headerOptions' => ['title' => 'Минимальная запрашиваемая цена'],
                    'label' => 'Цена',
                    'value' => function (Transfer $model) {
                        return FormatHelper::asCurrency($model->transfer_price_seller);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Торги',
                    'footerOptions' => ['title' => 'Дата проведения торгов'],
                    'headerOptions' => ['title' => 'Дата проведения торгов'],
                    'label' => 'Торги',
                    'value' => function (Transfer $model) {
                        return $model->dealDate();
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