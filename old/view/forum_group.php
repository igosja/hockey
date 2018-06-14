<?php
/**
 * @var $auth_date_block_forum integer
 * @var $auth_userrole_id integer
 * @var $count_page integer
 * @var $forumgroup_array array
 * @var $forumtheme_array array
 * @var $num_get integer
 * @var $total integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
                <a href="/forum.php">
                    Форум
                </a>
                /
                <a href="/forum_chapter.php?num=<?= $forumgroup_array[0]['forumchapter_id']; ?>">
                    <?= $forumgroup_array[0]['forumchapter_name']; ?>
                </a>
                /
                <?= $forumgroup_array[0]['forumgroup_name']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?= $forumgroup_array[0]['forumgroup_name']; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <?php if (isset($auth_user_id) && $auth_date_block_forum < time()) { ?>
                    <a class="btn margin" href="/forum_theme_create.php?num=<?= $num_get; ?>">
                        Создать тему
                    </a>
                <?php } ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                <form action="/forum_search.php" class="form-inline" method="GET">
                    <label class="hidden" for="forum-search"></label>
                    <input class="form-control form-small" id="forum-search" name="q" />
                    <button class="btn">Поиск</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Всего тем: <?= $total; ?>
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
        <?php foreach ($forumtheme_array as $item) { ?>
            <div class="row forum-row">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <a href="/forum_theme.php?num=<?= $item['forumtheme_id']; ?>&page=<?= $item['last_page']; ?>">
                                <?= $item['forumtheme_name']; ?>
                            </a>
                            <?php if (isset($auth_user_id) && USERROLE_USER != $auth_userrole_id) { ?>
                                |
                                <a class="font-grey" href="/forum_theme_delete.php?num=<?= $item['forumtheme_id']; ?>">
                                    удалить
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row text-size-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <a href="/user_view.php?num=<?= $item['author_id']; ?>">
                                <?= $item['author_login']; ?>
                            </a>
                        </div>
                    </div>
                    <div class="row text-size-2">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= f_igosja_ufu_date_time($item['forumtheme_last_date']); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                    <?= $item['forumtheme_count_message']; ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                    <?= $item['forumtheme_count_view']; ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-size-2">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <a href="/user_view.php?num=<?= $item['lastuser_id']; ?>">
                                <?= $item['lastuser_login']; ?>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= f_igosja_ufu_date_time($item['forumtheme_last_date']); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php include(__DIR__ . '/include/pagination.php'); ?>
    </div>
</div>