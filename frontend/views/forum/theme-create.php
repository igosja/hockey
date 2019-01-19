<?php

use coderlex\wysibb\WysiBB;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\ForumGroup $forumGroup
 * @var \frontend\models\ForumThemeForm $model
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
                    $forumGroup->forumChapter->forum_chapter_name,
                    ['forum/chapter', 'id' => $forumGroup->forumChapter->forum_chapter_id]
                ); ?>
                /
                <?= Html::a(
                    $forumGroup->forum_group_name,
                    ['forum/group', 'id' => $forumGroup->forum_group_id]
                ); ?>
                /
                Создание темы
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Создание темы</h1>
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
                'template' =>
                    '<div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 text-right">{label}</div>
                    <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">{input}</div>
                    {error}',
            ],
        ]); ?>
        <?= $form->field($model, 'name')->textInput(); ?>
        <?= $form->field($model, 'text', [
            'template' => '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{input}</div>{error}',
        ])->widget(WysiBB::class)->label(false); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Создать', ['class' => 'btn margin']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
