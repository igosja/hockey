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
    $auth_team_id       = $user_array[0]['team_id'];

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