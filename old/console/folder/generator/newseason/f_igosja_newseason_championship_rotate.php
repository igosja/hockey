<?php

/**
 * Змінюємо дивізіони кращим і гіршим командам в чемпіонатах
 */
function f_igosja_newseason_championship_rotate()
{
    global $igosja_season_id;

    $sql = "SELECT `division_id`
            FROM `division`
            ORDER BY `division_id` ASC";
    $division_sql = f_igosja_mysqli_query($sql);

    $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `country_id`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            WHERE `team_id`!=0
            GROUP BY `country_id`
            ORDER BY `country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($country_array as $country)
    {
        $country_id     = $country['country_id'];
        $rotate_array   = array();

        foreach ($division_array as $division)
        {
            $division_id = $division['division_id'];

            $rotate_championship = array();

            if (1 == $division_id)
            {
                $sql = "SELECT `championship_team_id`
                        FROM `championship`
                        WHERE `championship_division_id`=$division_id
                        AND `championship_country_id`=$country_id
                        AND `championship_season_id`=$igosja_season_id
                        ORDER BY `championship_place` ASC
                        LIMIT 14";
                $championship_sql = f_igosja_mysqli_query($sql);

                $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($championship_array as $team)
                {
                    $rotate_championship[] = $team['championship_team_id'];
                }

                $sql = "SELECT `participantchampionship_team_id`
                        FROM `participantchampionship`
                        WHERE `participantchampionship_country_id`=$country_id
                        AND `participantchampionship_division_id`=$division_id+1
                        AND `participantchampionship_season_id`=$igosja_season_id
                        AND `participantchampionship_stage_id` IN (0, " . STAGE_FINAL . ")";
                $championship_sql = f_igosja_mysqli_query($sql);

                $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($championship_array as $team)
                {
                    $rotate_championship[] = $team['participantchampionship_team_id'];
                }
            }
            else
            {
                $sql = "SELECT `championship_team_id`
                        FROM `championship`
                        WHERE `championship_division_id`=$division_id
                        AND `championship_country_id`=$country_id
                        AND `championship_season_id`=$igosja_season_id
                        AND `championship_team_id` NOT IN
                        (
                            SELECT `participantchampionship_team_id`
                            FROM `participantchampionship`
                            WHERE `participantchampionship_country_id`=$country_id
                            AND `participantchampionship_division_id`=$division_id
                            AND `participantchampionship_season_id`=$igosja_season_id
                            AND `participantchampionship_stage_id` IN (0, " . STAGE_FINAL . ")
                        )
                        ORDER BY `championship_place` ASC
                        LIMIT 12";
                $championship_sql = f_igosja_mysqli_query($sql);

                if (0 != $championship_sql->num_rows)
                {
                    $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

                    foreach ($championship_array as $team)
                    {
                        $rotate_championship[] = $team['championship_team_id'];
                    }

                    $sql = "SELECT `championship_team_id`
                            FROM `championship`
                            WHERE `championship_division_id`=$division_id-1
                            AND `championship_country_id`=$country_id
                            AND `championship_season_id`=$igosja_season_id
                            ORDER BY `championship_place` ASC
                            LIMIT 14, 2";
                    $championship_sql = f_igosja_mysqli_query($sql);

                    $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

                    foreach ($championship_array as $team)
                    {
                        $rotate_championship[] = $team['championship_team_id'];
                    }

                    $sql = "SELECT `participantchampionship_team_id`
                            FROM `participantchampionship`
                            WHERE `participantchampionship_country_id`=$country_id
                            AND `participantchampionship_division_id`=$division_id+1
                            AND `participantchampionship_season_id`=$igosja_season_id
                            AND `participantchampionship_stage_id` IN (0, " . STAGE_FINAL . ")";
                    $championship_sql = f_igosja_mysqli_query($sql);

                    if (0 != $championship_sql->num_rows)
                    {
                        $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

                        foreach ($championship_array as $team)
                        {
                            $rotate_championship[] = $team['participantchampionship_team_id'];
                        }
                    }
                    else
                    {
                        $sql = "SELECT `conference_team_id`
                                FROM `conference`
                                LEFT JOIN `team`
                                ON `conference_team_id`=`team_id`
                                LEFT JOIN `stadium`
                                ON `team_stadium_id`=`stadium_id`
                                LEFT JOIN `city`
                                ON `stadium_city_id`=`city_id`
                                WHERE `conference_season_id`=$igosja_season_id
                                AND `city_country_id`=$country_id
                                ORDER BY `conference_place` ASC
                                LIMIT 2";
                        $conference_sql = f_igosja_mysqli_query($sql);

                        if (0 != $conference_sql->num_rows)
                        {
                            $conference_array = $conference_sql->fetch_all(MYSQLI_ASSOC);

                            foreach ($conference_array as $team)
                            {
                                $rotate_championship[] = $team['conference_team_id'];
                            }
                        }
                        else
                        {
                            $sql = "SELECT `championship_team_id`
                                    FROM `championship`
                                    WHERE `championship_division_id`=$division_id
                                    AND `championship_country_id`=$country_id
                                    AND `championship_season_id`=$igosja_season_id
                                    ORDER BY `championship_place` ASC
                                    LIMIT 14, 2";
                            $championship_sql = f_igosja_mysqli_query($sql);

                            $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

                            foreach ($championship_array as $team)
                            {
                                $rotate_championship[] = $team['championship_team_id'];
                            }
                        }
                    }
                }
            }

            if ($rotate_championship)
            {
                $rotate_array[$division_id] = $rotate_championship;
            }
        }

        $rotate_conference = array();

        if ($rotate_array)
        {
            $sql = "SELECT `championship_division_id`
                    FROM `championship`
                    WHERE `championship_season_id`=$igosja_season_id
                    AND `championship_country_id`=$country_id
                    ORDER BY `championship_division_id` DESC
                    LIMIT 1";
            $division_last_sql = f_igosja_mysqli_query($sql);

            $division_last_array = $division_last_sql->fetch_all(MYSQLI_ASSOC);

            $division_id = $division_last_array[0]['championship_division_id'];

            $sql = "SELECT `championship_team_id`
                    FROM `championship`
                    WHERE `championship_season_id`=$igosja_season_id
                    AND `championship_country_id`=$country_id
                    AND `championship_division_id`=$division_id
                    ORDER BY `championship_place` DESC
                    LIMIT 2";
            $championship_sql = f_igosja_mysqli_query($sql);

            $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($championship_array as $team)
            {
                $rotate_conference[] = $team['championship_team_id'];
            }

            $sql = "SELECT `conference_team_id`
                    FROM `conference`
                    LEFT JOIN `team`
                    ON `conference_team_id`=`team_id`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    WHERE `conference_season_id`=$igosja_season_id
                    AND `city_country_id`=$country_id
                    ORDER BY `conference_place` ASC
                    LIMIT 2,999";
            $conference_sql = f_igosja_mysqli_query($sql);

            $conference_array = $conference_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($conference_array as $team)
            {
                $rotate_conference[] = $team['conference_team_id'];
            }
        }
        else
        {
            $sql = "SELECT `conference_team_id`
                    FROM `conference`
                    LEFT JOIN `team`
                    ON `conference_team_id`=`team_id`
                    LEFT JOIN `stadium`
                    ON `team_stadium_id`=`stadium_id`
                    LEFT JOIN `city`
                    ON `stadium_city_id`=`city_id`
                    WHERE `conference_season_id`=$igosja_season_id
                    AND `city_country_id`=$country_id
                    ORDER BY `conference_place` ASC";
            $conference_sql = f_igosja_mysqli_query($sql);

            $conference_array = $conference_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($conference_array as $team)
            {
                $rotate_conference[] = $team['conference_team_id'];
            }
        }

        $rotate_array['conference'] = $rotate_conference;

        if (count($rotate_array) < 5 && count($rotate_array['conference']) >= 16)
        {
            foreach ($division_array as $item)
            {
                if (!isset($rotate_array[$item['division_id']]) && count($rotate_array['conference']) >= 16)
                {
                    $rotate_array[$item['division_id']] = array_slice($rotate_array['conference'], 0, 16);
                    $rotate_array['conference'] = array_splice($rotate_array['conference'], 0, 16);
                }
            }
        }

        foreach ($division_array as $division)
        {
            if (isset($rotate_array[$division['division_id']]))
            {
                $values = array();

                foreach ($rotate_array[$division['division_id']] as $item)
                {
                    $values[] = '(' . $country_id . ',' . $division['division_id'] . ',' . ($igosja_season_id + 1) . ',' . $item . ')';
                }

                $values = implode(',', $values);

                $sql = "INSERT INTO `championship` (`championship_country_id`, `championship_division_id`, `championship_season_id`, `championship_team_id`)
                        VALUES $values;";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "UPDATE `championship`
                SET `championship_place`=`championship_id`-(CEIL(`championship_id`/16)-1)*16
                WHERE `championship_place`=0";
        f_igosja_mysqli_query($sql);

        if (isset($rotate_array['conference']))
        {
            $values = array();

            foreach ($rotate_array['conference'] as $item)
            {
                $values[] = '(' . ($igosja_season_id + 1) . ',' . $item . ')';
            }

            $values = implode(',', $values);

            $sql = "INSERT INTO `conference` (`conference_season_id`, `conference_team_id`)
                    VALUES $values;";
            f_igosja_mysqli_query($sql);
        }
    }
}