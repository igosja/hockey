<?php

/**
 * Записуємо учасників ЛЧ наступного сезону
 */
function f_igosja_newseason_league_participant()
{
    global $igosja_season_id;

    $sql = "SELECT `leaguedistribution_country_id`,
                   `leaguedistribution_group`,
                   `leaguedistribution_qualification_4`,
                   `leaguedistribution_qualification_3`,
                   `leaguedistribution_qualification_2`,
                   `leaguedistribution_qualification_1`,
                   `leaguedistribution_group`+`leaguedistribution_qualification_4`+`leaguedistribution_qualification_3`+`leaguedistribution_qualification_2`+`leaguedistribution_qualification_1` AS `leaguedistribution_total`
            FROM `leaguedistribution`
            WHERE `leaguedistribution_season_id`=$igosja_season_id+1
            ORDER BY `leaguedistribution_id` ASC";
    $distribution_sql = f_igosja_mysqli_query($sql);

    $distribution_array = $distribution_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($distribution_array as $item)
    {
        $country_id         = $item['leaguedistribution_country_id'];
        $participant_array  = array();

        $sql = "SELECT `participantchampionship_team_id`
                FROM `participantchampionship`
                WHERE `participantchampionship_country_id`=$country_id
                AND `participantchampionship_division_id`=1
                AND `participantchampionship_season_id`=$igosja_season_id
                AND `participantchampionship_stage_id`=0
                LIMIT 1";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        $participant_array[] = $team_array[0]['participantchampionship_team_id'];

        if ($item['leaguedistribution_total'] > 1)
        {
            $participant = implode(',', $participant_array);

            $sql = "SELECT `championship_team_id`
                    FROM `championship`
                    WHERE `championship_country_id`=$country_id
                    AND `championship_division_id`=1
                    AND `championship_season_id`=$igosja_season_id
                    AND `championship_team_id` NOT IN ($participant)
                    ORDER BY `championship_place` ASC
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            $participant_array[] = $team_array[0]['championship_team_id'];
        }

        if ($item['leaguedistribution_total'] > 2)
        {
            $participant = implode(',', $participant_array);

            $sql = "SELECT `participantchampionship_team_id`
                    FROM `participantchampionship`
                    WHERE `participantchampionship_country_id`=$country_id
                    AND `participantchampionship_division_id`=1
                    AND `participantchampionship_season_id`=$igosja_season_id
                    AND `participantchampionship_team_id` NOT IN ($participant)
                    AND `participantchampionship_stage_id`=" . STAGE_FINAL . "
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            if (0 != $team_sql->num_rows)
            {
                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                $participant_array[] = $team_array[0]['participantchampionship_team_id'];
            }
            else
            {
                $participant = implode(',', $participant_array);

                $sql = "SELECT `championship_team_id`
                        FROM `championship`
                        WHERE `championship_country_id`=$country_id
                        AND `championship_division_id`=1
                        AND `championship_season_id`=$igosja_season_id
                        AND `championship_team_id` NOT IN ($participant)
                        ORDER BY `championship_place` ASC
                        LIMIT 1";
                $team_sql = f_igosja_mysqli_query($sql);

                $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

                $participant_array[] = $team_array[0]['championship_team_id'];
            }
        }

        if ($item['leaguedistribution_total'] > 3)
        {
            $limit          = $item['leaguedistribution_total'] - count($participant_array);
            $participant    = implode(',', $participant_array);

            $sql = "SELECT `championship_team_id`
                    FROM `championship`
                    WHERE `championship_country_id`=$country_id
                    AND `championship_division_id`=1
                    AND `championship_season_id`=$igosja_season_id
                    AND `championship_team_id` NOT IN ($participant)
                    ORDER BY `championship_place` ASC
                    LIMIT $limit";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            foreach ($team_array as $team)
            {
                $participant_array[] = $team['championship_team_id'];
            }
        }

        $values = array();

        if (0 != $item['leaguedistribution_group'])
        {
            $group_array        = array_slice($participant_array, 0, $item['leaguedistribution_group']);
            array_splice($participant_array, 0, $item['leaguedistribution_group']);

            foreach ($group_array as $value)
            {
                $values[] = '(' . ($igosja_season_id + 1) . ', ' . STAGE_1_TOUR . ', ' . $value . ')';
            }
        }

        for ($i=4; $i>=1; $i--)
        {
            if (0 != $item['leaguedistribution_qualification_' . $i])
            {
                if (4 == $i)
                {
                    $stage = STAGE_4_QUALIFY;
                }
                elseif (3 == $i)
                {
                    $stage = STAGE_3_QUALIFY;
                }
                elseif (2 == $i)
                {
                    $stage = STAGE_2_QUALIFY;
                }
                else
                {
                    $stage = STAGE_1_QUALIFY;
                }

                $qualify_array      = array_slice($participant_array, 0, $item['leaguedistribution_qualification_' . $i]);
                array_splice($participant_array, 0, $item['leaguedistribution_qualification_' . $i]);

                foreach ($qualify_array as $value)
                {
                    $values[] = '(' . ($igosja_season_id + 1) . ', ' . $stage . ', ' . $value . ')';
                }
            }
        }

        $values = implode(',', $values);

        $sql = "INSERT INTO `participantleague` (`participantleague_season_id`, `participantleague_stage_in`, `participantleague_team_id`)
                VALUES $values;";
        f_igosja_mysqli_query($sql);
    }
}