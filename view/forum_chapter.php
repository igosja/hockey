<?php
/**
 * @var $forumchapter_array array
 * @var $forumgroup_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?= $forumchapter_array[0]['forumchapter_name']; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                Разделы
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                Темы
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                Сообщения
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                Последнее сообщение
            </div>
        </div>
        <?php foreach ($forumgroup_array as $item) { ?>
            <div class="row">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <a href="/forum_group.php?num=<?= $item['forumgroup_id']; ?>">
                        <?= $item['forumgroup_name']; ?>
                    </a>
                    <br/>
                    <?= $item['forumgroup_description']; ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <?= $item['forumgroup_count_theme']; ?>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                    <?= $item['forumgroup_count_message']; ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <a href="/forum_theme.php?num=<?= $item['forumtheme_id']; ?>">
                        <?= $item['forumtheme_name']; ?>
                    </a>
                    <?= $item['forumgroup_last_date']; ?>
                    <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                        <?= $item['user_login']; ?>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>