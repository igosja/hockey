<?php

/**
 * Змінюємо параметр грав/відпочивав підряд
 */
function f_igosja_generator_player_game_row()
{
    $sql = "UPDATE `player`
            SET `player_game_row_old`=`player_game_row`
            WHERE `player_game_row_old`!=`player_game_row`
            AND `player_age`<40";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `tournamenttype_daytype_id`
            FROM `schedule`
            LEFT JOIN `tournamenttype`
            ON `schedule_tournamenttype_id`=`tournamenttype_id`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    if (DAYTYPE_B == $schedule_array[0]['tournamenttype_daytype_id'])
    {
        $sql = "UPDATE `player`
                LEFT JOIN `lineup`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                LEFT JOIN `tournamenttype`
                ON `schedule_tournamenttype_id`
                SET `player_game_row`=IF(`player_game_row`>0, `player_game_row`+1, 1)
                WHERE `game_played`=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `player`
                SET `player_game_row`=IF(`player_game_row`<0, `player_game_row`-1, -1)
                WHERE `player_id` NOT IN
                (
                    SELECT `lineup_player_id` 
                    FROM `lineup`
                    LEFT JOIN `game`
                    ON `lineup_game_id`=`game_id`
                    LEFT JOIN `schedule`
                    ON `game_schedule_id`=`schedule_id`
                    LEFT JOIN `tournamenttype`
                    ON `schedule_tournamenttype_id`
                    WHERE `game_played`=0
                    AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                )";
        f_igosja_mysqli_query($sql);
    }
    elseif (DAYTYPE_C == $schedule_array[0]['tournamenttype_daytype_id'])
    {
        $sql = "UPDATE `player`
                LEFT JOIN `lineup`
                ON `player_id`=`lineup_player_id`
                LEFT JOIN `game`
                ON `lineup_game_id`=`game_id`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                LEFT JOIN `tournamenttype`
                ON `schedule_tournamenttype_id`
                SET `player_game_row`=IF(`player_game_row`>0, `player_game_row`+1, 1)
                WHERE `game_played`=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
        f_igosja_mysqli_query($sql);
    }
}