<?php

session_start();
session_regenerate_id();

if (isset($_SESSION['user_id']))
{
    $auth_user_id       = $_SESSION['user_id'];
    $igosja_menu        = $igosja_menu_login;
    $igosja_menu_mobile = $igosja_menu_login_mobile;

    $sql = "SELECT `team_id`,
                   `user_login`,
                   `user_userrole_id`
            FROM `user`
            LEFT JOIN `team`
            ON `user_id`=`team_user_id`
            WHERE `user_id`='$auth_user_id'
            LIMIT 1";
    $user_sql = igosja_db_query($sql);

    $user_array = $user_sql->fetch_all(1);

    $auth_user_login    = $user_array[0]['user_login'];
    $auth_userrole_id   = $user_array[0]['user_userrole_id'];
    $auth_team_id       = (int) $user_array[0]['team_id'];

    $sql = "SELECT COUNT(`message_id`) AS `count`
            FROM `message`
            WHERE `message_support_from`='1'
            AND `message_user_id_to`='$auth_user_id'
            AND `message_read`='0'";
    $support_sql = igosja_db_query($sql);

    $support_array = $support_sql->fetch_all(1);
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
            WHERE `vote_votestatus_id`='" . VOTESTATUS_OPEN . "'
            AND `vote_country_id`='0'
            AND `vote_id`>
            (
                SELECT IF(MAX(`voteuser_vote_id`) IS NULL, 0, MAX(`voteuser_vote_id`))
                FROM `voteuser`
                WHERE `voteuser_user_id`='$auth_user_id'
            )";
    $vote_sql = igosja_db_query($sql);

    $vote_array = $vote_sql->fetch_all(1);
    $count_vote = $vote_array[0]['count'];

    unset ($vote_array);

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

    $sql = "UPDATE `user`
            SET `user_date_login`=UNIX_TIMESTAMP()
            WHERE `user_id`='$auth_user_id'
            LIMIT 1";
    igosja_db_query($sql);
}
else
{
    $igosja_menu        = $igosja_menu_guest;
    $igosja_menu_mobile = $igosja_menu_guest_mobile;
}

unset($igosja_menu_login, $igosja_menu_login_mobile, $igosja_menu_guest, $igosja_menu_guest_mobile);