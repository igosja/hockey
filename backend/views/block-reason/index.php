<?php

use common\components\ErrorHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\BlockReasonSearch $searchModel
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($this->title); ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <?= Html::a('Создать', ['block-reason/create'], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'block_reason_id',
                'headerOptions' => ['class' => 'col-lg-1'],
            ],
            'block_reason_text',
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'col-lg-1'],
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>