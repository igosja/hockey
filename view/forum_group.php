<?php
/**
 * @var $auth_date_forum integer
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
        <?php if (isset($auth_user_id) && $auth_date_forum < time()) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a class="btn margin" href="/forum_theme_create.php?num=<?= $num_get; ?>">
                        Создать тему
                    </a>
                </div>
            </div>
        <?php } ?>
        <form method="GET">
            <input name="num" type="hidden" value="<?= $num_get; ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Всего тем: <?= $total; ?>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 text-right">
                    <label for="page">Страница:</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                    <select class="form-control" name="page" id="page">
                        <?php for ($i=1; $i<=$count_page; $i++) { ?>
                            <option
                                    value="<?= $i; ?>"
                                <?php if ($page == $i) { ?>
                                    selected
                                <?php } ?>
                            >
                                <?= $i; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </form>
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
                            <a href="/forum_theme.php?num=<?= $item['forumtheme_id']; ?>">
                                <?= $item['forumtheme_name']; ?>
                            </a>
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
    </div>
</div>