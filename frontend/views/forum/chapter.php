<?php

use common\components\ErrorHelper;
use yii\helpers\Html;

/**
 * @var \common\models\ForumChapter $forumChapter
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
                <?= $forumChapter->forum_chapter_name; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?= $forumChapter->forum_chapter_name; ?></h1>
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
        <div class="row forum-row-head">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                Разделы
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                <span class="hidden-lg hidden-md hidden-sm" title="Темы">Т</span>
                <span class="hidden-xs">Темы</span>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                <span class="hidden-lg hidden-md" title="Сообщения">C</span>
                <span class="hidden-sm hidden-xs">Сообщения</span>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                Последнее сообщение
            </div>
        </div>
        <?php foreach ($forumChapter->forumGroup as $forumGroup) : ?>
            <div class="row forum-row">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= Html::a(
                                $forumGroup->forum_group_name,
                                ['forum/group', 'id' => $forumGroup->forum_group_id]
                            ); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
                            <?= $forumGroup->forum_group_description; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                    <?= $forumGroup->countTheme(); ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                    <?= $forumGroup->countMessage(); ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-size-2">
                    <?php if ($forumGroup->forumMessage) : ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?= Html::a(
                                    $forumGroup->forumMessage->forumTheme->forum_theme_name,
                                    [
                                        'forum/theme',
                                        'id' => $forumGroup->forumMessage->forum_message_forum_theme_id
                                    ]
                                ); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?php

                                try {
                                    print Yii::$app->formatter->asDatetime(
                                        $forumGroup->forumMessage->forum_message_date,
                                        'short'
                                    );
                                } catch (Exception $e) {
                                    ErrorHelper::log($e);
                                }

                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?= $forumGroup->forumMessage->user->userLink(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>