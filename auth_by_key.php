<?php

include(__DIR__ . '/include/include.php');

$code = f_igosja_request_get('code');

$sql = "SELECT `user_id`
        FROM `user`
        WHERE `user_code`=?
        LIMIT 1";
$prepare = $mysqli->prepare($sql);
$prepare->bind_param('s', $code);
$prepare->execute();

$user_sql = $prepare->get_result();

$prepare->close();

if (!$user_sql->num_rows)
{
    redirect('index.php');
}

$user_array = $user_sql->fetch_all(1);

$_SESSION['user_id'] = $user_array[0]['user_id'];

redirect('index.php');

include(__DIR__ . '/view/layout/main.php');