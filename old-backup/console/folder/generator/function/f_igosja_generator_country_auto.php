<?php

/**
 * Перерахунок відсотків автоскладів в кожній країні
 */
function f_igosja_generator_country_auto()
{
    $sql = "UPDATE `country`
            LEFT JOIN
            (
                SELECT COUNT(`game_id`) AS `count_home_game`,
                       `city_country_id`
                FROM `game`
                LEFT JOIN `team`
                ON `game_home_team_id`=`team_id`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                GROUP BY `city_country_id`
            ) AS `t1`
            ON `country_id`=`t1`.`city_country_id`
            LEFT JOIN
            (
                SELECT COUNT(`game_id`) AS `count_guest_game`,
                       `city_country_id`
                FROM `game`
                LEFT JOIN `team`
                ON `game_guest_team_id`=`team_id`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                GROUP BY `city_country_id`
            ) AS `t2`
            ON `country_id`=`t2`.`city_country_id`
            LEFT JOIN
            (
                SELECT COUNT(`game_id`) AS `count_home_game_auto`,
                       `city_country_id`
                FROM `game`
                LEFT JOIN `team`
                ON `game_home_team_id`=`team_id`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                AND `game_home_auto`=1
                GROUP BY `city_country_id`
            ) AS `t3`
            ON `country_id`=`t3`.`city_country_id`
            LEFT JOIN
            (
                SELECT COUNT(`game_id`) AS `count_guest_game_auto`,
                       `city_country_id`
                FROM `game`
                LEFT JOIN `team`
                ON `game_guest_team_id`=`team_id`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                AND `game_guest_auto`=1
                GROUP BY `city_country_id`
            ) AS `t4`
            ON `country_id`=`t4`.`city_country_id`
            SET `country_game`=`country_game`+IFNULL(`count_home_game`, 0)+IFNULL(`count_guest_game`, 0),
                `country_auto`=`country_auto`+IFNULL(`count_home_game_auto`, 0)+IFNULL(`count_guest_game_auto`, 0)
            WHERE `t1`.`city_country_id` IS NOT NULL
            AND `t1`.`city_country_id`!=0
            AND `t2`.`city_country_id` IS NOT NULL
            AND `t2`.`city_country_id`!=0";
    f_igosja_mysqli_query($sql);
}