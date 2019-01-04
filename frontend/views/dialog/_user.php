<?php

use yii\helpers\Html;

/**
 * @var \common\models\Message $model
 */

?>
<div class="row border-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        <?= $model->userFrom->userLink(); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Последний визит: <?= $model->userFrom->lastVisit(); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Рейтинг: <span class="strong"><?= $model->userFrom->user_rating; ?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Команда:
        <?php foreach ($model->userFrom->team as $team) : ?>
            <?= $team->teamLink('img'); ?>
        <?php endforeach; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if (!$model->message_read) { ?>
            <?= Html::a('Читать новые', ['dialog/view', 'id' => $model->userFrom->user_id], ['class' => 'strong']); ?>
            |
        <?php } ?>
        <?= Html::a('Написать', ['dialog/view', 'id' => $model->userFrom->user_id]); ?>
    </div>
</div>
