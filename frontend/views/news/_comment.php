<?php

use common\components\ErrorHelper;
use common\models\UserRole;
use yii\helpers\Html;

/**
 * @var \common\models\NewsComment $model
 * @var \common\models\User $identity
 */

$identity = Yii::$app->user->identity;

?>
<div class="row border-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
        <?= Html::a(
            $model->user->user_login,
            ['user/view', 'id' => $model->news_comment_user_id],
            ['class' => 'strong']
        ); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= nl2br($model->news_comment_text); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
        <?php

        try {
            print Yii::$app->formatter->asDatetime($model->news_comment_date, 'short');
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
        <?php if (!Yii::$app->user->isGuest && UserRole::ADMIN == $identity->user_user_role_id) : ?>
            |
            <?= Html::a(
                'Удалить',
                ['news/delete-comment', 'id' => $model->news_comment_id, 'newsId' => $model->news_comment_news_id]
            ); ?>
        <?php endif; ?>
    </div>
</div>