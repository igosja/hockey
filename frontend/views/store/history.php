<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Money;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\User $user
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>История платежей</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        <p class="text-center">Ваш счёт - <?= $user->user_money; ?></p>
    </div>
</div>
<div class="row margin-top-small text-center">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('//store/_links'); ?>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Дата',
                'headerOptions' => ['class' => 'col-15'],
                'label' => 'Дата',
                'value' => function (Money $model) {
                    return FormatHelper::asDateTime($model->money_date);
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-right'],
                'footer' => 'Было',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'col-10 hidden-xs'],
                'label' => 'Было',
                'value' => function (Money $model) {
                    return $model->money_value_before;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-right'],
                'footer' => '+/-',
                'headerOptions' => ['class' => 'col-10'],
                'label' => '+/-',
                'value' => function (Money $model) {
                    return $model->money_value;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-right'],
                'footer' => 'Стало',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'col-10 hidden-xs'],
                'label' => 'Стало',
                'value' => function (Money $model) {
                    return $model->money_value_after;
                }
            ],
            [
                'footer' => 'Комментарий',
                'label' => 'Комментарий',
                'value' => function (Money $model) {
                    return $model->moneyText->money_text_text;
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
