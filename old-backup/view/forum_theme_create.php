<?php
/**
 * @var $auth_use_bb integer
 * @var $forumgroup_array array
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
                <a href="/forum_group.php?num=<?= $forumgroup_array[0]['forumgroup_id']; ?>">
                    <?= $forumgroup_array[0]['forumgroup_name']; ?>
                </a>
                /
                Создание темы
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Создание темы</h1>
            </div>
        </div>
        <form method="POST" id="forumtheme-form">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 text-right">
                    <label for="name">Заголовок:</label>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">
                    <input class="form-control" id="name" name="data[name]"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center name-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label class="hidden" for="text"></label>
                    <textarea class="form-control" data-bb="<?= $auth_use_bb; ?>" id="text" name="data[text]" rows="5"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <input class="btn margin" type="submit" value="Создать">
                </div>
            </div>
        </form>
    </div>
</div>