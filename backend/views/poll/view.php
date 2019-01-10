<?php

use common\components\ErrorHelper;
use common\models\PollStatus;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\Poll $model
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($this->title); ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <?php if (PollStatus::NEW_ONE == $model->poll_poll_status_id) : ?>
        <li>
            <?= Html::a('Одобрить', ['poll/approve', 'id' => $model->poll_id], ['class' => 'btn btn-default']); ?>
        </li>
    <?php endif; ?>
    <li>
        <?= Html::a('Список', ['poll/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Изменить', ['poll/update', 'id' => $model->poll_id], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Удалить', ['poll/delete', 'id' => $model->poll_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            'poll_id',
            'poll_date:datetime',
            'poll_text',
        ];
        print DetailView::widget([
            'attributes' => $attributes,
            'model' => $model,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <strong>Варианты ответов:</strong>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'attribute' => 'poll_answer_text',
            ]
        ];
        print GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => $columns,
            'showHeader' => false,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
