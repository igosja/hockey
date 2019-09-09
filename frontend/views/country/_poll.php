<?php

use common\components\FormatHelper;
use common\models\Poll;
use common\models\PollStatus;
use yii\helpers\Html;

/**
 * @var Poll $model
 */

?>
<div class="row border-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <?= Html::a(
                    '<span class="strong">' . $model->poll_text . '</span>',
                    ['poll/view', 'id' => $model->poll_id]
                ); ?>
                <?php if ($model->poll_poll_status_id == PollStatus::NEW_ONE && !Yii::$app->user->isGuest && $model->poll_user_id == Yii::$app->user->id) : ?>
                    <span class="text-size-3 font-grey">
                        <?= Html::a(
                            'Удалить',
                            ['country/poll-delete', 'id' => $model->poll_country_id, 'pollId' => $model->poll_id]
                        ); ?>
                    </span>
                <?php endif; ?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $model->pollStatus->poll_status_name; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Автор:
                <?= $model->user->userLink(['color' => true]); ?>,
                <?= FormatHelper::asDateTime($model->poll_date); ?>
            </div>
        </div>
        <?php foreach ($model->pollAnswer as $answer) : ?>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <?= $answer->poll_answer_text; ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                    <?= count($answer->pollUser); ?>
                    (%)
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>