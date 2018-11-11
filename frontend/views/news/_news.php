<?php

use common\components\ErrorHelper;
use yii\helpers\Html;

/**
 * @var \common\models\News $model
 */

?>
<div class="row border-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
        <?= $model->news_title; ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
        <?php

        try {
            print Yii::$app->formatter->asDatetime($model->news_date, 'short');
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
        -
        <?= Html::a(
            $model->user->user_login,
            ['user/view', 'id' => $model->news_user_id],
            ['class' => 'strong']
        ); ?>
        -
        <?= Html::a(
            'Комментарии: ' . count($model->newsComment),
            ['news/view', 'id' => $model->news_id],
            ['class' => 'strong text-size-3']
        ); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $model->news_text; ?>
    </div>
</div>