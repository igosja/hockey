<?php

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `phisical_id`,
               `phisical_value`,
               `player_age`,
               `player_game_row`,
               `player_id`,
               `player_power_nominal`,
               `player_power_real`,
               `player_price`,
               `player_salary`,
               `player_tire`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `phisical`
        ON `player_phisical_id`=`phisical_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        WHERE `player_id`=$num_get
        LIMIT 1";
$player_sql = f_igosja_mysqli_query($sql);

if (0 == $player_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$player_array = $player_sql->fetch_all(1);

$sql = "SELECT `playerposition_player_id`,
               `position_name`
        FROM `playerposition`
        LEFT JOIN `position`
        ON `playerposition_position_id`=`position_id`
        WHERE `playerposition_player_id`=$num_get
        ORDER BY `playerposition_position_id` ASC";
$playerposition_sql = f_igosja_mysqli_query($sql);

$playerposition_array = $playerposition_sql->fetch_all(1);

$sql = "SELECT `playerspecial_level`,
               `playerspecial_player_id`,
               `special_name`
        FROM `playerspecial`
        LEFT JOIN `special`
        ON `playerspecial_special_id`=`special_id`
        WHERE `playerspecial_player_id`=$num_get
        ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
$playerspecial_sql = f_igosja_mysqli_query($sql);

$playerspecial_array = $playerspecial_sql->fetch_all(1);