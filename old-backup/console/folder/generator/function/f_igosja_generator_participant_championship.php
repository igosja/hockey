<?php

/**
 * Визначаємо команди, які пройдуть до плей-офф національних чемпіонатів
 */
function f_igosja_generator_participant_championship()
{
    global $igosja_season_id;

    $sql = "SELECT `schedule_stage_id`,
                   `schedule_tournamenttype_id`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($schedule_array as $item)
    {
        if (TOURNAMENTTYPE_CHAMPIONSHIP == $item['schedule_tournamenttype_id'] && STAGE_30_TOUR == $item['schedule_stage_id'])
        {
            $sql = "SELECT `championship_country_id`
                    FROM `championship`
                    WHERE `championship_season_id`=$igosja_season_id
                    GROUP BY `championship_country_id`
                    ORDER BY `championship_country_id` ASC";
            $championship_sql = f_igosja_mysqli_query($sql);

            $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($championship_array as $country)
            {
                $country_id = $country['championship_country_id'];

                $sql = "SELECT `championship_division_id`
                        FROM `championship`
                        WHERE `championship_country_id`=$country_id
                        AND `championship_season_id`=$igosja_season_id
                        GROUP BY `championship_division_id`
                        ORDER BY `championship_division_id` ASC";
                $division_sql = f_igosja_mysqli_query($sql);

                $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($division_array as $division)
                {
                    $division_id = $division['championship_division_id'];

                    $sql = "SELECT `championship_team_id`
                            FROM `championship`
                            WHERE `championship_country_id`=$country_id
                            AND `championship_division_id`=$division_id
                            AND `championship_season_id`=$igosja_season_id
                            ORDER BY `championship_place` ASC
                            LIMIT 8";
                    $team_sql = f_igosja_mysqli_query($sql);

                    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                    $team_1 = $team_array[0]['championship_team_id'];
                    $team_2 = $team_array[1]['championship_team_id'];
                    $team_3 = $team_array[2]['championship_team_id'];
                    $team_4 = $team_array[3]['championship_team_id'];
                    $team_5 = $team_array[4]['championship_team_id'];
                    $team_6 = $team_array[5]['championship_team_id'];
                    $team_7 = $team_array[6]['championship_team_id'];
                    $team_8 = $team_array[7]['championship_team_id'];

                    $sql = "INSERT INTO `participantchampionship`
                            (
                                `participantchampionship_country_id`,
                                `participantchampionship_division_id`,
                                `participantchampionship_season_id`,
                                `participantchampionship_stage_1`,
                                `participantchampionship_stage_2`,
                                `participantchampionship_stage_4`,
                                `participantchampionship_team_id`
                            )
                            VALUES ($country_id, $division_id, $igosja_season_id, 1, 1, 1, $team_1),
                                   ($country_id, $division_id, $igosja_season_id, 1, 2, 3, $team_2),
                                   ($country_id, $division_id, $igosja_season_id, 1, 2, 4, $team_3),
                                   ($country_id, $division_id, $igosja_season_id, 1, 1, 2, $team_4),
                                   ($country_id, $division_id, $igosja_season_id, 1, 1, 2, $team_5),
                                   ($country_id, $division_id, $igosja_season_id, 1, 2, 4, $team_6),
                                   ($country_id, $division_id, $igosja_season_id, 1, 2, 3, $team_7),
                                   ($country_id, $division_id, $igosja_season_id, 1, 1, 1, $team_8);";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
    }
}