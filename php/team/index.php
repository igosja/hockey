<?php

$num_get = 1;

$sql = "SELECT `team_name`
        FROM `team`
        WHERE `team_id`='$num_get'";
$team_sql = igosja_db_query($sql);

$team_sql = igosja_db_query($sql);

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `player_age`,
               `player_game_row`,
               `player_id`,
               `player_power_nominal`,
               `player_power_real`,
               `player_price`,
               `player_tire`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        WHERE `player_team_id`='$num_get'";
$player_sql = igosja_db_query($sql);

$player_array = $player_sql->fetch_all(1);