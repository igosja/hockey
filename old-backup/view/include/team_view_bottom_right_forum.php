<?php
/**
 * @var $forum_array array
 */
?>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-size-2">
    <span class="italic">Последние темы на форуме федерации</span>
    <?php foreach ($forum_array as $item) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a href="/forum_theme.php?num=<?= $item['forumtheme_id']; ?>&page=<?= $item['last_page']; ?>">
                    <?= $item['forumtheme_name']; ?>
                </a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= f_igosja_ufu_date_time($item['forumtheme_last_date']); ?>
            </div>
        </div>
    <?php } ?>
</div>