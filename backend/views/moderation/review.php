<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\Review;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var Review $model
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
            ['moderation/review-ok', 'id' => $model->review_id],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
    <li>
        <?= Html::a(
            'Изменить',
            ['moderation/review-update', 'id' => $model->review_id],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
    <li>
        <?= Html::a(
            'Удалить',
            ['moderation/review-delete', 'id' => $model->review_id],
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
                'value' => function (Review $model) {
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
        <?= HockeyHelper::bbDecode($model->review_text); ?>
    </div>
</div>
<?php foreach ($model->reviewGame as $reviewGame) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= HockeyHelper::bbDecode($reviewGame->review_game_text); ?>
        </div>
    </div>
<?php endforeach; ?>
