<?php

use backend\models\PollSearch;
use common\components\ErrorHelper;
use common\models\Poll;
use common\models\PollStatus;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var ActiveDataProvider $dataProvider
 * @var PollSearch $searchModel
 * @var View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($this->title); ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <?= Html::a('Создать', ['poll/create'], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'poll_id',
                'headerOptions' => ['class' => 'col-lg-1'],
            ],
            [
                'format' => 'raw',
                'value' => function (Poll $model): string {
                    $result = '';
                    if (PollStatus::NEW_ONE == $model->poll_poll_status_id) {
                        $result = $result . '<i class="fa fa-clock-o fa-fw"></i> ';
                    }
                    $result = $result . $model->poll_text;
                    return $result;
                }
            ],
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