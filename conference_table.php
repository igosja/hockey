<?php

/**
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `conference_game`,
               `conference_loose`,
               `conference_loose_over`,
               `conference_pass`,
               `conference_place`,
               `conference_point`,
               `conference_score`,
               `conference_win`,
               `conference_win_over`,
               `team_id`,
               `team_name`
        FROM `conference`
        LEFT JOIN `team`
        ON `conference_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `conference_season_id`=$igosja_season_id
        ORDER BY `conference_place` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');