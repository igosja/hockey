<?php

/**
 * @var array $chatArray
 * @var \frontend\models\Chat $model
 * @var \yii\web\View $this
 */

use coderlex\wysibb\WysiBB;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1><?= $this->title; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <div class="chat-scroll" data-url="<?= Url::to(['chat/message']); ?>"></div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="chat-user-scroll" data-url="<?= Url::to(['chat/user']); ?>"></div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php $form = ActiveForm::begin([
                'id' => 'chat-form',
                'fieldConfig' => [
                    'errorOptions' => [
                        'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center notification-error',
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
            <?= $form->field($model, 'text')->widget(WysiBB::class)->label(false); ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <?= Html::submitButton('Отправить', ['class' => 'btn margin']); ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php
$script = <<< JS
$(document).ready(function() {
    chatUser();
    setInterval(function () {
        chatUser();
    }, 300000);
    
    chatMessage(true);
    setInterval(function () {
        chatMessage(false);
    }, 5000);

    var scroll_div = $(".chat-scroll");
    scroll_div.scrollTop(scroll_div.prop('scrollHeight'));
});

function chatUser() {
    var userChat = $('.chat-user-scroll');
    $.ajax({
        url: userChat.data('url'),
        success: function (data) {
            var html = '';
            for (var i = 0; i < data.length; i++) {
                html = html + data[i].user + '<br/>';
            }
            userChat.html(html);
        }
    });
}
JS;
$this->registerJs($script);
?>