<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Logo;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var ActiveDataProvider $dataProvider
 * @var View $this
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
                'label' => 'Время заявки',
                'value' => function (Logo $model) {
                    return FormatHelper::asDateTime($model->logo_date);
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Пользователь',
                'value' => function (Logo $model) {
                    return $model->user->userLink();
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