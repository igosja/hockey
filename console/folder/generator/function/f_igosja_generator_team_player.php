<?php

/**
 * Рахуємо кількість хокеїстів в командах
 */
function f_igosja_generator_team_player()
{
    $sql = "UPDATE `team`
            LEFT JOIN
            (
                SELECT COUNT(`player_id`) AS `count_player`, `player_team_id`
                FROM `player`
                WHERE `player_team_id`!=0
                GROUP BY `player_team_id`
            ) AS `t1`
            ON `player_team_id`=`team_id`
            SET `team_player`=`count_player`
            WHERE `team_id`!=0";
    f_igosja_mysqli_query($sql);
}