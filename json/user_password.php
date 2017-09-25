<?php

include(__DIR__ . '/../include/include.php');

$result = '';

if ($password = f_igosja_request_post('password_old'))
{
    $result = f_igosja_check_user_password($password);
}

print json_encode($result);
exit;