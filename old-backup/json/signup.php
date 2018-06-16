<?php

include(__DIR__ . '/../include/include.php');

$result = '';

if ($email = f_igosja_request_post('signup_email'))
{
    $email  = trim($email);
    $result = f_igosja_check_user_by_email($email);
}
elseif ($login = f_igosja_request_post('signup_login'))
{
    $login  = trim($login);
    $result = f_igosja_check_user_by_login($login);
}

print json_encode($result);
exit;