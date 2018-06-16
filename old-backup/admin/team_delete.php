<?php

exit;

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "DELETE FROM `team`
            WHERE `team_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "SELECT `player_id`
            FROM `player`
            WHERE `player_team_id`=$num_get
            ORDER BY `player_id` ASC";
    $player_sql = f_igosja_mysqli_query($sql);

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($player_array as $item)
    {
        $player_id = $item['player_id'];

        $sql = "UPDATE `player`
                SET `player_team_id`=0
                WHERE `player_id`=$player_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $log = array(
            'history_historytext_id' => HISTORYTEXT_PLAYER_FREE,
            'history_player_id' => $player_id,
            'history_team_id' => $num_get,
        );
        f_igosja_history($log);
    }
}

redirect('/admin/team_list.php');