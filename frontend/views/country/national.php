<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\National;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 */

print $this->render('_country');

?>
<div class="row margin-top">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Сборная',
                'format' => 'raw',
                'label' => 'Сборная',
                'value' => function (National $model) {
                    return $model->nationalLink();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Тренер',
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-25'],
                'label' => 'Тренер',
                'value' => function (National $model) {
                    return $model->user->iconVip() . ' ' . $model->user->userLink();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-right'],
                'footer' => 'Финансы',
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-25'],
                'label' => 'Финансы',
                'value' => function (National $model) {
                    return FormatHelper::asCurrency($model->national_finance);
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
