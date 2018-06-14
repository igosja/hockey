<?php

/**
 * Рахуємо ціну хокеїстів та їх зарплати
 */
function f_igosja_generator_player_price_and_salary()
{
    global $igosja_season_id;

    $sql = "UPDATE `player`
            LEFT JOIN
            (
                SELECT `playerspecial_player_id`, SUM(`playerspecial_level`) AS `special_level`
                FROM `playerspecial`
                LEFT JOIN `player`
                ON `playerspecial_player_id`=`player_id`
                WHERE `player_age`<40
                GROUP BY `playerspecial_player_id`
            ) AS `t1`
            ON `playerspecial_player_id`=`player_id`
            LEFT JOIN
            (
                SELECT `playerposition_player_id`, COUNT(`playerposition_position_id`) AS `position`
                FROM `playerposition`
                LEFT JOIN `player`
                ON `playerposition_player_id`=`player_id`
                WHERE `player_age`<40
                GROUP BY `playerposition_player_id`
            ) AS `t2`
            ON `playerposition_player_id`=`player_id`
            SET `player_price`=POW(150-(28-`player_age`), 2)*(`position`-1+`player_power_nominal`+IFNULL(`special_level`, 0))
            WHERE `player_age`<40";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            LEFT JOIN `team`
            ON `player_team_id`=`team_id`
            LEFT JOIN `base`
            ON `team_base_id`=`base_id`
            LEFT JOIN
            (
                SELECT `championship_team_id`,
                       `championship_division_id`
                FROM `championship`
                WHERE `championship_season_id`=$igosja_season_id
            ) AS `t1`
            ON `team_id`=`championship_team_id`
            SET `player_salary`=`player_price`*(`base_level`+3)/10000*IF(`championship_division_id`=1, 1, IF(`championship_division_id`=2, 0.95, IF(`championship_division_id`=3, 0.90, 0.8)))
            WHERE `championship_team_id` IS NOT NULL";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            LEFT JOIN `team`
            ON `player_team_id`=`team_id`
            LEFT JOIN `base`
            ON `team_base_id`=`base_id`
            LEFT JOIN
            (
                SELECT `conference_team_id`
                FROM `conference`
                WHERE `conference_season_id`=$igosja_season_id
            ) AS `t1`
            ON `team_id`=`conference_team_id`
            SET `player_salary`=`player_price`*(`base_level`+3)/10000*0.7
            WHERE `conference_team_id` IS NOT NULL";
    f_igosja_mysqli_query($sql);
}