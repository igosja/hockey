<?php

/**
 * Видаляемо неправильні склади команд
 */
function f_igosja_generator_check_lineup()
{
    $sql = "SELECT `game_id`,
                   `game_guest_team_id`,
                   `game_home_team_id`
            FROM `game`
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);

    foreach ($game_array as $game)
    {
        $game_id = $game['game_id'];

        for ($i=0; $i<2; $i++)
        {
            if (0 == $i)
            {
                $home_guest_team = 'game_guest_team_id';
            }
            else
            {
                $home_guest_team = 'game_home_team_id';
            }

            $team_id = $game[$home_guest_team];

            $sql = "UPDATE `lineup`
                    LEFT JOIN `player`
                    ON `lineup_player_id`=`player_id`
                    SET `lineup_player_id`=0
                    WHERE `lineup_game_id`=$game_id
                    AND `lineup_team_id`=$team_id
                    AND `lineup_team_id`!=`player_team_id`";
            f_igosja_mysqli_query($sql);
        }

        usleep(1);

        print '.';
        flush();
    }
}