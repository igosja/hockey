<?php

/**
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

if ($country_id = (int) f_igosja_request_get('country_id'))
{
    $where  = 'AND `country_id`=' . $country_id;
}
else
{
    $where = '';
}

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `offseason_game`,
               `offseason_loose`,
               `offseason_loose_bullet`,
               `offseason_loose_over`,
               `offseason_pass`,
               `offseason_place`,
               `offseason_point`,
               `offseason_score`,
               `offseason_win`,
               `offseason_win_bullet`,
               `offseason_win_over`,
               `team_id`,
               `team_name`,
               `team_power_vs`
        FROM `offseason`
        LEFT JOIN `team`
        ON `offseason_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `offseason_season_id`=$season_id
        $where
        ORDER BY `offseason_place` ASC";
$team_sql = f_igosja_mysqli_query($sql);

if (0 == $team_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `season_id`
        FROM `offseason`
        LEFT JOIN `season`
        ON `offseason_season_id`=`season_id`
        GROUP BY `offseason_season_id`
        ORDER BY `offseason_season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `offseason`
        LEFT JOIN `team`
        ON `offseason_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `offseason_season_id`=$season_id
        GROUP BY `country_id`
        ORDER BY `country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Кубок межсезонья';
$seo_description    = 'Кубок межсезонья, турнирная таблица на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'кубок межсезонья клк';

include(__DIR__ . '/view/layout/main.php');