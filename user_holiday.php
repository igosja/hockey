<?php

/**
 * @var $auth_user_id integer
 */

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

    f_igosja_session_front_flash_set('success', 'Изменения успшено сохранены.');

    refresh();
}

$sql = "SELECT `user_holiday`
        FROM `user`
        WHERE `user_id`=$num_get";
$holiday_sql = f_igosja_mysqli_query($sql);

$holiday_array = $holiday_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $user_array[0]['user_login'] . '. Отпуск менеджера';
$seo_description    = $user_array[0]['user_login'] . '. Отпуск менеджера на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' отпуск менеджера';

include(__DIR__ . '/view/layout/main.php');