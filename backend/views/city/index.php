<?php

use common\components\ErrorHelper;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\CitySearch $searchModel
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
        <?= Html::a('Создать', ['city/create'], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'city_id',
                'headerOptions' => ['class' => 'col-lg-1'],
                'label' => 'ID',
            ],
            [
                'attribute' => 'city_name',
                'label' => 'Название',
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
            'filterModel' => $searchModel,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>