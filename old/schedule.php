<?php

/**
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

if ($season_id > $igosja_season_id)
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `schedule_date`,
               `schedule_id`,
               `stage_name`,
               `tournamenttype_name`
        FROM `schedule`
        LEFT JOIN `tournamenttype`
        ON `schedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        WHERE `schedule_season_id`=$season_id
        ORDER BY `schedule_id`ASC";
$schedule_sql = f_igosja_mysqli_query($sql);

$schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Расписание. Сезон ' . $igosja_season_id;
$seo_description    = 'Сезон ' . $igosja_season_id . '. Расписание на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'расписание сезон ' . $igosja_season_id;

include(__DIR__ . '/view/layout/main.php');