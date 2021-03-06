<?php

use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\News;
use yii\helpers\Html;

/**
 * @var News $model
 */

?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
    <?= $model->news_title; ?>
    <?php if (!Yii::$app->user->isGuest && $model->news_user_id == Yii::$app->user->id) : ?>
        <span class="text-size-3 font-grey">
            <?= Html::a(
                '<i class="fa fa-pencil" aria-hidden="true"></i>',
                ['country/news-update', 'id' => $model->news_country_id, 'newsId' => $model->news_id],
                ['title' => 'Редактировать']
            ); ?>
            |
            <?= Html::a(
                '<i class="fa fa-trash-o" aria-hidden="true"></i>',
                ['country/news-delete', 'id' => $model->news_country_id, 'newsId' => $model->news_id],
                ['title' => 'Удалить']
            ); ?>
        </span>
    <?php endif; ?>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
    <?= FormatHelper::asDatetime($model->news_date); ?>
    -
    <?= $model->user->userLink(['class' => 'strong']); ?>
    -
    <?= Html::a(
        'Комментарии: ' . count($model->newsComment),
        ['country/news-view', 'id' => $model->news_country_id, 'newsId' => $model->news_id],
        ['class' => 'strong text-size-3']
    ); ?>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?= HockeyHelper::bbDecode($model->news_text); ?>
</div>
