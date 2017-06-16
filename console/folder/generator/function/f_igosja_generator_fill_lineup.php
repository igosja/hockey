<?php

/**
 * Формуємо автосостави и заповнюємо пропущені місця
 */
function f_igosja_generator_fill_lineup()
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

            for ($j=0; $j<GAME_LINEUP_QUANTITY; $j++)
            {
                if (0 == $j)
                {
                    $line_id        = 0;
                    $position_id    = POSITION_GK;
                }
                elseif (1 == $j)
                {
                    $line_id        = 1;
                    $position_id    = POSITION_LD;
                }
                elseif (2 == $j)
                {
                    $line_id        = 1;
                    $position_id    = POSITION_RD;
                }
                elseif (3 == $j)
                {
                    $line_id        = 1;
                    $position_id    = POSITION_LW;
                }
                elseif (4 == $j)
                {
                    $line_id        = 1;
                    $position_id    = POSITION_C;
                }
                elseif (5 == $j)
                {
                    $line_id        = 1;
                    $position_id    = POSITION_RW;
                }
                elseif (6 == $j)
                {
                    $line_id        = 2;
                    $position_id    = POSITION_LD;
                }
                elseif (7 == $j)
                {
                    $line_id        = 2;
                    $position_id    = POSITION_RD;
                }
                elseif (8 == $j)
                {
                    $line_id        = 2;
                    $position_id    = POSITION_LW;
                }
                elseif (9 == $j)
                {
                    $line_id        = 2;
                    $position_id    = POSITION_C;
                }
                elseif (10 == $j)
                {
                    $line_id        = 2;
                    $position_id    = POSITION_RW;
                }
                elseif (11 == $j)
                {
                    $line_id        = 3;
                    $position_id    = POSITION_LD;
                }
                elseif (12 == $j)
                {
                    $line_id        = 3;
                    $position_id    = POSITION_RD;
                }
                elseif (13 == $j)
                {
                    $line_id        = 3;
                    $position_id    = POSITION_LW;
                }
                elseif (14 == $j)
                {
                    $line_id        = 3;
                    $position_id    = POSITION_C;
                }
                else
                {
                    $line_id        = 3;
                    $position_id    = POSITION_RW;
                }

                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_game_id`=$game_id
                        AND `lineup_line_id`=$line_id
                        AND `lineup_position_id`=$position_id
                        AND `lineup_team_id`=$team_id
                        LIMIT 1";
                $lineup_sql = f_igosja_mysqli_query($sql);

                if (0 != $lineup_sql->num_rows)
                {
                    $lineup_array = $lineup_sql->fetch_all(1);

                    $lineup_id          = $lineup_array[0]['lineup_id'];
                    $lineup_player_id   = $lineup_array[0]['lineup_player_id'];
                }
                else
                {
                    $lineup_id          = 0;
                    $lineup_player_id   = 0;
                }

                if (0 == $lineup_player_id)
                {
                    $sql = "SELECT `player_id`,
                                   `lineup_player_id`
                            FROM `player`
                            LEFT JOIN `playerposition`
                            ON `playerposition_player_id`=`player_id`
                            LEFT JOIN
                            (
                                SELECT `lineup_player_id`
                                FROM `lineup`
                                LEFT JOIN `game`
                                ON `lineup_game_id` = `game_id`
                                LEFT JOIN `shedule`
                                ON `game_shedule_id` = `shedule_id`
                                WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
                            ) AS `t`
                            ON `player_id`=`lineup_player_id`
                            WHERE `player_team_id`=$team_id
                            AND `playerposition_position_id`=$position_id
                            AND `lineup_player_id` IS NULL
                            ORDER BY `player_tire` ASC, `player_power_real` DESC
                            LIMIT 1";
                    $player_sql = f_igosja_mysqli_query($sql);

                    if (0 == $player_sql->num_rows)
                    {
                        $sql = "SELECT `player_id`,
                                       `lineup_player_id`
                                FROM `player`
                                LEFT JOIN `playerposition`
                                ON `playerposition_player_id`=`player_id`
                                LEFT JOIN
                                (
                                    SELECT `lineup_player_id`
                                    FROM `lineup`
                                    LEFT JOIN `game`
                                    ON `lineup_game_id` = `game_id`
                                    LEFT JOIN `shedule`
                                    ON `game_shedule_id` = `shedule_id`
                                    WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
                                ) AS `t`
                                ON `player_id`=`lineup_player_id`
                                WHERE `player_team_id`=0
                                AND `playerposition_position_id`=$position_id
                                AND `lineup_player_id` IS NULL
                                ORDER BY `player_tire` ASC, `player_power_real` DESC
                                LIMIT 1";
                        $player_sql = f_igosja_mysqli_query($sql);
                    }

                    $player_array = $player_sql->fetch_all(1);

                    $player_id = $player_array[0]['player_id'];

                    if (0 == $lineup_id)
                    {
                        $sql = "INSERT INTO `lineup`
                                SET `lineup_player_id`=$player_id,
                                    `lineup_line_id`=$line_id,
                                    `lineup_position_id`=$position_id,
                                    `lineup_team_id`=$team_id,
                                    `lineup_game_id`=$game_id";
                        f_igosja_mysqli_query($sql);
                    }
                    else
                    {
                        $sql = "UPDATE `lineup`
                                SET `lineup_player_id`=$player_id
                                WHERE `lineup_id`=$lineup_id
                                LIMIT 1";
                        f_igosja_mysqli_query($sql);
                    }
                }
            }
        }
    }
}