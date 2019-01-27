<?php

use common\components\ErrorHelper;
use common\models\TeamAsk;
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
                'attribute' => 'team_ask_id',
                'headerOptions' => ['class' => 'col-lg-1'],
                'label' => 'ID',
            ],
            [
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (TeamAsk $model) {
                    return $model->team->teamLink();
                }
            ],
            [
                'format' => 'raw',
                'label' => 'Менеджер',
                'value' => function (TeamAsk $model) {
                    return $model->user->userLink();
                }
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