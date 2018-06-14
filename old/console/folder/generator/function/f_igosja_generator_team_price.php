<?php

/**
 * Рахуємо вартість команд
 */
function f_igosja_generator_team_price()
{
    $sql = "UPDATE `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN
            (
                SELECT SUM(`player_price`) AS `player_price`,
                       SUM(`player_salary`) AS `player_salary`,
                       `player_team_id`
                FROM `player`
                GROUP BY `player_team_id`
            ) AS `t1`
            ON `player_team_id`=`team_id`
            SET `team_price_base`=(`team_base_id`-1)*500000+(`team_basemedical_id`+`team_basephisical_id`+`team_baseschool_id`+`team_basescout_id`+`team_basetraining_id`-5)*250000,
                `team_price_player`=`player_price`,
                `team_salary`=`player_salary`,
                `team_price_stadium`=POW(`stadium_capacity`, 1.1)*" . STADIUM_ONE_SIT_PICE_BUY . "
            WHERE `team_id`!=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            SET `team_price_total`=`team_price_base`+`team_price_player`+`team_price_stadium`
            WHERE `team_id`!=0";
    f_igosja_mysqli_query($sql);
}