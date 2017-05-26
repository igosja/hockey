<?php

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_user_id;

include(__DIR__ . '/include/sql/user_view.php');

if ($data = f_igosja_request_post('data'))
{
    $user_holiday = (int) $data['user_holiday'];

    $sql = "UPDATE `user`
            SET `user_holiday`=$user_holiday
            WHERE `user_id`=$auth_user_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Изменения сохранены.';

    refresh();
}

$sql = "SELECT `user_holiday`
        FROM `user`
        WHERE `user_id`=$num_get";
$holiday_sql = f_igosja_mysqli_query($sql);

$holiday_array = $holiday_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');