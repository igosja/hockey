<?php
/**
 * @var $forumtheme_array array
 * @var $forummessage_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?= $forumtheme_array[0]['forumtheme_name']; ?></h1>
            </div>
        </div>
        <?php foreach ($forummessage_array as $item) { ?>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <a href="/forum_theme.php?num==<?= $item['forumtheme_id']; ?>">
                        <?= $item['forumtheme_name']; ?>
                    </a>
                    <br />
                    <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                        <?= $item['user_login']; ?>
                    </a>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <?= $forumtheme_array[0]['forumtheme_name']; ?>
                    <br />
                    <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                        <?= $item['user_login']; ?>
                    </a>
                    <?= $item['forummessage_date']; ?>
                    <br />
                    <?= $item['forummessage_text']; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>