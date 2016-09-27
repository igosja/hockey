<?php

function redirect($location)
{
    header('Location: ' . $location);
    exit;
}

function f_igosja_post($var, $subvar = '')
{
    if ($subvar) {
        if (isset($_POST[$var][$subvar])) {
            $result = $_POST[$var][$subvar];
        } else {
            $result = '';
        }
    } else {
        if (isset($_POST[$var])) {
            $result = $_POST[$var];
        } else {
            $result = '';
        }
    }
    return $result;
}

function f_igosja_get($var, $subvar = '')
{
    if ($subvar) {
        if (isset($_GET[$var][$subvar])) {
            $result = $_GET[$var][$subvar];
        } else {
            $result = '';
        }
    } else {
        if (isset($_GET[$var])) {
            $result = $_GET[$var];
        } else {
            $result = '';
        }
    }
    return $result;
}

function f_igosja_check_user_by_email($email)
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
    $check = $check_array[0]['count'];
    if ($check) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;
}

function f_igosja_check_user_by_login($login)
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
    $check = $check_array[0]['count'];
    if ($check) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;
}

function f_igosja_hash_password($password)
{
    return md5($password . md5(PASSWORD_SALT));
}

function f_igosja_generate_user_code()
{
    $code = md5(uniqid(rand(), 1));
    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_code`='$code'";
    $check_sql = igosja_db_query($sql);
    $check_array = $check_sql->fetch_all(1);
    $check = $check_array[0]['count'];
    if ($check) {
        $code = f_igosja_generate_user_code();
    }
    return $code;
}

function f_igosja_sql_data($data)
{
    $sql = array();
    foreach ($data as $key => $value) {
        $sql[] = '`' . $key . '`=\'' . $value . '\'';
    }
    $sql = implode(', ', $sql);
    return $sql;
}

function f_igosja_ufu_date_time($date)
{
    return date('H:i d.m.Y', $date);
}

function f_igosja_ufu_last_visit($date)
{
    $min_5 = $date + 5 * 60;
    $min_60 = $date + 60 * 60;
    $now = time();
    if ($min_5 >= $now) {
        $date = 'онлайн';
    } elseif ($min_60 >= $now) {
        $difference = $now - $date;
        $difference = $difference / 60;
        $difference = round($difference, 0);
        $date = $difference . ' минут назад';
    } else {
        $date = date('H:i d.m.Y', $date);
    }
    return $date;
}