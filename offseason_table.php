<?php

include (__DIR__ . '/include/include.php');

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `offseason_game`,
               `offseason_loose`,
               `offseason_loose_over`,
               `offseason_pass`,
               `offseason_place`,
               `offseason_point`,
               `offseason_score`,
               `offseason_win`,
               `offseason_win_over`,
               `team_id`,
               `team_name`
        FROM `offseason`
        LEFT JOIN `team`
        ON `offseason_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `offseason_season_id`='$igosja_season_id'
        ORDER BY `offseason_place` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');