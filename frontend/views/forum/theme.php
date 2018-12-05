<?php

use common\components\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/**
 * @var \common\models\ForumTheme $forumTheme
 * @var \common\models\User $user
 * @var \yii\data\ActiveDataProvider $dataProvider
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
                <form action="/forum_search.php" class="form-inline" method="GET">
                    <label class="hidden" for="forum-search"></label>
                    <input class="form-control form-small" id="forum-search" name="q"/>
                    <button class="btn">Поиск</button>
                </form>
            </div>
        </div>
        <?php

        try {
            print ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'row forum-row forum-striped'],
                'itemView' => '_message',
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
</div>
<?php if (!Yii::$app->user->isGuest) : ?>
    <?php if ($user->user_date_block_forum >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к форуму до
                <?php

                try {
                    Yii::$app->formatter->asDatetime($user->user_date_block_forum, 'short');
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?>
                <br/>
                Причина - <?= $user->reasonBlockForum->block_reason_text; ?>
            </div>
        </div>
    <?php elseif ($user->user_date_block_comment >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к форуму до
                <?php

                try {
                    Yii::$app->formatter->asDatetime($user->user_date_block_comment, 'short');
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?>
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
        <?= $form->field($model, 'forum_message_text')->textarea(['rows' => 5])->label('Ваш ответ:'); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Ответить', ['class' => 'btn margin']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
<?php endif; ?>
