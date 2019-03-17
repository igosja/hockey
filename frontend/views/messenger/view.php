<?php

use coderlex\wysibb\WysiBB;
use common\components\FormatHelper;
use common\components\HockeyHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var int $inBlacklistInterlocutor
 * @var int $inBlacklistOwner
 * @var int $lazy
 * @var \common\models\Message[] $messageArray
 * @var \common\models\User $user
 */

print $this->render('//user/_top');

$user = Yii::$app->user->identity;

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="message-scroll">
            <?= Html::tag('div', '', [
                'data' => [
                    'continue' => $lazy,
                    'limit' => Yii::$app->params['pageSizeMessage'],
                    'offset' => Yii::$app->params['pageSizeMessage'],
                    'url' => Url::to(['messenger/load', 'id' => Yii::$app->request->get('id')]),
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
                        <?= HockeyHelper::bbDecode($message->message_text); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (!$user->user_date_confirm) : ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                    Вам заблокирован доступ к личным сообщениям
                    <br/>
                    Причина - ваш почтовый адрес не подтверждён
                </div>
            </div>
        <?php elseif ($user->user_date_block_comment >= time()) : ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                    Вам заблокирован доступ к личным сообщениям до
                    <?= FormatHelper::asDateTime($user->user_date_block_comment); ?>
                    <br/>
                    Причина - <?= $user->reasonBlockComment->block_reason_text; ?>
                </div>
            </div>
        <?php elseif ($inBlacklistOwner) : ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                    Вы не можете написать сообщение этому менеджеру так как вы добавили его в чёрный список
                </div>
            </div>
        <?php elseif ($inBlacklistInterlocutor) : ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                    Вы не можете написать сообщение этому менеджеру так как он добавил вас в чёрный список
                </div>
            </div>
        <?php else: ?>
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
            <?= $form->field($model, 'message_text')->widget(WysiBB::class)->label('Ваше сообщение:'); ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <?= Html::submitButton('Отправить', ['class' => 'btn margin']); ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        <?php endif; ?>
    </div>
</div>
<?php
$script = <<< JS
var lazy_in_progress = 0;
var scroll_div = $(".message-scroll");
var lazy_div = $('#lazy');

scroll_div.scrollTop(scroll_div.prop('scrollHeight'));

scroll_div.on('scroll', function() {
    if (scroll_div.scrollTop() + scroll_div.offset().top <= lazy_div.offset().top && 0 === lazy_in_progress && 1 === lazy_div.data('continue'))
    {
        lazy_in_progress = 1;

        $.ajax({
            url: lazy_div.data('url') + '?limit=' + lazy_div.data('limit') + '&offset=' + lazy_div.data('offset'),
            dataType: 'json',
            success: function (data)
            {
                var scroll_height = scroll_div.prop('scrollHeight');
                lazy_div.after(data['list']);
                lazy_div.data('offset', data['offset']);
                lazy_div.data('continue', data['lazy']);
                lazy_in_progress = 0;
                scroll_div.scrollTop(scroll_div.prop('scrollHeight') - scroll_height);
            }
        });
    }
});
JS;
$this->registerJs($script);
?>