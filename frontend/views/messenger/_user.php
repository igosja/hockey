<?php

use yii\helpers\Html;

/**
 * @var \common\models\Message $model
 */

$user = $model->message_user_id_from == Yii::$app->user->id ? $model->userTo : $model->userFrom;

?>
<div class="row border-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        <?= $user->userLink(); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Последний визит: <?= $user->lastVisit(); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Рейтинг: <span class="strong"><?= $user->user_rating; ?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Команда:
        <?php foreach ($user->team as $team) : ?>
            <?= $team->teamLink('img'); ?>
        <?php endforeach; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if (!$model->message_read) { ?>
            <?= Html::a('Читать новые', ['messenger/view', 'id' => $user->user_id], ['class' => 'strong']); ?>
            |
        <?php } ?>
        <?= Html::a('Написать', ['messenger/view', 'id' => $user->user_id]); ?>
    </div>
</div>
