<?php

include(__DIR__ . '/include/include.php');

if (!$code = f_igosja_request_get('code')) {
    redirect('/');
}

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
    redirect('/');
}

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$_SESSION['user_id'] = $user_array[0]['user_id'];

redirect('/');