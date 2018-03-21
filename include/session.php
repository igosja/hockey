<?php

/**
 * @var $igosja_menu_login array
 * @var $igosja_menu_login_mobile array
 * @var $igosja_menu_guest array
 * @var $igosja_menu_guest_mobile array
 */

session_start();
session_regenerate_id();

if (isset($_SESSION['user_id']))
{
    $auth_user_id       = $_SESSION['user_id'];
    $igosja_menu        = $igosja_menu_login;
    $igosja_menu_mobile = $igosja_menu_login_mobile;

    if (isset($_SESSION['team_id']))
    {
        $auth_team_id = $_SESSION['team_id'];

        $and_where = "AND `team_id`=$auth_team_id";
    }
    else
    {
        $and_where = "";
    }

    $sql = "SELECT `city_country_id`,
                   `national`.`national_id` AS `national_id`,
                   `nationalvice`.`national_id` AS `nationalvice_id`,
                   `team_id`,
                   `user_code`,
                   `user_date_block`,
                   `user_date_confirm`,
                   `user_date_forum_block`,
                   `user_date_vip`,
                   `user_login`,
                   `user_reason_block`,
                   `user_use_bb`,
                   `user_userrole_id`
            FROM `user`
            LEFT JOIN `team`
            ON `user_id`=`team_user_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `national` AS `national`
            ON `user_id`=`national`.`national_user_id`
            LEFT JOIN `national` AS `nationalvice`
            ON `user_id`=`nationalvice`.`national_vice_id`
            WHERE `user_id`=$auth_user_id
            $and_where
            LIMIT 1";
    $user_sql = f_igosja_mysqli_query($sql);

    if (0 == $user_sql->num_rows)
    {
        unset($_SESSION['team_id']);

        refresh();
    }

    $user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

    $auth_country_id        = $user_array[0]['city_country_id'];
    $auth_date_forum        = $user_array[0]['user_date_forum_block'];
    $auth_date_vip          = $user_array[0]['user_date_vip'];
    $auth_team_id           = $user_array[0]['team_id'];
    $auth_national_id       = $user_array[0]['national_id'];
    $auth_nationalvice_id   = $user_array[0]['nationalvice_id'];
    $auth_user_login        = $user_array[0]['user_login'];
    $auth_use_bb            = $user_array[0]['user_use_bb'];
    $auth_userrole_id       = $user_array[0]['user_userrole_id'];

    if ($user_array[0]['user_date_block'] > time())
    {
        f_igosja_session_front_flash_set('error', 'Вам заблокирован доступ к сайту.<br/>Причина - ' . $user_array[0]['user_reason_block']);

        if (!in_array($tpl, array('index', 'logout', 'support')))
        {
            redirect('/index.php');
        }
    }

    if (0 == $user_array[0]['user_date_confirm'] && !in_array($tpl, array('activation', 'activation_repeat', 'logout', 'support', 'user_questionnaire', 'user_view')))
    {
        f_igosja_session_front_flash_set('error', 'Ваш email не подтвержден.');

        redirect('/activation.php');
    }

    if (!$auth_country_id)
    {
        $auth_country_id = 0;
    }

    if (!$auth_national_id)
    {
        $auth_national_id = 0;
    }

    if (!$auth_team_id)
    {
        $auth_team_id = 0;
    }

    $sql = "SELECT COUNT(`message_id`) AS `count`
            FROM `message`
            WHERE `message_support_from`=0
            AND`message_support_to`=0
            AND `message_user_id_to`=$auth_user_id
            AND `message_read`=0";
    $dialog_sql = f_igosja_mysqli_query($sql);

    $dialog_array = $dialog_sql->fetch_all(MYSQLI_ASSOC);
    $count_dialog = $dialog_array[0]['count'];

    if ($count_dialog)
    {
        $igosja_menu        = str_replace('count_dialog', 'red', $igosja_menu);
        $igosja_menu_mobile = str_replace('count_dialog', 'red', $igosja_menu_mobile);
    }
    else
    {
        $igosja_menu        = str_replace('count_dialog', '', $igosja_menu);
        $igosja_menu_mobile = str_replace('count_dialog', '', $igosja_menu_mobile);
    }

    $sql = "SELECT COUNT(`message_id`) AS `count`
            FROM `message`
            WHERE `message_support_from`=1
            AND `message_user_id_to`=$auth_user_id
            AND `message_read`=0";
    $support_sql = f_igosja_mysqli_query($sql);

    $support_array = $support_sql->fetch_all(MYSQLI_ASSOC);
    $count_support = $support_array[0]['count'];

    if ($count_support)
    {
        $igosja_menu        = str_replace('count_support', 'red', $igosja_menu);
        $igosja_menu_mobile = str_replace('count_support', 'red', $igosja_menu_mobile);
    }
    else
    {
        $igosja_menu        = str_replace('count_support', '', $igosja_menu);
        $igosja_menu_mobile = str_replace('count_support', '', $igosja_menu_mobile);
    }

    $sql = "SELECT COUNT(`vote_id`) AS `count`
            FROM `vote`
            WHERE `vote_votestatus_id`=" . VOTESTATUS_OPEN . "
            AND `vote_country_id` IN (0, $auth_country_id)
            AND `vote_id`>
            (
                SELECT IF(MAX(`voteuser_vote_id`) IS NULL, 0, MAX(`voteuser_vote_id`))
                FROM `voteuser`
                WHERE `voteuser_user_id`=$auth_user_id
            )";
    $vote_sql = f_igosja_mysqli_query($sql);

    $vote_array = $vote_sql->fetch_all(MYSQLI_ASSOC);
    $count_vote = $vote_array[0]['count'];

    if ($count_vote)
    {
        $igosja_menu        = str_replace('count_vote', 'red', $igosja_menu);
        $igosja_menu_mobile = str_replace('count_vote', 'red', $igosja_menu_mobile);
    }
    else
    {
        $igosja_menu        = str_replace('count_vote', '', $igosja_menu);
        $igosja_menu_mobile = str_replace('count_vote', '', $igosja_menu_mobile);
    }

    $sql = "SELECT COUNT(`news_id`) AS `count`
            FROM `news`
            WHERE `news_id`>
            (
                SELECT `user_news_id`
                FROM `user`
                WHERE `user_id`=$auth_user_id
            )
            AND `news_country_id`=0";
    $news_sql = f_igosja_mysqli_query($sql);

    $news_array = $news_sql->fetch_all(MYSQLI_ASSOC);
    $count_news = $news_array[0]['count'];

    if ($count_news)
    {
        $igosja_menu        = str_replace('count_news', 'red', $igosja_menu);
        $igosja_menu_mobile = str_replace('count_news', 'red', $igosja_menu_mobile);
    }
    else
    {
        $igosja_menu        = str_replace('count_news', '', $igosja_menu);
        $igosja_menu_mobile = str_replace('count_news', '', $igosja_menu_mobile);
    }

    $sql = "SELECT COUNT(`news_id`) AS `count`
            FROM `news`
            WHERE `news_id`>
            (
                SELECT `user_countrynews_id`
                FROM `user`
                WHERE `user_id`=$auth_user_id
            )
            AND `news_country_id`=$auth_country_id";
    $countrynews_sql = f_igosja_mysqli_query($sql);

    $countrynews_array = $countrynews_sql->fetch_all(MYSQLI_ASSOC);
    $count_countrynews = $countrynews_array[0]['count'];

    if ($count_countrynews)
    {
        $igosja_menu        = str_replace('count_countrynews', 'red', $igosja_menu);
        $igosja_menu_mobile = str_replace('count_countrynews', 'red', $igosja_menu_mobile);
    }
    else
    {
        $igosja_menu        = str_replace('count_countrynews', '', $igosja_menu);
        $igosja_menu_mobile = str_replace('count_countrynews', '', $igosja_menu_mobile);
    }

    if (0 != $auth_national_id || 0 != $auth_nationalvice_id)
    {
        $igosja_menu        = str_replace('national_css', '', $igosja_menu);
        $igosja_menu_mobile = str_replace('national_css', '', $igosja_menu_mobile);
    }
    else
    {
        $igosja_menu        = str_replace(' | <a href="/national_view.php" class="national_css">Сборная</a>', '', $igosja_menu);
        $igosja_menu_mobile = str_replace(' | <a href="/national_view.php" class="national_css">Сборная</a>', '', $igosja_menu_mobile);
    }

    $sql = "SELECT `country_name`,
                   `team_id`,
                   `team_name`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            WHERE `team_user_id`=$auth_user_id
            ORDER BY `team_id` ASC";
    $auth_team_sql = f_igosja_mysqli_query($sql);

    $auth_team_array = $auth_team_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "UPDATE `user`
            SET `user_date_login`=UNIX_TIMESTAMP(),
                `user_ip`='" . f_igosja_get_user_ip() . "'
            WHERE `user_id`=$auth_user_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}
else
{
    $igosja_menu        = $igosja_menu_guest;
    $igosja_menu_mobile = $igosja_menu_guest_mobile;
}

if (isset($_SESSION['admin_user_id']))
{
    $auth_admin_user_id = $_SESSION['admin_user_id'];
}