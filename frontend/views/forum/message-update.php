<?php

use coderlex\wysibb\WysiBB;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\ForumMessage $model
 */

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
                    $model->forumTheme->forumGroup->forumChapter->forum_chapter_name,
                    ['forum/chapter', 'id' => $model->forumTheme->forumGroup->forumChapter->forum_chapter_id]
                ); ?>
                /
                <?= Html::a(
                    $model->forumTheme->forumGroup->forum_group_name,
                    ['forum/group', 'id' => $model->forumTheme->forumGroup->forum_group_id]
                ); ?>
                /
                <?= Html::a(
                    $model->forumTheme->forum_theme_name,
                    ['forum/theme', 'id' => $model->forumTheme->forum_theme_id]
                ); ?>
                /
                Редактирование сообщения
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Редактирование сообщения</h1>
            </div>
        </div>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 xs-text-center notification-error',
                    'tag' => 'div'
                ],
                'labelOptions' => ['class' => 'strong'],
                'options' => ['class' => 'row'],
                'template' => '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{input}</div>{error}',
            ],
        ]); ?>
        <?= $form->field($model, 'forum_message_text')->widget(WysiBB::class)->label(false); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Сохранить', ['class' => 'btn margin']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
