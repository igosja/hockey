<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\LoanComment;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var LoanComment $model
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
            ['moderation/loan-comment-ok', 'id' => $model->loan_comment_id],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
    <li>
        <?= Html::a(
            'Изменить',
            ['moderation/loan-comment-update', 'id' => $model->loan_comment_id],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
    <li>
        <?= Html::a(
            'Удалить',
            ['moderation/loan-comment-delete', 'id' => $model->loan_comment_id],
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
                'value' => function (LoanComment $model) {
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
        <?= HockeyHelper::bbDecode($model->loan_comment_text); ?>
    </div>
</div>
