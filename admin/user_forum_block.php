<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    if (isset($data['time']))
    {
        $time = (int) $data['time'];
    }
    else
    {
        $time = 1;
    }

    $time = $time * 86400 + time();

    $sql = "UPDATE `user`
            SET `user_date_forum_block`=$time
            WHERE `user_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/user_view.php?num=' . $num_get);
}

$sql = "SELECT `user_id`,
               `user_login`
        FROM `user`
        WHERE `user_id`=$num_get
        LIMIT 1";
$user_sql = f_igosja_mysqli_query($sql);

if (0 == $user_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'user_list.php', 'text' => 'Пользователи');
$breadcrumb_array[] = array(
    'url' => 'user_view.php?num=' . $user_array[0]['user_id'],
    'text' => $user_array[0]['user_login']
);
$breadcrumb_array[] = 'Блокирование доступа к форуму';

include(__DIR__ . '/view/layout/main.php');