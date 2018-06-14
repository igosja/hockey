<?php

/**
 * @var $auth_national_id integer
 * @var $auth_team_id integer
 * @var $num_get integer
 */

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `phisical_id`,
               `phisical_name`,
               `player_age`,
               `player_game_row`,
               `player_id`,
               `player_injury`,
               `player_injury_day`,
               `player_line_id`,
               `player_national_id`,
               `player_national_line_id`,
               `player_noaction`,
               `player_nodeal`,
               `player_position_id`,
               `player_power_nominal`,
               `player_power_real`,
               `player_price`,
               `player_rent_day`,
               `player_rent_on`,
               `player_rent_team_id`,
               `player_salary`,
               `player_style_id`,
               `player_tire`,
               `player_transfer_on`,
               `rent_team`.`team_id` AS `rent_team_id`,
               `rent_team`.`team_name` AS `rent_team_name`,
               `surname_name`,
               `team`.`team_id` AS `team_id`,
               `team`.`team_name` AS `team_name`
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
        LEFT JOIN `team` AS `rent_team`
        ON `player_rent_team_id`=`rent_team`.`team_id`
        WHERE `player_id`=$num_get
        LIMIT 1";
$player_sql = f_igosja_mysqli_query($sql);

if (0 == $player_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `playerposition_player_id`,
               `position_name`,
               `position_short`
        FROM `playerposition`
        LEFT JOIN `position`
        ON `playerposition_position_id`=`position_id`
        WHERE `playerposition_player_id`=$num_get";
$playerposition_sql = f_igosja_mysqli_query($sql);

$playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `playerspecial_level`,
               `playerspecial_player_id`,
               `special_name`,
               `special_short`
        FROM `playerspecial`
        LEFT JOIN `special`
        ON `playerspecial_special_id`=`special_id`
        WHERE `playerspecial_player_id`=$num_get
        ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
$playerspecial_sql = f_igosja_mysqli_query($sql);

$playerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `training_player_id`
        FROM `training`
        WHERE `training_player_id`=$num_get
        ANd `training_ready`=0";
$training_sql = f_igosja_mysqli_query($sql);

$training_array = $training_sql->fetch_all(MYSQLI_ASSOC);

if (isset($auth_team_id))
{
    $sql = "SELECT COUNT(`scout_id`) AS `count_scout`
            FROM `scout`
            WHERE `scout_player_id`=$num_get
            AND `scout_team_id`=$auth_team_id
            AND `scout_style`=1
            AND `scout_ready`=1";
    $scout_sql = f_igosja_mysqli_query($sql);

    $scout_array = $scout_sql->fetch_all(MYSQLI_ASSOC);

    $count_scout = $scout_array[0]['count_scout'];

    if ($player_array[0]['team_id'] == $auth_team_id || $player_array[0]['player_national_id'] == $auth_national_id)
    {
        $sql = "SELECT `line_color`,
                       `line_id`,
                       `line_name`
                FROM `line`
                ORDER BY `line_id` ASC";
        $line_sql = f_igosja_mysqli_query($sql);

        $line_array = $line_sql->fetch_all(MYSQLI_ASSOC);
    }
}
else
{
    $count_scout = 0;
}

$style_img = f_igosja_style_scout($player_array[0]['player_style_id'], $count_scout);