<?php

/**
 * Играл подряд/отдыхал подряд
 */
function f_igosja_generator_player_game_row()
{
    $sql = "UPDATE `player`
            LEFT JOIN `lineup`
            ON `player_id`=`lineup_player_id`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            SET `player_game_row`=IF(`player_game_row`>0, `player_game_row`+1, 1)
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `player`
            SET `player_game_row`=IF(`player_game_row`<0, `player_game_row`-1, -1)
            WHERE `player_id` NOT IN
            (
                SELECT `lineup_player_id` 
                FROM `lineup`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `shedule`
                ON `game_shedule_id`=`shedule_id`
                WHERE `game_played`=0
                AND FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            )";
    f_igosja_mysqli_query($sql);

    print '.';
    flush();
}