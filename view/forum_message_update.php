<?php
/**
 * @var $auth_use_bb integer
 * @var $forumheader_id integer
 * @var $forummessage_array array
 * @var $num_get integer
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
                <a href="/forum_chapter.php?num=<?= $forummessage_array[0]['forumchapter_id']; ?>">
                    <?= $forummessage_array[0]['forumchapter_name']; ?>
                </a>
                /
                <a href="/forum_group.php?num=<?= $forummessage_array[0]['forumgroup_id']; ?>">
                    <?= $forummessage_array[0]['forumgroup_name']; ?>
                </a>
                /
                <a href="/forum_theme.php?num=<?= $forummessage_array[0]['forumtheme_id']; ?>&page=<?= $forummessage_array[0]['last_page']; ?>">
                    <?= $forummessage_array[0]['forumtheme_name']; ?>
                </a>
                /
                Редактирование сообщения
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Редактирование сообщения</h1>
            </div>
        </div>
        <form method="POST" id="forummessage-form">
            <?php if ($forumheader_id == $num_get) { ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <label class="hidden" for="name"></label>
                        <input class="form-control" id="name" name="data[name]" value="<?= $forummessage_array[0]['forumtheme_name']; ?>" />
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label class="hidden" for="text"></label>
                    <textarea class="form-control" data-bb="<?= $auth_use_bb; ?>" id="text" name="data[text]" rows="5"><?= $forummessage_array[0]['forummessage_text']; ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <p>
                        <input class="btn" type="submit" value="Сохранить">
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>