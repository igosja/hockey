<?php

/**
 * Видаляємо неправильні склади команд
 */
function f_igosja_generator_check_lineup()
{
    $sql = "UPDATE `lineup`
            LEFT JOIN `player`
            ON `lineup_player_id`=`player_id`
            SET `lineup_player_id`=0
            WHERE `lineup_game_id` IN
            (
                SELECT `game_id`
                FROM `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE `game_played`=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                ORDER BY `game_id` ASC
            )
            AND ((`lineup_team_id`!=`player_team_id` AND `player_rent_team_id`=0)
            OR (`lineup_team_id`!=`player_rent_team_id` AND `player_rent_team_id`!=0))
            AND `lineup_team_id`!=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `lineup`
            LEFT JOIN `player`
            ON `lineup_player_id`=`player_id`
            SET `lineup_player_id`=0
            WHERE `lineup_game_id` IN
            (
                SELECT `game_id`
                FROM `game`
                LEFT JOIN `schedule`
                ON `game_schedule_id`=`schedule_id`
                WHERE `game_played`=0
                AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                ORDER BY `game_id` ASC
            )
            AND `lineup_national_id`!=`player_national_id`
            AND `lineup_national_id`!=0";
    f_igosja_mysqli_query($sql);
}