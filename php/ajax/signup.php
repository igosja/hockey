<?php

if ($email = f_igosja_post('email')) {
    $email = trim($email);
    $result = f_igosja_check_user_by_email($email);
    print json_encode($result);
    exit;
} elseif ($login = f_igosja_post('login')) {
    $login = trim($login);
    $result = f_igosja_check_user_by_login($login);
    print json_encode($result);
    exit;
}