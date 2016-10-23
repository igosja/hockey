<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if (0 != $num_get)
{
    $sql = "DELETE FROM `team`
            WHERE `team_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    $sql = "SELECT `player_id`
            FROM `player`
            WHERE `player_team_id`='$num_get'
            ORDER BY `player_id` ASC";
    $player_sql = igosja_db_query($sql);

    $player_array = $player_sql->fetch_all(1);

    foreach ($player_array as $item)
    {
        $player_id = $item['player_id'];

        $sql = "UPDATE `player`
                SET `player_team_id`='0'
                WHERE `player_id`='$player_id'
                LIMIT 1";
        igosja_db_query($sql);

        $log = array(
            'log_logtext_id' => LOGTEXT_PLAYER_FREE,
            'log_player_id' => $player_id,
            'log_team_id' => $num_get,
        );
        f_igosja_log($log);
    }
}

redirect('/admin/team_list.php');