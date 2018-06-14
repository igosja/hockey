<?php

/**
 * @var $auth_team_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

if (0 == $auth_team_id)
{
    redirect('/team_ask.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `guest_city`.`city_name` AS `guest_city_name`,
               `guest_country`.`country_name` AS `guest_country_name`,
               `guest_national_country`.`country_name` AS `guest_national_name`,
               `guest_national`.`national_id` AS `guest_national_id`,
               `guest_nationaltype`.`nationaltype_name` AS `guest_nationaltype_name`,
               `guest_team`.`team_salary` AS `guest_team_salary`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `guest_team`.`team_visitor` AS `guest_team_visitor`,
               `home_city`.`city_name` AS `home_city_name`,
               `home_country`.`country_name` AS `home_country_name`,
               `home_national_country`.`country_name` AS `home_national_name`,
               `home_national`.`national_id` AS `home_national_id`,
               `home_nationaltype`.`nationaltype_name` AS `home_nationaltype_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `home_team`.`team_salary` AS `home_team_salary`,
               `home_team`.`team_visitor` AS `home_team_visitor`,
               IFNULL(`playerspecial_level`, 0) AS `playerspecial_level`,
               `schedule_date`,
               `schedule_season_id`,
               `home_stadium`.`stadium_capacity` AS `stadium_capacity`,
               `home_stadium`.`stadium_maintenance` AS `stadium_maintenance`,
               `home_stadium`.`stadium_name` AS `stadium_name`,
               `stage_name`,
               `stage_visitor`,
               `tournamenttype_id`,
               `tournamenttype_name`,
               `tournamenttype_visitor`
        FROM `game`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        LEFT JOIN `tournamenttype`
        ON `schedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `stadium` AS `guest_stadium`
        ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
        LEFT JOIN `city` AS `guest_city`
        ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
        LEFT JOIN `country` AS `guest_country`
        ON `guest_city`.`city_country_id`=`guest_country`.`country_id`
        LEFT JOIN `national` AS `guest_national`
        ON `game_guest_national_id`=`guest_national`.`national_id`
        LEFT JOIN `nationaltype` AS `guest_nationaltype`
        ON `guest_national`.`national_nationaltype_id`=`guest_nationaltype`.`nationaltype_id`
        LEFT JOIN `country` AS `guest_national_country`
        ON `guest_national`.`national_country_id`=`guest_national_country`.`country_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `stadium` AS `home_stadium`
        ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
        LEFT JOIN `city` AS `home_city`
        ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
        LEFT JOIN `country` AS `home_country`
        ON `home_city`.`city_country_id`=`home_country`.`country_id`
        LEFT JOIN `national` AS `home_national`
        ON `game_home_national_id`=`home_national`.`national_id`
        LEFT JOIN `nationaltype` AS `home_nationaltype`
        ON `home_national`.`national_nationaltype_id`=`home_nationaltype`.`nationaltype_id`
        LEFT JOIN `country` AS `home_national_country`
        ON `home_national`.`national_country_id`=`home_national_country`.`country_id`
        LEFT JOIN
        (
            SELECT `lineup_game_id`,
                   SUM(`playerspecial_level`) AS `playerspecial_level`
            FROM `playerspecial`
            LEFT JOIN `lineup`
            ON `playerspecial_player_id`=`lineup_player_id`
            WHERE `playerspecial_special_id`=" . SPECIAL_IDOL . "
            AND `lineup_game_id`=$num_get
        ) AS `t1`
        ON `game_id`=`lineup_game_id`
        WHERE (`game_guest_team_id`=$auth_team_id
        OR `game_home_team_id`=$auth_team_id)
        AND `game_played`=0
        AND `game_id`=$num_get
        LIMIT 1";
$game_sql = f_igosja_mysqli_query($sql);

if (0 == $game_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

$guest_visitor          = $game_array[0]['guest_team_visitor'];
$home_visitor           = $game_array[0]['home_team_visitor'];
$special                = $game_array[0]['playerspecial_level'];
$stadium_capacity       = $game_array[0]['stadium_capacity'];
$stage_visitor          = $game_array[0]['stage_visitor'];
$tournamenttype_id      = $game_array[0]['tournamenttype_id'];
$tournamenttype_visitor = $game_array[0]['tournamenttype_visitor'];

$game_visitor = $stadium_capacity;
$game_visitor = $game_visitor * $tournamenttype_visitor;
$game_visitor = $game_visitor * $stage_visitor;

$visitor_array = array();

for ($i=10; $i<=50; $i++)
{
    $visitor = $game_visitor / pow(($i - GAME_TICKET_BASE_PRICE) / 10, 1.1);

    if (in_array($tournamenttype_id, array(TOURNAMENTTYPE_FRIENDLY, TOURNAMENTTYPE_NATIONAL)))
    {
        $visitor = $visitor * ($home_visitor + $guest_visitor) / 2;
    }
    else
    {
        $visitor = $visitor * ($home_visitor * 2 + $guest_visitor) / 3;
    }

    $visitor = $visitor * (100 + $special * 5);
    $visitor = $visitor / 100000000;
    $visitor = round($visitor);

    if ($visitor > $stadium_capacity)
    {
        $visitor = $stadium_capacity;
    }

    $visitor_array['visitor'][$i]   = $visitor;
    $visitor_array['income'][$i]    = $visitor * $i;
}

$x_data         = array_keys($visitor_array['visitor']);
$x_data         = implode(',', $x_data);
$s_data_visitor = implode(',', $visitor_array['visitor']);
$s_data_income  = implode(',', $visitor_array['income']);

$seo_title          = 'График посещаемости на игру';
$seo_description    = 'График посещаемости на игру на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'график посещаемости на игру';

include(__DIR__ . '/view/layout/main.php');