<?php

if ($email = igosja_get_post('email')) {
    $email = trim($email);
    $result = igosja_check_user_by_email($email);
    print json_encode($result);
    exit;
} elseif ($login = igosja_get_post('login')) {
    $login = trim($login);
    $result = igosja_check_user_by_login($login);
    print json_encode($result);
    exit;
}