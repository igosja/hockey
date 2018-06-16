<?php

/**
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (0 == $auth_team_id)
{
    redirect('/team_ask.php');
}

$num_get = $auth_user_id;

include(__DIR__ . '/include/sql/user_view.php');

if ($data = f_igosja_request_get('ok'))
{
    f_igosja_fire_user($auth_user_id, $auth_team_id);

    f_igosja_session_front_flash_set('success', 'Изменения успшено сохранены.');

    redirect('/team_ask.php');
}

$seo_title          = $user_array[0]['user_login'] . '. Отказ от команды';
$seo_description    = $user_array[0]['user_login'] . '. Отказ от команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' oтказ от команды';

include(__DIR__ . '/view/layout/main.php');