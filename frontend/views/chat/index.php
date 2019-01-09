<?php

/**
 * @var array $chatArray
 * @var \frontend\models\Chat $model
 * @var \yii\web\View $this
 */

use common\components\FormatHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var \common\models\User $user
 */
$user = Yii::$app->user->identity;

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1><?= $this->title; ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="chat-scroll">
                <?php Pjax::begin(); ?>
                <?php foreach ($chatArray as $chat) : ?>
                    <div class="row margin-top">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-size-3">
                            <?= FormatHelper::asDateTime(
                                new DateTime($chat['date'], new DateTimeZone($user->user_timezone ?: 'UTC'))
                            ); ?>,
                            <?= $chat['userLink']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 message <?php if ($chat['userId'] == Yii::$app->user->id) : ?>message-from-me<?php else : ?>message-to-me<?php endif; ?>">
                            <?= nl2br(Html::encode($chat['text'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?= Html::a('Обновить', ['chat/index'], ['class' => 'hidden', 'id' => 'chat-reload']); ?>
                <?php Pjax::end(); ?>
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'chat-form',
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
            <?= $form->field($model, 'text')->textarea([
                'class' => 'form-control',
            ])->label(false); ?>
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
    var scroll_div = $(".chat-scroll");
    scroll_div.scrollTop(scroll_div.prop('scrollHeight'));
    $(document).on('ready pjax:success', function(){
        scroll_div.scrollTop(scroll_div.prop('scrollHeight'));
    });

    setInterval(function() {
        $("#chat-reload").click();
    }, 5000);
});
JS;
$this->registerJs($script);
?>