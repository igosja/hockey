<?php

use coderlex\wysibb\WysiBB;
use common\components\ErrorHelper;
use common\components\FormatHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\ForumTheme $forumTheme
 * @var \common\models\User $user
 * @var \yii\web\View $this
 */

$user = Yii::$app->user->identity;

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
                <?= Html::a(
                    'Форум',
                    ['forum/index']
                ); ?>
                /
                <?= Html::a(
                    $forumTheme->forumGroup->forumChapter->forum_chapter_name,
                    ['forum/chapter', 'id' => $forumTheme->forumGroup->forum_group_forum_chapter_id]
                ); ?>
                /
                <?= Html::a(
                    $forumTheme->forumGroup->forum_group_name,
                    ['forum/group', 'id' => $forumTheme->forum_theme_forum_group_id]
                ); ?>
                /
                <?= $forumTheme->forum_theme_name; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?= $forumTheme->forum_theme_name; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                <?= $this->render('/forum/_searchForm'); ?>
            </div>
        </div>
        <?php

        try {
            print ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'row forum-row forum-striped'],
                'itemView' => '_message',
                'summary' => false,
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
</div>
<?php if (!Yii::$app->user->isGuest) : ?>
    <?php if (!$user->user_date_confirm) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к форуму
                <br/>
                Причина - ваш почтовый адрес не подтверждён
            </div>
        </div>
    <?php elseif ($user->user_date_block_forum >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к форуму до
                <?= FormatHelper::asDatetime($user->user_date_block_forum); ?>
                <br/>
                Причина - <?= $user->reasonBlockForum->block_reason_text; ?>
            </div>
        </div>
    <?php elseif ($user->user_date_block_comment >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к форуму до
                <?= FormatHelper::asDateTime($user->user_date_block_comment); ?>
                <br/>
                Причина - <?= $user->reasonBlockComment->block_reason_text; ?>
            </div>
        </div>
    <?php else: ?>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center notification-error',
                    'tag' => 'div'
                ],
                'options' => ['class' => 'row'],
                'template' =>
                    '<div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">{label}</div>
                    </div>
                    <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{input}</div>
                    </div>
                    <div class="row">{error}</div>',
            ],
        ]); ?>
        <?= $form->field($model, 'forum_message_text')->widget(WysiBB::class)->label('Ваш ответ:'); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Ответить', ['class' => 'btn margin']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
<?php endif; ?>
