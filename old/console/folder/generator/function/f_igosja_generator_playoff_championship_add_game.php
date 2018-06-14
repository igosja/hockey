<?php

/**
 * Додаємо матчі 3-5 в плей-офф чемпіонатів за необхідності та помічаємо тих, що вилетіли
 */
function f_igosja_generator_playoff_championship_add_game()
{
    global $igosja_season_id;

    $sql = "SELECT `schedule_id`,
                   `schedule_stage_id`,
                   `schedule_tournamenttype_id`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($schedule_array as $item)
    {
        if (TOURNAMENTTYPE_CHAMPIONSHIP == $item['schedule_tournamenttype_id'])
        {
            $schedule_id        = $item['schedule_id'];
            $stage_id           = $item['schedule_stage_id'];
            $tournamenttype_id  = $item['schedule_tournamenttype_id'];

            if (in_array($stage_id, array(STAGE_QUATER, STAGE_SEMI)))
            {
                $sql = "SELECT `game_guest_team_id`,
                               `game_home_team_id`
                        FROM `game`
                        WHERE `game_schedule_id`=$schedule_id
                        ORDER BY `game_id` ASC";
                $game_sql = f_igosja_mysqli_query($sql);

                $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($game_array as $game)
                {
                    $home_team_id   = $game['game_home_team_id'];
                    $guest_team_id  = $game['game_guest_team_id'];

                    $sql = "SELECT `game_guest_score`+`game_guest_score_bullet` AS `guest_score`,
                                   `game_guest_team_id`,
                                   `game_home_score`+`game_home_score_bullet` AS `home_score`,
                                   `game_home_team_id`
                            FROM `game`
                            LEFT JOIN `schedule`
                            ON `game_schedule_id`=`schedule_id`
                            WHERE ((`game_home_team_id`=$home_team_id
                            AND `game_guest_team_id`=$guest_team_id)
                            OR (`game_home_team_id`=$guest_team_id
                            AND `game_guest_team_id`=$home_team_id))
                            AND `game_played`=1
                            AND `schedule_tournamenttype_id`=$tournamenttype_id
                            AND `schedule_stage_id`=$stage_id
                            AND `schedule_season_id`=$igosja_season_id
                            ORDER BY `game_id` ASC";
                    $prev_sql = f_igosja_mysqli_query($sql);

                    if ($prev_sql->num_rows > 1)
                    {
                        $home_win   = 0;
                        $guest_win  = 0;

                        $prev_array = $prev_sql->fetch_all(MYSQLI_ASSOC);

                        foreach ($prev_array as $prev)
                        {
                            if ($prev['home_score'] > $prev['guest_score'])
                            {
                                if ($home_team_id == $prev['game_home_team_id'])
                                {
                                    $home_win++;
                                }
                                else
                                {
                                    $guest_win++;
                                }
                            }
                            else
                            {
                                if ($home_team_id == $prev['game_home_team_id'])
                                {
                                    $guest_win++;
                                }
                                else
                                {
                                    $home_win++;
                                }
                            }
                        }

                        if (in_array(2, array($home_win, $guest_win)))
                        {
                            if (2 == $home_win)
                            {
                                $loose_team_id = $guest_team_id;
                            }
                            else
                            {
                                $loose_team_id = $home_team_id;
                            }

                            $sql = "UPDATE `participantchampionship`
                                    SET `participantchampionship_stage_id`=$stage_id
                                    WHERE `participantchampionship_team_id`=$loose_team_id
                                    AND `participantchampionship_season_id`=$igosja_season_id
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);
                        }
                        else
                        {
                            $sql = "SELECT `schedule_id`
                                    FROM `schedule`
                                    WHERE `schedule_season_id`=$igosja_season_id
                                    AND `schedule_stage_id`=$stage_id
                                    AND `schedule_tournamenttype_id`=$tournamenttype_id
                                    ORDER BY `schedule_id` ASC
                                    LIMIT 2, 1";
                            $stage_sql = f_igosja_mysqli_query($sql);

                            $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                            $schedule_id_insert = $stage_array[0]['schedule_id'];

                            $sql = "SELECT `team_id`,
                                           `team_stadium_id`
                                    FROM `participantchampionship`
                                    LEFT JOIN `championship`
                                    ON
                                    (
                                        `participantchampionship_country_id`=`championship_country_id` AND
                                        `participantchampionship_division_id`=`championship_division_id` AND
                                        `participantchampionship_season_id`=`championship_season_id` AND
                                        `participantchampionship_team_id`=`championship_team_id`
                                    )
                                    LEFT JOIN `team`
                                    ON `participantchampionship_team_id`=`team_id`
                                    WHERE `participantchampionship_team_id` IN ($home_team_id, $guest_team_id)
                                    AND `participantchampionship_season_id`=$igosja_season_id
                                    ORDER BY `championship_place` ASC
                                    LIMIT 2";
                            $team_sql = f_igosja_mysqli_query($sql);

                            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                            $team_1     = $team_array[0]['team_id'];
                            $stadium_id = $team_array[0]['team_stadium_id'];
                            $team_2     = $team_array[1]['team_id'];

                            $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                                    VALUES ($team_2, $team_1, $schedule_id_insert, $stadium_id);";
                            f_igosja_mysqli_query($sql);
                        }
                    }
                }
            }
            elseif (STAGE_FINAL == $stage_id)
            {
                $sql = "SELECT `game_guest_team_id`,
                               `game_home_team_id`
                        FROM `game`
                        WHERE `game_schedule_id`=$schedule_id
                        ORDER BY `game_id`";
                $game_sql = f_igosja_mysqli_query($sql);

                $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($game_array as $game)
                {
                    $home_team_id   = $game['game_home_team_id'];
                    $guest_team_id  = $game['game_guest_team_id'];

                    $sql = "SELECT `game_guest_score`+`game_guest_score_bullet` AS `guest_score`,
                                   `game_guest_team_id`,
                                   `game_home_score`+`game_home_score_bullet` AS `home_score`,
                                   `game_home_team_id`
                            FROM `game`
                            LEFT JOIN `schedule`
                            ON `game_schedule_id`=`schedule_id`
                            WHERE ((`game_home_team_id`=$home_team_id
                            AND `game_guest_team_id`=$guest_team_id)
                            OR (`game_home_team_id`=$guest_team_id
                            AND `game_guest_team_id`=$home_team_id))
                            AND `game_played`=1
                            AND `schedule_tournamenttype_id`=$tournamenttype_id
                            AND `schedule_stage_id`=$stage_id
                            AND `schedule_season_id`=$igosja_season_id
                            ORDER BY `game_id` ASC";
                    $prev_sql = f_igosja_mysqli_query($sql);

                    if ($prev_sql->num_rows > 1)
                    {
                        $home_win   = 0;
                        $guest_win  = 0;

                        $prev_array = $prev_sql->fetch_all(MYSQLI_ASSOC);

                        foreach ($prev_array as $prev)
                        {
                            if ($prev['home_score'] > $prev['guest_score'])
                            {
                                if ($home_team_id == $prev['game_home_team_id'])
                                {
                                    $home_win++;
                                }
                                else
                                {
                                    $guest_win++;
                                }
                            }
                            else
                            {
                                if ($home_team_id == $prev['game_home_team_id'])
                                {
                                    $guest_win++;
                                }
                                else
                                {
                                    $home_win++;
                                }
                            }
                        }

                        if (in_array(3, array($home_win, $guest_win)))
                        {
                            if (3 == $home_win)
                            {
                                $loose_team_id = $guest_team_id;
                            }
                            else
                            {
                                $loose_team_id = $home_team_id;
                            }

                            $sql = "UPDATE `participantchampionship`
                                    SET `participantchampionship_stage_id`=$stage_id
                                    WHERE `participantchampionship_team_id`=$loose_team_id
                                    AND `participantchampionship_season_id`=$igosja_season_id
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);
                        }
                        elseif ((3 == $prev_sql->num_rows && in_array(1, array($home_win, $guest_win))) || 4 == $prev_sql->num_rows)
                        {
                            if (3 == $prev_sql->num_rows && in_array(1, array($home_win, $guest_win)))
                            {
                                $offset = 3;
                            }
                            elseif (4 == $prev_sql->num_rows)
                            {
                                $offset = 4;
                            }

                            $sql = "SELECT `schedule_id`
                                    FROM `schedule`
                                    WHERE `schedule_season_id`=$igosja_season_id
                                    AND `schedule_stage_id`=$stage_id
                                    AND `schedule_tournamenttype_id`=$tournamenttype_id
                                    ORDER BY `schedule_id` ASC
                                    LIMIT $offset, 1";
                            $stage_sql = f_igosja_mysqli_query($sql);

                            $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                            $schedule_id_insert = $stage_array[0]['schedule_id'];

                            $sql = "SELECT `team_id`,
                                           `team_stadium_id`
                                    FROM `participantchampionship`
                                    LEFT JOIN `championship`
                                    ON
                                    (
                                        `participantchampionship_country_id`=`championship_country_id` AND
                                        `participantchampionship_division_id`=`championship_division_id` AND
                                        `participantchampionship_season_id`=`championship_season_id` AND
                                        `participantchampionship_team_id`=`championship_team_id`
                                    )
                                    LEFT JOIN `team`
                                    ON `participantchampionship_team_id`=`team_id`
                                    WHERE `participantchampionship_team_id` IN ($home_team_id, $guest_team_id)
                                    AND `participantchampionship_season_id`=$igosja_season_id
                                    ORDER BY `championship_place` ASC
                                    LIMIT 2";
                            $team_sql = f_igosja_mysqli_query($sql);

                            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                            if (in_array($prev_sql->num_rows, array(2, 3)) && in_array(1, array($home_win, $guest_win)))
                            {
                                $team_1     = $team_array[1]['team_id'];
                                $stadium_id = $team_array[1]['team_stadium_id'];
                                $team_2     = $team_array[0]['team_id'];
                            }
                            elseif (4 == $prev_sql->num_rows)
                            {
                                $team_1     = $team_array[0]['team_id'];
                                $stadium_id = $team_array[0]['team_stadium_id'];
                                $team_2     = $team_array[1]['team_id'];
                            }

                            $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                                    VALUES ($team_2, $team_1, $schedule_id_insert, $stadium_id);";
                            f_igosja_mysqli_query($sql);
                        }
                    }
                }
            }
        }
    }
}