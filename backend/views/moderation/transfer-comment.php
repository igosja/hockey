<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\TransferComment;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var TransferComment $model
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
        <?= Html::a(
            'Одобрить',
            ['moderation/transfer-comment-ok', 'id' => $model->transfer_comment_id],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
    <li>
        <?= Html::a(
            'Изменить',
            ['moderation/transfer-comment-update', 'id' => $model->transfer_comment_id],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
    <li>
        <?= Html::a(
            'Удалить',
            ['moderation/transfer-comment-delete', 'id' => $model->transfer_comment_id],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'format' => 'raw',
                'label' => 'Автор',
                'value' => function (TransferComment $model) {
                    return $model->user->userLink();
                },
            ],
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
        <?= HockeyHelper::bbDecode($model->transfer_comment_text); ?>
    </div>
</div>
