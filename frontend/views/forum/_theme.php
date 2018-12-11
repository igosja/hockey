<?php

use common\components\FormatHelper;
use common\models\UserRole;
use yii\helpers\Html;

/**
 * @var \common\models\ForumTheme $model
 * @var \common\models\User $user
 */

$user = Yii::$app->user->identity;

?>

<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= Html::a(
                $model->forum_theme_name,
                ['forum/theme', 'id' => $model->forum_theme_id]
            ); ?>
            <?php if (!Yii::$app->user->isGuest && UserRole::ADMIN == $user->user_user_role_id) : ?>
                |
                <?= Html::a(
                    'удалить',
                    ['forum/theme-delete', 'id' => $model->forum_theme_id],
                    ['class' => 'font-grey']
                ); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row text-size-2">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $model->user->userLink(); ?>
        </div>
    </div>
    <div class="row text-size-2">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= FormatHelper::asDateTime($model->forum_theme_date); ?>
        </div>
    </div>
</div>
<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
    <?= count($model->forumMessage); ?>
</div>
<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
    <?= $model->forum_theme_count_view; ?>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-size-2">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $model->forumMessage[0]->user->userLink(['color' => true]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= FormatHelper::asDateTime($model->forumMessage[0]->forum_message_date); ?>
        </div>
    </div>
</div>
