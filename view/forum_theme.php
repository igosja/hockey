<?php
/**
 * @var $auth_date_forum integer
 * @var $count_page integer
 * @var $forumtheme_array array
 * @var $forummessage_array array
 * @var $num_get integer
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
        <form method="GET">
            <input name="num" type="hidden" value="<?= $num_get; ?>">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Всего сообщений: <?= $total; ?>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 text-right">
                    <label for="page">Страница:</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                    <select class="form-control" name="page" id="page">
                        <?php for ($i=1; $i<=$count_page; $i++) { ?>
                            <option
                                    value="<?= $i; ?>"
                                <?php if ($page == $i) { ?>
                                    selected
                                <?php } ?>
                            >
                                <?= $i; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </form>
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
                    <?php if ($item['team_id']) { ?>
                        <div class="row text-size-2 hidden-xs">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                Команда:
                                <img
                                    alt="<?= $item['country_name']; ?>"
                                    src="/img/country/12/<?= $item['country_id']; ?>.png"
                                    title="<?= $item['country_name']; ?>"
                                />
                                <a href="/team_view.php?num=<?= $item['team_id']; ?>" target="_blank">
                                    <?= $item['team_name']; ?>
                                    (<?= $item['city_name']; ?>)
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <div class="row text-size-2 font-grey">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <?= f_igosja_ufu_date_time($item['forummessage_date']); ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                            <?php if (isset($auth_user_id)) { ?>
                                <?php if ($auth_user_id == $item['user_id']) { ?>
                                    <a href="/forum_message_update.php?num=<?= $item['forummessage_id']; ?>">
                                        Редактировать
                                    </a>
                                    |
                                    <a href="/forum_message_delete.php?num=<?= $item['forummessage_id']; ?>">
                                        Удалить
                                    </a>
                                <?php } ?>
                                <?php if (USERROLE_USER != $auth_userrole_id) { ?>
                                    |
                                    <a href="/forum_message_moove.php?num=<?= $item['forummessage_id']; ?>">
                                        Переместить
                                    </a>
                                <?php } ?>
                            <?php } ?>
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
    </div>
</div>
<?php if (isset($auth_user_id) && $auth_date_forum < time()) { ?>
    <form method="POST" id="forumtheme-form">
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                <label for="text">Ваш ответ:</label>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <textarea class="form-control" id="text" name="data[text]" rows="5"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-error notification-error"></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input class="btn margin" type="submit" value="Ответить">
            </div>
        </div>
    </form>
<?php } ?>