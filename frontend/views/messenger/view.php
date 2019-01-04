<?php

use common\components\FormatHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var int $lazy
 * @var \common\models\Message[] $messageArray
 */

print $this->render('//user/_top');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="message-scroll">
            <?= Html::tag('div', '', [
                'data' => [
                    'continue' => $lazy,
                    'limit' => Yii::$app->params['pageSizeMessage'],
                    'offset' => Yii::$app->params['pageSizeMessage'],
                ],
                'id' => 'lazy',
            ]); ?>
            <?php foreach ($messageArray as $message) : ?>
                <div class="row margin-top">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-size-3">
                        <?= FormatHelper::asDateTime($message->message_date); ?>,
                        <?= $message->userFrom->userLink(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 message <?php if (Yii::$app->user->id == $message->message_user_id_from) : ?>message-from-me<?php else : ?>message-to-me<?php endif; ?>">
                        <?= nl2br(Html::encode($message->message_text)); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center message-error notification-error',
                    'tag' => 'div'
                ],
                'options' => ['class' => 'row'],
                'template' =>
                    '<div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">{label}</div>
                </div>
                <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{input}</div>
                </div>
                <div class="row">{error}</div>',
            ],
        ]); ?>
        <?= $form->field($model, 'message_text')->textarea([
            'class' => 'form-control',
            'rows' => 5,
        ])->label('Ваше сообщение:'); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Отправить', ['class' => 'btn margin']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>