<?php

use common\components\FormatHelper;
use common\models\UserRole;
use yii\helpers\Html;

/**
 * @var \common\models\TransferComment $model
 * @var \common\models\User $identity
 */

$identity = Yii::$app->user->identity;

?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
    <?= $model->user->userLink(['class' => 'strong']); ?>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?= nl2br(Html::encode($model->transfer_comment_text)); ?>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
    <?= FormatHelper::asDateTime($model->transfer_comment_date); ?>
    <?php if (!Yii::$app->user->isGuest && UserRole::ADMIN == $identity->user_user_role_id) : ?>
        |
        <?= Html::a(
            'Удалить',
            ['transfer/delete-comment', 'id' => $model->transfer_comment_id, 'transferId' => $model->transfer_comment_transfer_id]
        ); ?>
    <?php endif; ?>
</div>
