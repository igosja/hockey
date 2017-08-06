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
<?php if (isset($auth_user_id)) { ?>
    <form method="POST">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <textarea class="form-control" name="data[text]" rows="5"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input class="btn margin" type="submit" value="Ответить">
            </div>
        </div>
    </form>
<?php } ?>