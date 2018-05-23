<?php
/**
 * @var $auth_blockcomment_text string
 * @var $auth_blockforum_text string
 * @var $auth_date_block_comment integer
 * @var $auth_date_block_forum integer
 * @var $auth_use_bb integer
 * @var $auth_userrole_id integer
 * @var $count_page integer
 * @var $forumtheme_array array
 * @var $forummessage_array array
 * @var $num_get integer
 * @var $userteam_array array
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
                <a href="/forum_chapter.php?num=<?= $forumtheme_array[0]['forumchapter_id']; ?>">
                    <?= $forumtheme_array[0]['forumchapter_name']; ?>
                </a>
                /
                <a href="/forum_group.php?num=<?= $forumtheme_array[0]['forumgroup_id']; ?>">
                    <?= $forumtheme_array[0]['forumgroup_name']; ?>
                </a>
                /
                <?= $forumtheme_array[0]['forumtheme_name']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1><?= $forumtheme_array[0]['forumtheme_name']; ?></h1>
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
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Всего сообщений: <?= $total; ?>
            </div>
        </div>
        <?php foreach ($forummessage_array as $item) { ?>
            <div class="row forum-row forum-striped">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <a href="/user_view.php?num=<?= $item['user_id']; ?>" <?php if (USERROLE_ADMIN == $item['user_userrole_id']) { ?>class="red"<?php } ?>>
                                <?= $item['user_login']; ?>
                            </a>
                        </div>
                    </div>
                    <div class="row text-size-2 hidden-xs">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Дата регистрации:
                            <?= f_igosja_ufu_date($item['user_date_register']); ?>
                        </div>
                    </div>
                    <div class="row text-size-2 hidden-xs">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Рейтинг:
                            <?= $item['user_rating']; ?>
                        </div>
                    </div>
                    <div class="row text-size-2 hidden-xs">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Команды:
                            <?= f_igosja_team_user($item['user_id'], $userteam_array)?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <div class="row text-size-2 font-grey">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <?= f_igosja_ufu_date_time($item['forummessage_date']); ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                            <?= f_igosja_forum_message_buttons($item); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <?= f_igosja_bb_decode($item['forummessage_text']); ?>
                        </div>
                    </div>
                    <?php if ($item['forummessage_date_update']) { ?>
                        <div class="row text-size-2 font-grey">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                Отредактировано в <?= f_igosja_ufu_date_time($item['forummessage_date_update']); ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php include(__DIR__ . '/include/pagination.php'); ?>
    </div>
</div>
<?php if (isset($auth_user_id)) { ?>
    <?php if ($auth_date_block_forum < time() && $auth_date_block_comment < time()) { ?>
        <form method="POST" id="forumtheme-form">
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                    <label for="text">Ваш ответ:</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <textarea class="form-control" data-bb="<?= $auth_use_bb; ?>" id="text" name="data[text]" rows="5"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <input class="btn margin" type="submit" value="Ответить" />
                </div>
            </div>
        </form>
    <?php } elseif ($auth_date_block_forum >= time()) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к форуму до <?= f_igosja_ufu_date_time($auth_date_block_forum); ?>.
                <br/>
                Причина - <?= $auth_blockforum_text; ?>
            </div>
        </div>
    <?php } elseif ($auth_date_block_comment >= time()) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к форуму до <?= f_igosja_ufu_date_time($auth_date_block_comment); ?>.
                <br/>
                Причина - <?= $auth_blockcomment_text; ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>