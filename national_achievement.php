<?php

/**
 * @var $auth_national_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_national_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_national_id)
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_national_id;
}

include(__DIR__ . '/include/sql/national_view_left.php');
include(__DIR__ . '/include/sql/national_view_right.php');

$sql = "SELECT `achievement_season_id`,
               `achievement_position`,
               `tournamenttype_name`
        FROM `achievement`
        LEFT JOIN `tournamenttype`
        ON `achievement_tournamenttype_id`=`tournamenttype_id`
        WHERE `achievement_national_id`=$num_get
        ORDER BY `achievement_id` DESC";
$achievement_sql = f_igosja_mysqli_query($sql);

$achievement_array = $achievement_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $national_array[0]['country_name'] . '. Достижения команды';
$seo_description    = $national_array[0]['country_name'] . '. Достижения команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $national_array[0]['country_name'] . ' достижения команды';

include(__DIR__ . '/view/layout/main.php');