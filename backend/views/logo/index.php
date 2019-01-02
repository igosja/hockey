<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Logo;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($this->title); ?></h3>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'headerOptions' => ['class' => 'col-lg-1'],
                'label' => 'ID',
                'value' => function (Logo $model) {
                    return $model->logo_id;
                },
            ],
            [
                'headerOptions' => ['class' => 'col-lg-1'],
                'label' => 'Время заявки',
                'value' => function (Logo $model) {
                    return FormatHelper::asDateTime($model->logo_date);
                },
            ],
            [
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-lg-1'],
                'label' => 'Пользователь',
                'value' => function (Logo $model) {
                    return $model->user->userLink();
                },
            ],
            [
                'headerOptions' => ['class' => 'col-lg-1'],
                'label' => 'Команда',
                'value' => function (Logo $model) {
                    return $model->team->team_name;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'col-lg-1'],
                'template' => '{view}',
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>