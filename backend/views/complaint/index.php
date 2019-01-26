<?php

use common\components\ErrorHelper;
use common\models\Complaint;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \backend\models\ComplaintSearch $searchModel
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
                'attribute' => 'complaint_id',
                'headerOptions' => ['class' => 'col-lg-1'],
            ],
            [
                'attribute' => 'complaint_date',
                'format' => 'datetime',
                'headerOptions' => ['class' => 'col-lg-3'],
            ],
            [
                'attribute' => 'complaint_forum_message_id',
                'format' => 'raw',
                'value' => function (Complaint $model) {
                    return Html::a(
                        'Сообщение',
                        ['forum/message-update', 'id' => $model->complaint_forum_message_id],
                        ['target' => '_blank']
                    );
                }
            ],
            [
                'attribute' => 'complaint_user_id',
                'format' => 'raw',
                'value' => function (Complaint $model) {
                    return $model->user->userLink();
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-center'],
                'headerOptions' => ['class' => 'col-lg-1'],
                'template' => '{update}',
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