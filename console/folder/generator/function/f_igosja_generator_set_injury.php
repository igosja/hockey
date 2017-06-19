<?php

/**
 * Роздача травм хокеїстам
 */
function f_igosja_generator_set_injury()
{
    $sql = "SELECT `lineup_player_id`
            FROM `lineup`
            LEFT JOIN `game`
            ON `lineup_game_id`=`game_id`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            LEFT JOIN `player`
            ON `lineup_player_id`=`player_id`
            WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            AND `player_injury`=0
            AND `player_team_id` NOT IN 
            (
                SELECT `player_team_id`
                FROM `player`
                WHERE `player_injury`=0
            )
            ORDER BY `player_tire` DESC, RAND()
            LIMIT 1";
    $player_sql = f_igosja_mysqli_query($sql);

    if ($player_sql->num_rows)
    {
        $player_array = $player_sql->fetch_all(1);

        $player_id  = $player_array[0]['lineup_player_id'];
        $day        = rand(1, 9);

        $sql = "UPDATE `player`
                SET `player_injury`=1,
                    `player_injury_day`=$day
                WHERE `player_id`=$player_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_INJURY,
            'history_player_id' => $player_id,
            'history_value' => $day,
        );
        f_igosja_history($log);
    }
}