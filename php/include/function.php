<?php

function redirect($location)
{
    header('Location: ' . $location);
    exit;
}

function igosja_get_post($var)
{
    if (isset($_POST[$var])) {
        $result = $_POST[$var];
    } else {
        $result = '';
    }
    return $result;
}

function igosja_get_get($var)
{
    if (isset($_GET[$var])) {
        $result = $_GET[$var];
    } else {
        $result = '';
    }
    return $result;
}

function igosja_check_user_by_email($email)
{
    global $mysqli;
    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_email`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $email);
    $prepare->execute();
    $check_sql = $prepare->get_result();
    $prepare->close();
    $check_array = $check_sql->fetch_all(1);
    $check       = $check_array[0]['count'];
    if ($check) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;
}

function igosja_check_user_by_login($login)
{
    global $mysqli;
    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_login`=?";
    $prepare = $mysqli->prepare($sql);
    $prepare->bind_param('s', $login);
    $prepare->execute();
    $check_sql = $prepare->get_result();
    $prepare->close();
    $check_array = $check_sql->fetch_all(1);
    $check       = $check_array[0]['count'];
    if ($check) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;
}

function igosja_hash_password($password) {
    return md5($password . md5(PASSWORD_SALT));
}