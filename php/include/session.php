<?php

session_start();
session_regenerate_id();

if (isset($_SESSION['user_id'])) {
    $auth_user_id = $_SESSION['user_id'];
    $igosja_menu = $igosja_menu_login;
    $igosja_menu_mobile = $igosja_menu_login_mobile;

    $sql = "SELECT `user_login`
            FROM `user`
            WHERE `user_id`='$auth_user_id'
            LIMIT 1";
    $user_sql = db_query($sql);
    $user_array = $user_sql->fetch_all(1);
    $aut_user_login = $user_array[0]['user_login'];
} else {
    $igosja_menu = $igosja_menu_guest;
    $igosja_menu_mobile = $igosja_menu_guest_mobile;
}