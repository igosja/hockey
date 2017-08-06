<?php
/**
 * @var $forumgroup_array array
 * @var $forumtheme_array array
 * @var $num_get integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?= $forumgroup_array[0]['forumgroup_name']; ?></h1>
            </div>
        </div>
        <?php if (isset($auth_user_id)) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <a href="/forum_theme_create.php?num=<?= $num_get; ?>">
                        Создать тему
                    </a>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                Темы
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                Ответы
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                Просмотры
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                Последнее сообщение
            </div>
        </div>
        <?php foreach ($forumtheme_array as $item) { ?>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <a href="/forum_theme.php?num=<?= $item['forumtheme_id']; ?>">
                        <?= $item['forumtheme_name']; ?>
                    </a>
                    <br/>
                    <a href="/user_view.php?num=<?= $item['author_id']; ?>">
                        <?= $item['author_login']; ?>
                    </a>
                    <?= $item['forumtheme_last_date']; ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <?= $item['forumtheme_count_message']; ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <?= $item['forumtheme_count_view']; ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <a href="/user_view.php?num=<?= $item['lastuser_id']; ?>">
                        <?= $item['lastuser_login']; ?>
                    </a>
                    <?= $item['forumtheme_last_date']; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>