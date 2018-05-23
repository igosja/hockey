<?php
/**
 * @var $forumgroup_array array
 * @var $forummessage_array array
 * @var $forumtheme_array array
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
                Перемещение сообщения
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Перемещение сообщения</h1>
            </div>
        </div>
        <form method="POST" id="moove-form">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 text-right">
                    <label for="theme">Тема:</label>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">
                    <select class="form-control form-small" id="theme" name="data[forumtheme_id]">
                        <option value="0">Создать новую</option>
                        <?php foreach ($forumtheme_array as $item) { ?>
                            <option
                                <?php if ($item['forumtheme_id'] == $forummessage_array[0]['forumtheme_id']) { ?>
                                    selected
                                <?php } ?>
                                value="<?= $item['forumtheme_id']; ?>"
                            >
                                <?= $item['forumchapter_name']; ?> / <?= $item['forumgroup_name']; ?> / <?= $item['forumtheme_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center theme-error notification-error"></div>
            </div>
            <div class="row div-name">
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 text-right">
                    <label for="group">Группа:</label>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">
                    <select class="form-control form-small" id="group" name="data[forumgroup_id]">
                        <?php foreach ($forumgroup_array as $item) { ?>
                            <option
                                <?php if ($item['forumgroup_id'] == $forummessage_array[0]['forumgroup_id']) { ?>
                                    selected
                                <?php } ?>
                                value="<?= $item['forumgroup_id']; ?>"
                            >
                                <?= $item['forumchapter_name']; ?> / <?= $item['forumgroup_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row div-name">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center name-error notification-error"></div>
            </div>
            <div class="row div-name">
                <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 text-right">
                    <label for="name">Заголовок:</label>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-9 col-xs-8">
                    <input class="form-control" id="name" name="data[name]"/>
                </div>
            </div>
            <div class="row div-name">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center name-error notification-error"></div>
            </div>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= nl2br($forummessage_array[0]['forummessage_text']); ?>
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