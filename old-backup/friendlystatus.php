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
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    if (!isset($data['friendlystatus_id']))
    {
        f_igosja_session_front_flash_set('error', 'Статус выбран неправильно.');
    }

    $friendlystatus_id = (int) $data['friendlystatus_id'];

    $sql = "SELECT COUNT(`friendlystatus_id`) AS `count`
            FROM `friendlystatus`
            WHERE `friendlystatus_id`=$friendlystatus_id";
    $friendlystatus_sql = f_igosja_mysqli_query($sql);

    if (0 == $friendlystatus_sql->num_rows)
    {
        f_igosja_session_front_flash_set('error', 'Статус выбран неправильно.');

        refresh();
    }

    $friendlystatus_array = $friendlystatus_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "UPDATE `user`
            SET `user_friendlystatus_id`=$friendlystatus_id
            WHERE `user_id`=$auth_user_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    f_igosja_session_front_flash_set('success', 'Изменения успешно сохранены.');

    refresh();
}

$sql = "SELECT `city_name`,
               `country_name`,
               `user_friendlystatus_id`,
               `team_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `user`
        ON `team_user_id`=`user_id`
        WHERE `team_id`=$auth_team_id
        LIMIT 1";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `friendlystatus_id`,
               `friendlystatus_name`
        FROM `friendlystatus`
        ORDER BY `friendlystatus_id` ASC";
$friendlystatus_sql = f_igosja_mysqli_query($sql);

$friendlystatus_array = $friendlystatus_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Изменения статуса в товарищеских матчах';
$seo_description    = 'Изменения статуса в товарищеских матчах на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'Изменения статуса в товарищеских матчах';

include(__DIR__ . '/view/layout/main.php');