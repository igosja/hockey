<?php

/**
 * Повідомляємо про пенсію хоккеїстів, котрив стало 39
 */
function f_igosja_newseason_pension_inform()
{
    global $igosja_season_id;

    $igosja_season_id++;

    $sql = "SELECT `player_id`,
                   `player_price`,
                   `player_team_id`
            FROM `player`
            WHERE `player_age`=39
            AND `player_team_id`!=0
            ORDER BY `player_id` ASC";
    $player_sql = f_igosja_mysqli_query($sql);

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($player_array as $item)
    {
        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_PENSION_SAY,
            'history_player_id' => $item['player_id'],
            'history_team_id' => $item['player_team_id'],
        );
        f_igosja_history($log);
    }
}