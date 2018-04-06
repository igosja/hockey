<?php
/**
 * @var $forummessage_array array
 * @var $q string
 * @var $userteam_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Результаты поиска</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                <form action="/forum_search.php" class="form-inline" method="GET">
                    <label class="hidden" for="forum-search"></label>
                    <input class="form-control form-small" id="forum-search" name="q" value="<?= $q; ?>" />
                    <button class="btn">Поиск</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Всего найдено сообщений: <?= $total; ?>
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
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <?= str_ireplace($q, '<span class="info">' . $q . '</span>', f_igosja_bb_decode($item['forummessage_text'])); ?>
                        </div>
                    </div>
                    <div class="row text-size-2 font-grey">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <a href="/forum_theme.php?num=<?= $item['forumtheme_id']; ?>">Перейти в тему</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php include(__DIR__ . '/include/pagination.php'); ?>