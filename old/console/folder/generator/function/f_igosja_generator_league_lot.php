<?php

/**
 * Створємо матчі наступного раунду лч
 */
function f_igosja_generator_league_lot()
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
        $schedule_id = $item['schedule_id'];

        if (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_1_QUALIFY == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_2_QUALIFY == $check_array[0]['schedule_stage_id'])
            {
                $team_array = f_igosja_league_lot(STAGE_2_QUALIFY);

                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`=" . STAGE_2_QUALIFY . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                $values = array();

                foreach ($team_array as $item)
                {
                    $values[] = '(' . $item['guest'] . ', ' . $item['home'] . ', ' . $schedule_1 . ')';
                    $values[] = '(' . $item['home'] . ', ' . $item['guest'] . ', ' . $schedule_2 . ')';
                }

                $values = implode(',', $values);

                $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`)
                        VALUES $values;";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `game`
                        LEFT JOIN `team`
                        ON `game_home_team_id`=`team_id`
                        SET `game_stadium_id`=`team_stadium_id`
                        WHERE `game_schedule_id` IN ($schedule_1, $schedule_2)";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_2_QUALIFY == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_3_QUALIFY == $check_array[0]['schedule_stage_id'])
            {
                $team_array = f_igosja_league_lot(STAGE_3_QUALIFY);

                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`=" . STAGE_3_QUALIFY . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                $values = array();

                foreach ($team_array as $item)
                {
                    $values[] = '(' . $item['guest'] . ', ' . $item['home'] . ', ' . $schedule_1 . ')';
                    $values[] = '(' . $item['home'] . ', ' . $item['guest'] . ', ' . $schedule_2 . ')';
                }

                $values = implode(',', $values);

                $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`)
                        VALUES $values;";
                f_igosja_mysqli_query($sql);

                $sql = "UPDATE `game`
                        LEFT JOIN `team`
                        ON `game_home_team_id`=`team_id`
                        SET `game_stadium_id`=`team_stadium_id`
                        WHERE `game_schedule_id` IN ($schedule_1, $schedule_2)";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_3_QUALIFY == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_1_TOUR == $check_array[0]['schedule_stage_id'])
            {
                $team_array = f_igosja_league_lot(STAGE_1_TOUR);

                $values = array();

                foreach ($team_array as $group => $team)
                {
                    foreach ($team as $place => $item)
                    {
                        $values[] = '(' . $igosja_season_id . ', ' . $item . ', ' . $group . ', ' . ( $place + 1 ) . ')';
                    }
                }

                $values = implode(',', $values);

                $sql = "INSERT INTO `league` (`league_season_id`, `league_team_id`, `league_group`, `league_place`)
                        VALUES $values;";
                f_igosja_mysqli_query($sql);

                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`<=" . STAGE_6_TOUR . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 6";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_id_1 = $stage_array[0]['schedule_id'];
                $schedule_id_2 = $stage_array[1]['schedule_id'];
                $schedule_id_3 = $stage_array[2]['schedule_id'];
                $schedule_id_4 = $stage_array[3]['schedule_id'];
                $schedule_id_5 = $stage_array[4]['schedule_id'];
                $schedule_id_6 = $stage_array[5]['schedule_id'];

                $sql = "SELECT `league_group`
                        FROM `league`
                        WHERE `league_season_id`=$igosja_season_id
                        GROUP BY `league_group`
                        ORDER BY `league_group` ASC";
                $group_sql = f_igosja_mysqli_query($sql);

                $group_array = $group_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($group_array as $group)
                {
                    $group_id = $group['league_group'];

                    $sql = "SELECT `team_id`,
                                   `stadium_id`
                            FROM `league`
                            LEFT JOIN `team`
                            ON `league_team_id`=`team_id`
                            LEFT JOIN `stadium`
                            ON `team_stadium_id`=`stadium_id`
                            WHERE `league_season_id`=$igosja_season_id
                            AND `league_group`=$group_id
                            ORDER BY RAND()";
                    $team_sql = f_igosja_mysqli_query($sql);

                    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                    $team_id_1 = $team_array[0]['team_id'];
                    $team_id_2 = $team_array[1]['team_id'];
                    $team_id_3 = $team_array[2]['team_id'];
                    $team_id_4 = $team_array[3]['team_id'];

                    $stadium_id_1 = $team_array[0]['stadium_id'];
                    $stadium_id_2 = $team_array[1]['stadium_id'];
                    $stadium_id_3 = $team_array[2]['stadium_id'];
                    $stadium_id_4 = $team_array[3]['stadium_id'];

                    $sql = "INSERT INTO `game` (`game_home_team_id`, `game_guest_team_id`, `game_schedule_id`, `game_stadium_id`)
                            VALUES ($team_id_2, $team_id_1, $schedule_id_1, $stadium_id_2),
                                   ($team_id_4, $team_id_3, $schedule_id_1, $stadium_id_4),
                                   ($team_id_1, $team_id_3, $schedule_id_2, $stadium_id_1),
                                   ($team_id_2, $team_id_4, $schedule_id_2, $stadium_id_2),
                                   ($team_id_3, $team_id_2, $schedule_id_3, $stadium_id_3),
                                   ($team_id_4, $team_id_1, $schedule_id_3, $stadium_id_4),
                                   ($team_id_1, $team_id_2, $schedule_id_4, $stadium_id_1),
                                   ($team_id_3, $team_id_4, $schedule_id_4, $stadium_id_3),
                                   ($team_id_3, $team_id_1, $schedule_id_5, $stadium_id_3),
                                   ($team_id_4, $team_id_2, $schedule_id_5, $stadium_id_4),
                                   ($team_id_2, $team_id_3, $schedule_id_6, $stadium_id_2),
                                   ($team_id_1, $team_id_4, $schedule_id_6, $stadium_id_1);";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_6_TOUR == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_id`
                    FROM `schedule`
                    WHERE `schedule_season_id`=$igosja_season_id
                    AND `schedule_stage_id`=" . STAGE_1_8_FINAL . "
                    AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    ORDER BY `schedule_id` ASC
                    LIMIT 2";
            $stage_sql = f_igosja_mysqli_query($sql);

            $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

            $schedule_1 = $stage_array[0]['schedule_id'];
            $schedule_2 = $stage_array[1]['schedule_id'];

            for ($i=1; $i<=8; $i++)
            {
                $sql = "SELECT `team_id`,
                               `team_stadium_id`
                        FROM `participantleague`
                        LEFT JOIN `team`
                        ON `participantleague_team_id`=`team_id`
                        WHERE `participantleague_season_id`=$igosja_season_id
                        AND `participantleague_stage_8`=$i
                        AND `participantleague_stage_id`=0
                        ORDER BY `participantleague_id` ASC
                        LIMIT 2";
                $team_sql = f_igosja_mysqli_query($sql);

                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                $team_1     = $team_array[0]['team_id'];
                $stadium_1  = $team_array[0]['team_stadium_id'];
                $team_2     = $team_array[1]['team_id'];
                $stadium_2  = $team_array[1]['team_stadium_id'];

                $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                        VALUES ($team_2, $team_1, $schedule_1, $stadium_1),
                               ($team_1, $team_2, $schedule_2, $stadium_2);";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_1_8_FINAL == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_QUATER == $check_array[0]['schedule_stage_id'])
            {
                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`=" . STAGE_QUATER . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                for ($i=1; $i<=4; $i++)
                {
                    $sql = "SELECT `team_id`,
                                   `team_stadium_id`
                            FROM `participantleague`
                            LEFT JOIN `team`
                            ON `participantleague_team_id`=`team_id`
                            WHERE `participantleague_season_id`=$igosja_season_id
                            AND `participantleague_stage_4`=$i
                            AND `participantleague_stage_id`=0
                            ORDER BY `participantleague_id` ASC
                            LIMIT 2";
                    $team_sql = f_igosja_mysqli_query($sql);

                    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                    $team_1     = $team_array[0]['team_id'];
                    $stadium_1  = $team_array[0]['team_stadium_id'];
                    $team_2     = $team_array[1]['team_id'];
                    $stadium_2  = $team_array[1]['team_stadium_id'];

                    $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                            VALUES ($team_2, $team_1, $schedule_1, $stadium_1),
                                   ($team_1, $team_2, $schedule_2, $stadium_2);";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_QUATER == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_SEMI == $check_array[0]['schedule_stage_id'])
            {
                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`=" . STAGE_SEMI . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                for ($i=1; $i<=2; $i++)
                {
                    $sql = "SELECT `team_id`,
                                   `team_stadium_id`
                            FROM `participantleague`
                            LEFT JOIN `team`
                            ON `participantleague_team_id`=`team_id`
                            WHERE `participantleague_season_id`=$igosja_season_id
                            AND `participantleague_stage_2`=$i
                            AND `participantleague_stage_id`=0
                            ORDER BY `participantleague_id` ASC
                            LIMIT 2";
                    $team_sql = f_igosja_mysqli_query($sql);

                    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                    $team_1     = $team_array[0]['team_id'];
                    $stadium_1  = $team_array[0]['team_stadium_id'];
                    $team_2     = $team_array[1]['team_id'];
                    $stadium_2  = $team_array[1]['team_stadium_id'];

                    $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                            VALUES ($team_2, $team_1, $schedule_1, $stadium_1),
                                   ($team_1, $team_2, $schedule_2, $stadium_2);";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $item['schedule_tournamenttype_id'] && STAGE_SEMI == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_id`>$schedule_id
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (STAGE_FINAL == $check_array[0]['schedule_stage_id'])
            {
                $sql = "SELECT `schedule_id`
                        FROM `schedule`
                        WHERE `schedule_season_id`=$igosja_season_id
                        AND `schedule_stage_id`=" . STAGE_FINAL . "
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                $sql = "SELECT `team_id`,
                               `team_stadium_id`
                        FROM `participantleague`
                        LEFT JOIN `team`
                        ON `participantleague_team_id`=`team_id`
                        WHERE `participantleague_season_id`=$igosja_season_id
                        AND `participantleague_stage_1`=1
                        AND `participantleague_stage_id`=0
                        ORDER BY `participantleague_id` ASC
                        LIMIT 2";
                $team_sql = f_igosja_mysqli_query($sql);

                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                $team_1     = $team_array[0]['team_id'];
                $stadium_1  = $team_array[0]['team_stadium_id'];
                $team_2     = $team_array[1]['team_id'];
                $stadium_2  = $team_array[1]['team_stadium_id'];

                $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                        VALUES ($team_2, $team_1, $schedule_1, $stadium_1),
                               ($team_1, $team_2, $schedule_2, $stadium_2);";
                f_igosja_mysqli_query($sql);
            }
        }
    }
}