<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `game_id`,
               `game_guest_plus_minus`,
               `game_guest_national_id`,
               `game_guest_team_id`,
               `game_home_plus_minus`,
               `game_home_national_id`,
               `game_home_team_id`
        FROM `game`
        WHERE `game_schedule_id`=127
        ORDER BY `game_id` ASC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

foreach ($game_array as $item)
{
    $sql = "SELECT `lineup_power_change`,
                   `lineup_player_id`
            FROM `lineup`
            WHERE `lineup_game_id`=" . $item['game_id'];
    $player_sql = f_igosja_mysqli_query($sql);

    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($player_array as $player)
    {
        $sql = "UPDATE `player`
                SET `player_power_nominal`=`player_power_nominal`+" . $player['lineup_power_change'] . "
                WHERE `player_id`=" . $player['lineup_player_id'] . "
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }

    $sql = "UPDATE `lineup`
            SET `lineup_power_change`=0
            WHERE `lineup_power_change`!=0
            AND `lineup_game_id`=" . $item['game_id'];
    f_igosja_mysqli_query($sql);

    if ($item['game_home_plus_minus'] < 0)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`=" . $item['game_home_team_id'] . "
                AND `lineup_national_id`=" . $item['game_home_national_id'] . "
                AND `lineup_game_id`=" . $item['game_id'] . "
                ORDER BY RAND()
                LIMIT " . -$item['game_home_plus_minus'];
        $player_sql = f_igosja_mysqli_query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($player_array as $player)
        {
            $sql = "UPDATE `player`
                    SET `player_power_nominal`=`player_power_nominal`-1
                    WHERE `player_id`=" . $player['lineup_player_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_power_change`=-1
                    WHERE `lineup_id`=" . $player['lineup_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_game_id' => $item['game_id'],
                'history_historytext_id' => HISTORYTEXT_PLAYER_GAME_POINT_MINUS,
                'history_player_id' => $player['lineup_player_id'],
            );
            f_igosja_history($log);
        }
    }
    elseif ($item['game_home_plus_minus'] > 0)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`=" . $item['game_home_team_id'] . "
                AND `lineup_national_id`=" . $item['game_home_national_id'] . "
                AND `lineup_game_id`=" . $item['game_id'] . "
                ORDER BY RAND()
                LIMIT " . $item['game_home_plus_minus'];
        $player_sql = f_igosja_mysqli_query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($player_array as $player)
        {
            $sql = "UPDATE `player`
                    SET `player_power_nominal`=`player_power_nominal`+1
                    WHERE `player_id`=" . $player['lineup_player_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_power_change`=1
                    WHERE `lineup_id`=" . $player['lineup_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_game_id' => $item['game_id'],
                'history_historytext_id' => HISTORYTEXT_PLAYER_GAME_POINT_PLUS,
                'history_player_id' => $player['lineup_player_id'],
            );
            f_igosja_history($log);
        }
    }

    if ($item['game_guest_plus_minus'] < 0)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`=" . $item['game_guest_team_id'] . "
                AND `lineup_national_id`=" . $item['game_guest_national_id'] . "
                AND `lineup_game_id`=" . $item['game_id'] . "
                ORDER BY RAND()
                LIMIT " . -$item['game_guest_plus_minus'];
        $player_sql = f_igosja_mysqli_query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($player_array as $player)
        {
            $sql = "UPDATE `player`
                    SET `player_power_nominal`=`player_power_nominal`-1
                    WHERE `player_id`=" . $player['lineup_player_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_power_change`=-1
                    WHERE `lineup_id`=" . $player['lineup_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_game_id' => $item['game_id'],
                'history_historytext_id' => HISTORYTEXT_PLAYER_GAME_POINT_MINUS,
                'history_player_id' => $player['lineup_player_id'],
            );
            f_igosja_history($log);
        }
    }
    elseif ($item['game_guest_plus_minus'] > 0)
    {
        $sql = "SELECT `lineup_id`,
                       `lineup_player_id`
                FROM `lineup`
                WHERE `lineup_team_id`=" . $item['game_guest_team_id'] . "
                AND`lineup_national_id`=" . $item['game_guest_national_id'] . "
                AND `lineup_game_id`=" . $item['game_id'] . "
                ORDER BY RAND()
                LIMIT " . $item['game_guest_plus_minus'];
        $player_sql = f_igosja_mysqli_query($sql);

        $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($player_array as $player)
        {
            $sql = "UPDATE `player`
                    SET `player_power_nominal`=`player_power_nominal`+1
                    WHERE `player_id`=" . $player['lineup_player_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `lineup`
                    SET `lineup_power_change`=1
                    WHERE `lineup_id`=" . $player['lineup_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $log = array(
                'history_game_id' => $item['game_id'],
                'history_historytext_id' => HISTORYTEXT_PLAYER_GAME_POINT_PLUS,
                'history_player_id' => $player['lineup_player_id'],
            );
            f_igosja_history($log);
        }
    }
}