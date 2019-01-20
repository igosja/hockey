<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use common\models\ForumMessage;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var ForumMessage $model
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($this->title); ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <?= Html::a(
            'Одобрить',
            ['moderation/forum-message-ok', 'id' => $model->forum_message_id],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
    <li>
        <?= Html::a(
            'Изменить',
            ['moderation/forum-message-update', 'id' => $model->forum_message_id],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
    <li>
        <?= Html::a(
            'Удалить',
            ['moderation/forum-message-delete', 'id' => $model->forum_message_id],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'format' => 'raw',
                'label' => 'Автор',
                'value' => function (ForumMessage $model) {
                    return $model->user->userLink();
                },
            ],
            [
                'label' => 'Раздел',
                'value' => function (ForumMessage $model) {
                    return $model->forumTheme->forumGroup->forumChapter->forum_chapter_name;
                },
            ],
            [
                'label' => 'Группа',
                'value' => function (ForumMessage $model) {
                    return $model->forumTheme->forumGroup->forum_group_name;
                },
            ],
            [
                'label' => 'Тема',
                'value' => function (ForumMessage $model) {
                    return $model->forumTheme->forum_theme_name;
                },
            ],
        ];
        print DetailView::widget([
            'attributes' => $attributes,
            'model' => $model,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= HockeyHelper::bbDecode($model->forum_message_text); ?>
    </div>
</div>
