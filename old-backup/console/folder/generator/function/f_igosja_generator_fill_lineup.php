<?php

/**
 * Формуємо автосостави и заповнюємо пропущені місця
 */
function f_igosja_generator_fill_lineup()
{
    $sql = "SELECT `game_id`,
                   `guest_national`.`national_country_id` AS `game_guest_country_id`,
                   `game_guest_mood_id`,
                   `game_guest_national_id`,
                   `game_guest_team_id`,
                   `home_national`.`national_country_id` AS `game_home_country_id`,
                   `game_home_mood_id`,
                   `game_home_national_id`,
                   `game_home_team_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            LEFT JOIN `national` AS `guest_national`
            ON `game_guest_national_id`=`guest_national`.`national_id`
            LEFT JOIN `national` AS `home_national`
            ON `game_home_national_id`=`home_national`.`national_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $game)
    {
        $game_id = $game['game_id'];

        for ($i=0; $i<2; $i++)
        {
            if (0 == $i)
            {
                $home_guest_team        = 'game_guest_team_id';
                $home_guest_national    = 'game_guest_national_id';
                $home_guest_country     = 'game_guest_country_id';
                $home_guest_mood        = 'game_guest_mood_id';
            }
            else
            {
                $home_guest_team        = 'game_home_team_id';
                $home_guest_national    = 'game_home_national_id';
                $home_guest_country     = 'game_home_country_id';
                $home_guest_mood        = 'game_home_mood_id';
            }

            $mood_id        = $game[$home_guest_mood];
            $national_id    = $game[$home_guest_national];
            $country_id     = $game[$home_guest_country];
            $team_id        = $game[$home_guest_team];

            for ($j=0; $j<GAME_LINEUP_QUANTITY; $j++)
            {
                if (0 == $j)
                {
                    $line_id = 0;
                }
                elseif (in_array($j, array(1, 2, 3, 4, 5)))
                {
                    $line_id = 1;
                }
                elseif (in_array($j, array(6, 7, 8, 9, 10)))
                {
                    $line_id = 2;
                }
                else
                {
                    $line_id = 3;
                }

                if (0 == $j)
                {
                    $position_id = POSITION_GK;
                }
                elseif (in_array($j, array(1, 6, 11)))
                {
                    $position_id = POSITION_LD;
                }
                elseif (in_array($j, array(2, 7, 12)))
                {
                    $position_id = POSITION_RD;
                }
                elseif (in_array($j, array(3, 8, 13)))
                {
                    $position_id = POSITION_LW;
                }
                elseif (in_array($j, array(4, 9, 14)))
                {
                    $position_id = POSITION_C;
                }
                else
                {
                    $position_id = POSITION_RW;
                }

                $sql = "SELECT `lineup_id`,
                               `lineup_player_id`
                        FROM `lineup`
                        WHERE `lineup_game_id`=$game_id
                        AND `lineup_line_id`=$line_id
                        AND `lineup_position_id`=$position_id
                        AND `lineup_national_id`=$national_id
                        AND `lineup_team_id`=$team_id
                        LIMIT 1";
                $lineup_sql = f_igosja_mysqli_query($sql);

                if (0 != $lineup_sql->num_rows)
                {
                    $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

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
                    $where_country = '';

                    if ($country_id)
                    {
                        $where_country = 'AND `player_country_id`=' . $country_id;
                    }

                    $league_sql =  "SELECT `player_id`,
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
                                        LEFT JOIN `schedule`
                                        ON `game_schedule_id` = `schedule_id`
                                        WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                                    ) AS `t`
                                    ON `player_id`=`lineup_player_id`
                                    WHERE `player_team_id`=0
                                    AND `player_rent_team_id`=0
                                    AND `player_injury`=0
                                    AND `playerposition_position_id`=$position_id
                                    AND `player_age`<40
                                    AND `lineup_player_id` IS NULL
                                    $where_country
                                    ORDER BY `player_tire` ASC, `player_power_real` DESC
                                    LIMIT 1";

                    if (0 == $mood_id)
                    {
                        if (0 != $team_id)
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
                                        LEFT JOIN `schedule`
                                        ON `game_schedule_id` = `schedule_id`
                                        WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                                    ) AS `t`
                                    ON `player_id`=`lineup_player_id`
                                    WHERE ((`player_team_id`=$team_id
                                    AND `player_rent_team_id`=0)
                                    OR `player_rent_team_id`=$team_id)
                                    AND `playerposition_position_id`=$position_id
                                    AND `player_tire`<60
                                    AND `player_injury`=0
                                    AND `lineup_player_id` IS NULL
                                    ORDER BY `player_tire` ASC, `player_power_real` DESC
                                    LIMIT 1";
                        }
                        else
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
                                        LEFT JOIN `schedule`
                                        ON `game_schedule_id` = `schedule_id`
                                        WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                                    ) AS `t`
                                    ON `player_id`=`lineup_player_id`
                                    WHERE `player_national_id`=$national_id
                                    AND `playerposition_position_id`=$position_id
                                    AND `player_tire`<60
                                    AND `player_injury`=0
                                    AND `lineup_player_id` IS NULL
                                    ORDER BY `player_tire` ASC, `player_power_real` DESC
                                    LIMIT 1";
                        }

                        $player_sql = f_igosja_mysqli_query($sql);

                        if (0 == $player_sql->num_rows)
                        {
                            $player_sql = f_igosja_mysqli_query($league_sql);
                        }
                    }
                    else
                    {
                        $player_sql = f_igosja_mysqli_query($league_sql);
                    }

                    $player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

                    $player_id = $player_array[0]['player_id'];

                    if (0 == $lineup_id)
                    {
                        $sql = "INSERT INTO `lineup`
                                SET `lineup_player_id`=$player_id,
                                    `lineup_line_id`=$line_id,
                                    `lineup_position_id`=$position_id,
                                    `lineup_team_id`=$team_id,
                                    `lineup_national_id`=$national_id,
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