<?php

use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\UserRole;
use yii\helpers\Html;

/**
 * @var \common\models\LoanComment $model
 * @var \common\models\User $identity
 */

$identity = Yii::$app->user->identity;

?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
    <?= $model->user->userLink(['class' => 'strong', 'color' => true]); ?>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?= HockeyHelper::bbDecode($model->loan_comment_text); ?>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
    <?= FormatHelper::asDateTime($model->loan_comment_date); ?>
    <?php if (!Yii::$app->user->isGuest && UserRole::ADMIN == $identity->user_user_role_id) : ?>
        <?= Html::a(
            '<i class="fa fa-trash-o" aria-hidden="true"></i>',
            ['loan/delete-comment', 'id' => $model->loan_comment_id, 'loanId' => $model->loan_comment_loan_id],
            ['title' => 'Удалить']
        ); ?>
    <?php endif; ?>
</div>
