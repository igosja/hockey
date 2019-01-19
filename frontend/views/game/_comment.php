<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\UserRole;
use yii\helpers\Html;

/**
 * @var \common\models\GameComment $model
 * @var \common\models\User $identity
 */

$identity = Yii::$app->user->identity;

?>
<div class="row border-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
        <?= Html::a(
            $model->user->user_login,
            ['user/view', 'id' => $model->game_comment_user_id],
            ['class' => 'strong']
        ); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= HockeyHelper::bbDecode($model->game_comment_text); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
        <?php

        try {
            print Yii::$app->formatter->asDatetime($model->game_comment_date, 'short');
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
        <?php if (!Yii::$app->user->isGuest && UserRole::ADMIN == $identity->user_user_role_id) : ?>
            |
            <?= Html::a(
                'Удалить',
                ['game/delete-comment', 'id' => $model->game_comment_id, 'gameId' => $model->game_comment_game_id]
            ); ?>
        <?php endif; ?>
    </div>
</div>