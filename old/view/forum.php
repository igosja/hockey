<?php
/**
 * @var $forum_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Форум</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                <form action="/forum_search.php" class="form-inline" method="GET">
                    <label class="hidden" for="forum-search"></label>
                    <input class="form-control form-small" id="forum-search" name="q" />
                    <button class="btn">Поиск</button>
                </form>
            </div>
        </div>
        <?php foreach ($forum_array as $chapter) { ?>
            <div class="row margin-top forum-row-head">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <a href="/forum_chapter.php?num=<?= $chapter['forumchapter_id']; ?>">
                        <?= $chapter['forumchapter_name']; ?>
                    </a>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                    <span class="hidden-lg hidden-md hidden-sm" title="Темы">Т</span>
                    <span class="hidden-xs">Темы</span>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                    <span class="hidden-lg hidden-md" title="Сообщения">C</span>
                    <span class="hidden-sm hidden-xs">Сообщения</span>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    Последнее сообщение
                </div>
            </div>
            <?php foreach ($chapter['forumgroup'] as $item) { ?>
                <div class="row forum-row">
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <a href="/forum_group.php?num=<?= $item['forumgroup_id']; ?>">
                                    <?= $item['forumgroup_name']; ?>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
                                <?= $item['forumgroup_description']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                        <?= $item['forumgroup_count_theme']; ?>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                        <?= $item['forumgroup_count_message']; ?>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-size-2">
                        <?php if ($item['forumtheme_id']) { ?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <a href="/forum_theme.php?num=<?= $item['forumtheme_id']; ?>&page=<?= $item['last_page']; ?>">
                                        <?= $item['forumtheme_name']; ?>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?= f_igosja_ufu_date_time($item['forumgroup_last_date']); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                                        <?= $item['user_login']; ?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>