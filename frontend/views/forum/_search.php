<?php

use common\components\FormatHelper;
use yii\helpers\Html;

/**
 * @var \common\models\ForumMessage $model
 */

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
            <?= $model->user->user_rating; ?>
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= FormatHelper::asDatetime($model->forum_message_date); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?= str_ireplace(
                Yii::$app->request->get('q'),
                '<span class="info">' . Yii::$app->request->get('q') . '</span>',
                $model->forum_message_text
            ); ?>
        </div>
    </div>
    <div class="row text-size-2 font-grey">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?= Html::a('Перейти в тему', ['forum/theme', 'id' => $model->forum_message_forum_theme_id]); ?>
        </div>
    </div>
</div>
