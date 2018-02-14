<?php

/**
 * Визначаємо команди, які пройдуть до плей-офф національних чемпіонатів
 */
function f_igosja_generator_playoff_championship_lot()
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

        if (TOURNAMENTTYPE_CHAMPIONSHIP == $item['schedule_tournamenttype_id'] && STAGE_30_TOUR == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_id`
                    FROM `schedule`
                    WHERE `schedule_season_id`=$igosja_season_id
                    AND `schedule_stage_id`=" . STAGE_QUATER . "
                    AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
                    ORDER BY `schedule_id` ASC
                    LIMIT 2";
            $stage_sql = f_igosja_mysqli_query($sql);

            $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

            $schedule_1 = $stage_array[0]['schedule_id'];
            $schedule_2 = $stage_array[1]['schedule_id'];

            $sql = "SELECT `participantchampionship_country_id`
                    FROM `participantchampionship`
                    WHERE `participantchampionship_season_id`=$igosja_season_id
                    GROUP BY `participantchampionship_country_id`
                    ORDER BY `participantchampionship_country_id` ASC";
            $country_sql = f_igosja_mysqli_query($sql);

            $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($country_array as $country)
            {
                $country_id = $country['participantchampionship_country_id'];

                $sql = "SELECT `participantchampionship_division_id`
                        FROM `participantchampionship`
                        WHERE `participantchampionship_country_id`=$country_id
                        AND `participantchampionship_season_id`=$igosja_season_id
                        GROUP BY `participantchampionship_division_id`
                        ORDER BY `participantchampionship_division_id` ASC";
                $division_sql = f_igosja_mysqli_query($sql);

                $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($division_array as $division)
                {
                    $division_id = $division['participantchampionship_division_id'];

                    for ($i=1; $i<=4; $i++)
                    {
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
                                WHERE `participantchampionship_country_id`=$country_id
                                AND `participantchampionship_division_id`=$division_id
                                AND `participantchampionship_season_id`=$igosja_season_id
                                AND `participantchampionship_stage_4`=$i
                                ORDER BY `championship_place` ASC
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
        elseif (TOURNAMENTTYPE_CHAMPIONSHIP == $item['schedule_tournamenttype_id'] && STAGE_QUATER == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
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
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 2";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];

                $sql = "SELECT `participantchampionship_country_id`
                        FROM `participantchampionship`
                        WHERE `participantchampionship_season_id`=$igosja_season_id
                        GROUP BY `participantchampionship_country_id`
                        ORDER BY `participantchampionship_country_id` ASC";
                $country_sql = f_igosja_mysqli_query($sql);

                $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($country_array as $country)
                {
                    $country_id = $country['participantchampionship_country_id'];

                    $sql = "SELECT `participantchampionship_division_id`
                            FROM `participantchampionship`
                            WHERE `participantchampionship_country_id`=$country_id
                            AND `participantchampionship_season_id`=$igosja_season_id
                            GROUP BY `participantchampionship_division_id`
                            ORDER BY `participantchampionship_division_id` ASC";
                    $division_sql = f_igosja_mysqli_query($sql);

                    $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

                    foreach ($division_array as $division)
                    {
                        $division_id = $division['participantchampionship_division_id'];

                        for ($i=1; $i<=2; $i++)
                        {
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
                                    WHERE `participantchampionship_country_id`=$country_id
                                    AND `participantchampionship_division_id`=$division_id
                                    AND `participantchampionship_season_id`=$igosja_season_id
                                    AND `participantchampionship_stage_2`=$i
                                    AND `participantchampionship_stage_id`=0
                                    ORDER BY `championship_place` ASC
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
        }
        elseif (TOURNAMENTTYPE_CHAMPIONSHIP == $item['schedule_tournamenttype_id'] && STAGE_SEMI == $item['schedule_stage_id'])
        {
            $sql = "SELECT `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
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
                        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
                        ORDER BY `schedule_id` ASC
                        LIMIT 3";
                $stage_sql = f_igosja_mysqli_query($sql);

                $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

                $schedule_1 = $stage_array[0]['schedule_id'];
                $schedule_2 = $stage_array[1]['schedule_id'];
                $schedule_3 = $stage_array[2]['schedule_id'];

                $sql = "SELECT `participantchampionship_country_id`
                        FROM `participantchampionship`
                        WHERE `participantchampionship_season_id`=$igosja_season_id
                        GROUP BY `participantchampionship_country_id`
                        ORDER BY `participantchampionship_country_id` ASC";
                $country_sql = f_igosja_mysqli_query($sql);

                $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($country_array as $country)
                {
                    $country_id = $country['participantchampionship_country_id'];

                    $sql = "SELECT `participantchampionship_division_id`
                            FROM `participantchampionship`
                            WHERE `participantchampionship_country_id`=$country_id
                            AND `participantchampionship_season_id`=$igosja_season_id
                            GROUP BY `participantchampionship_division_id`
                            ORDER BY `participantchampionship_division_id` ASC";
                    $division_sql = f_igosja_mysqli_query($sql);

                    $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

                    foreach ($division_array as $division)
                    {
                        $division_id = $division['participantchampionship_division_id'];

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
                                WHERE `participantchampionship_country_id`=$country_id
                                AND `participantchampionship_division_id`=$division_id
                                AND `participantchampionship_season_id`=$igosja_season_id
                                AND `participantchampionship_stage_1`=1
                                AND `participantchampionship_stage_id`=0
                                ORDER BY `championship_place` ASC
                                LIMIT 2";
                        $team_sql = f_igosja_mysqli_query($sql);

                        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                        $team_1     = $team_array[0]['team_id'];
                        $stadium_1  = $team_array[0]['team_stadium_id'];
                        $team_2     = $team_array[1]['team_id'];
                        $stadium_2  = $team_array[1]['team_stadium_id'];

                        $sql = "INSERT INTO `game` (`game_guest_team_id`, `game_home_team_id`, `game_schedule_id`, `game_stadium_id`)
                                VALUES ($team_2, $team_1, $schedule_1, $stadium_1),
                                       ($team_1, $team_2, $schedule_2, $stadium_2),
                                       ($team_2, $team_1, $schedule_3, $stadium_1);";
                        f_igosja_mysqli_query($sql);
                    }
                }
            }
        }
    }
}