<?php

/**
 * Рахуємо середній вік хокеїстів в командах
 */
function f_igosja_generator_team_age()
{
    $sql = "UPDATE `team`
            LEFT JOIN
            (
                SELECT AVG(`player_age`) AS `player_age`, `player_team_id`
                FROM `player`
                WHERE `player_team_id`!=0
                GROUP BY `player_team_id`
            ) AS `t1`
            ON `player_team_id`=`team_id`
            SET `team_age`=`player_age`
            WHERE `team_id`!=0";
    f_igosja_mysqli_query($sql);
}