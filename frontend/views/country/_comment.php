<?php

use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\UserRole;
use yii\helpers\Html;

/**
 * @var \common\models\NewsComment $model
 * @var \common\models\User $identity
 */

$identity = Yii::$app->user->identity;

?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
    <?= $model->user->userLink(['class' => 'strong']); ?>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?= HockeyHelper::bbDecode($model->news_comment_text); ?>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
    <?= FormatHelper::asDateTime($model->news_comment_date); ?>
    <?php if (!Yii::$app->user->isGuest && UserRole::ADMIN == $identity->user_user_role_id) : ?>
        |
        <?= Html::a(
            'Удалить',
            ['country/delete-news-comment', 'id' => $model->news_comment_id, 'newsId' => $model->news_comment_news_id]
        ); ?>
    <?php endif; ?>
</div>
