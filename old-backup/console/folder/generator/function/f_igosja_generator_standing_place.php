<?php

/**
 * Оновлюємо місця в турнірних таблицях
 */
function f_igosja_generator_standing_place()
{
    $sql = "SELECT `schedule_season_id`,
                   `schedule_stage_id`,
                   `schedule_tournamenttype_id`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `schedule_id` ASC";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($schedule_array as $schedule)
    {
        if (TOURNAMENTTYPE_CONFERENCE == $schedule['schedule_tournamenttype_id'])
        {
            $sql = "SELECT `conference_id`
                    FROM `conference`
                    LEFT JOIN `team`
                    ON `conference_team_id`=`team_id`
                    WHERE `conference_season_id`=" . $schedule['schedule_season_id'] . "
                    ORDER BY `conference_point` DESC, `conference_win` DESC, `conference_win_over` DESC, `conference_win_bullet` DESC, `conference_loose_bullet` DESC, `conference_loose_over` DESC, `conference_score`-`conference_pass` DESC, `conference_score` DESC, `team_power_vs` ASC, `team_id` ASC";
            $conference_sql = f_igosja_mysqli_query($sql);

            $conference_array = $conference_sql->fetch_all(MYSQLI_ASSOC);

            for ($i=0; $i<$conference_sql->num_rows; $i++)
            {
                $sql = "UPDATE `conference`
                        SET `conference_place`=" . ( $i + 1 ) . "
                        WHERE `conference_id`=" . $conference_array[$i]['conference_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (TOURNAMENTTYPE_OFFSEASON == $schedule['schedule_tournamenttype_id'])
        {
            $sql = "SELECT `offseason_id`
                    FROM `offseason`
                    LEFT JOIN `team`
                    ON `offseason_team_id`=`team_id`
                    WHERE `offseason_season_id`=" . $schedule['schedule_season_id'] . "
                    ORDER BY `offseason_point` DESC, `offseason_win` DESC, `offseason_win_over` DESC, `offseason_win_bullet` DESC, `offseason_loose_bullet` DESC, `offseason_loose_over` DESC, `offseason_score`-`offseason_pass` DESC, `offseason_score` DESC, `team_power_vs` ASC, `team_id` ASC";
            $offseason_sql = f_igosja_mysqli_query($sql);

            $offseason_array = $offseason_sql->fetch_all(MYSQLI_ASSOC);

            for ($i=0; $i<$offseason_sql->num_rows; $i++)
            {
                $sql = "UPDATE `offseason`
                        SET `offseason_place`=" . ( $i + 1 ) . "
                        WHERE `offseason_id`=" . $offseason_array[$i]['offseason_id'] . "
                        LIMIT 1";
                f_igosja_mysqli_query($sql);
            }
        }
        elseif (TOURNAMENTTYPE_CHAMPIONSHIP == $schedule['schedule_tournamenttype_id'] &&
                $schedule['schedule_stage_id'] >= STAGE_1_TOUR &&
                $schedule['schedule_stage_id'] <= STAGE_30_TOUR)
        {
            $sql = "SELECT `championship_country_id`
                    FROM `championship`
                    WHERE `championship_season_id`=" . $schedule['schedule_season_id'] . "
                    GROUP BY `championship_country_id`
                    ORDER BY `championship_country_id` ASC";
            $country_sql = f_igosja_mysqli_query($sql);

            $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($country_array as $country)
            {
                $sql = "SELECT `championship_division_id`
                        FROM `championship`
                        WHERE `championship_season_id`=" . $schedule['schedule_season_id'] . "
                        AND `championship_country_id`=" . $country['championship_country_id'] . "
                        GROUP BY `championship_division_id`
                        ORDER BY `championship_division_id` ASC";
                $division_sql = f_igosja_mysqli_query($sql);

                $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($division_array as $division)
                {
                    $sql = "SELECT `championship_id`
                            FROM `championship`
                            LEFT JOIN `team`
                            ON `championship_team_id`=`team_id`
                            WHERE `championship_season_id`=" . $schedule['schedule_season_id'] . "
                            AND `championship_country_id`=" . $country['championship_country_id'] . "
                            AND `championship_division_id`=" . $division['championship_division_id'] . "
                            ORDER BY `championship_point` DESC, `championship_win` DESC, `championship_win_over` DESC, `championship_win_bullet` DESC, `championship_loose_bullet` DESC, `championship_loose_over` DESC, `championship_score`-`championship_pass` DESC, `championship_score` DESC, `team_power_vs` ASC, `team_id` ASC";
                    $championship_sql = f_igosja_mysqli_query($sql);

                    $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

                    for ($i=0; $i<$championship_sql->num_rows; $i++)
                    {
                        $sql = "UPDATE `championship`
                                SET `championship_place`=" . ( $i + 1 ) . "
                                WHERE `championship_id`=" . $championship_array[$i]['championship_id'] . "
                                LIMIT 1";
                        f_igosja_mysqli_query($sql);
                    }
                }
            }
        }
        elseif (TOURNAMENTTYPE_LEAGUE == $schedule['schedule_tournamenttype_id'] &&
                $schedule['schedule_stage_id'] >= STAGE_1_TOUR &&
                $schedule['schedule_stage_id'] <= STAGE_6_TOUR)
        {
            $sql = "SELECT `league_group`
                    FROM `league`
                    WHERE `league_season_id`=" . $schedule['schedule_season_id'] . "
                    GROUP BY `league_group`
                    ORDER BY `league_group` ASC";
            $group_sql = f_igosja_mysqli_query($sql);

            $group_array = $group_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($group_array as $group)
            {
                $sql = "SELECT `league_id`
                        FROM `league`
                        LEFT JOIN `team`
                        ON `league_team_id`=`team_id`
                        WHERE `league_season_id`=" . $schedule['schedule_season_id'] . "
                        AND `league_group`=" . $group['league_group'] . "
                        ORDER BY `league_point` DESC, `league_win` DESC, `league_win_over` DESC, `league_win_bullet` DESC, `league_loose_bullet` DESC, `league_loose_over` DESC, `league_score`-`league_pass` DESC, `league_score` DESC, `team_power_vs` ASC, `team_id` ASC";
                $league_sql = f_igosja_mysqli_query($sql);

                $league_array = $league_sql->fetch_all(MYSQLI_ASSOC);

                for ($i=0; $i<$league_sql->num_rows; $i++)
                {
                    $sql = "UPDATE `league`
                            SET `league_place`=" . ( $i + 1 ) . "
                            WHERE `league_id`=" . $league_array[$i]['league_id'] . "
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
        elseif (TOURNAMENTTYPE_NATIONAL == $schedule['schedule_tournamenttype_id'])
        {
            $sql = "SELECT `worldcup_division_id`
                    FROM `worldcup`
                    WHERE `worldcup_season_id`=" . $schedule['schedule_season_id'] . "
                    GROUP BY `worldcup_division_id`
                    ORDER BY `worldcup_division_id` ASC";
            $division_sql = f_igosja_mysqli_query($sql);

            $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($division_array as $division)
            {
                $sql = "SELECT `worldcup_id`
                        FROM `worldcup`
                        WHERE `worldcup_season_id`=" . $schedule['schedule_season_id'] . "
                        AND `worldcup_division_id`=" . $division['worldcup_division_id'] . "
                        ORDER BY `worldcup_point` DESC, `worldcup_win` DESC, `worldcup_win_over` DESC, `worldcup_win_bullet` DESC, `worldcup_loose_bullet` DESC, `worldcup_loose_over` DESC, `worldcup_score`-`worldcup_pass` DESC, `worldcup_score` DESC, `worldcup_national_id` ASC";
                $worldcup_sql = f_igosja_mysqli_query($sql);

                $worldcup_array = $worldcup_sql->fetch_all(MYSQLI_ASSOC);

                for ($i=0; $i<$worldcup_sql->num_rows; $i++)
                {
                    $sql = "UPDATE `worldcup`
                            SET `worldcup_place`=" . ( $i + 1 ) . "
                            WHERE `worldcup_id`=" . $worldcup_array[$i]['worldcup_id'] . "
                            LIMIT 1";
                    f_igosja_mysqli_query($sql);
                }
            }
        }
    }
}