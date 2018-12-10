<?php

use common\components\FormatHelper;

/**
 * @var \common\models\ForumMessage $model
 * @var \common\models\User $user
 */

$user = Yii::$app->user->identity;

?>


<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $model->user->userLink(['color' => true]); ?>
        </div>
    </div>
    <div class="row text-size-2 hidden-xs">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Дата регистрации:
            <?= FormatHelper::asDate($model->user->user_date_register); ?>
        </div>
    </div>
    <div class="row text-size-2 hidden-xs">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Рейтинг:
            <?= $user->user_rating; ?>
        </div>
    </div>
    <div class="row text-size-2 hidden-xs">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Команды:
            <?php foreach ($model->user->team as $team) : ?>
                <?= $team->teamLink('img'); ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
    <div class="row text-size-2 font-grey">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= FormatHelper::asDatetime($model->forum_message_date); ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
            <?= $model->links(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?= $model->forum_message_text; ?>
        </div>
    </div>
    <?php if ($model->forum_message_date_update) : ?>
        <div class="row text-size-2 font-grey">
            <div class="col-lg-12 col-md-12 col-sm-12">
                Отредактировано в
                <?= FormatHelper::asDatetime($model->forum_message_date_update); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
