<?php

use common\components\FormatHelper;
use common\components\HockeyHelper;
use yii\helpers\Html;

/**
 * @var \common\models\News $model
 */

?>
<div class="row border-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
        <?= $model->news_title; ?>
        <?php if (!Yii::$app->user->isGuest && $model->news_user_id == Yii::$app->user->id) : ?>
            <span class="text-size-3 font-grey">
                <?= Html::a(
                    'Редактировать',
                    ['country/news-update', 'id' => $model->news_country_id, 'newsId' => $model->news_id]
                ); ?>
                |
                <?= Html::a(
                    'Удалить',
                    ['country/news-delete', 'id' => $model->news_country_id, 'newsId' => $model->news_id]
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
</div>