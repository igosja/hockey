<?php

use common\components\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\ListView;

/**
 * @var \common\models\ForumGroup $forumGroup
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
                    $forumGroup->forumChapter->forum_chapter_name,
                    ['forum/chapter', 'id' => $forumGroup->forum_group_forum_chapter_id]
                ); ?>
                /
                <?= $forumGroup->forum_group_name; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?= $forumGroup->forum_group_name; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <?php if (!Yii::$app->user->isGuest && $user->user_date_block_forum < time() && $user->user_date_block < time()) : ?>
                    <?= Html::a(
                        'Создать тему',
                        ['forum/theme-create', 'id' => Yii::$app->request->get('id')],
                        ['class' => 'btn margin']
                    ); ?>
                <?php endif; ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <form action="/forum_search.php" class="form-inline" method="GET">
                    <label class="hidden" for="forum-search"></label>
                    <input class="form-control form-small" id="forum-search" name="q"/>
                    <button class="btn">Поиск</button>
                </form>
            </div>
        </div>
        <div class="row forum-row-head">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                Темы
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                <span class="hidden-lg hidden-md hidden-sm" title="Ответы">О</span>
                <span class="hidden-xs">Ответы</span>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                <span class="hidden-lg hidden-md" title="Просмотры">П</span>
                <span class="hidden-sm hidden-xs">Просмотры</span>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                Последнее сообщение
            </div>
        </div>
        <?php

        try {
            print ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'row forum-row'],
                'itemView' => '_theme',
                'summary' => false,
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
</div>
