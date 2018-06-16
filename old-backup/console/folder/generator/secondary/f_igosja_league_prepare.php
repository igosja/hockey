<?php

/**
 * Готуємо массив команд для жеребу в ЛЧ
 * @param $stage_id integer
 * @return array
 */
function f_igosja_league_prepare($stage_id)
{
    global $igosja_season_id;

    if (STAGE_2_QUALIFY == $stage_id)
    {
        $sql = "SELECT `city_country_id`,
                       `team_id`
                FROM `participantleague`
                LEFT JOIN `team`
                ON `participantleague_team_id`=`team_id`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                WHERE `participantleague_season_id`=$igosja_season_id
                AND `participantleague_stage_in` IN (" . STAGE_1_QUALIFY . ", " . STAGE_2_QUALIFY . ")
                AND `participantleague_stage_id`=0
                ORDER BY `team_power_vs` DESC";
    }
    elseif (STAGE_3_QUALIFY == $stage_id)
    {
        $sql = "SELECT `city_country_id`,
                       `team_id`
                FROM `participantleague`
                LEFT JOIN `team`
                ON `participantleague_team_id`=`team_id`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                WHERE `participantleague_season_id`=$igosja_season_id
                AND `participantleague_stage_in` IN (" . STAGE_1_QUALIFY . ", " . STAGE_2_QUALIFY . ", " . STAGE_3_QUALIFY . ")
                AND `participantleague_stage_id`=0
                ORDER BY `team_power_vs` DESC";
    }
    else
    {
        $sql = "SELECT `city_country_id`,
                       `team_id`
                FROM `participantleague`
                LEFT JOIN `team`
                ON `participantleague_team_id`=`team_id`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                WHERE `participantleague_season_id`=$igosja_season_id
                AND `participantleague_stage_id`=0
                ORDER BY `team_power_vs` DESC
                LIMIT 32";
    }

    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    $team_result_array = array(
        array(),
        array(),
        array(),
        array(),
    );

    $limit_quater   = $team_sql->num_rows / 4;
    $limit_half     = $team_sql->num_rows / 2;
    $limit_three    = $limit_quater * 3;

    for ($i=0; $i<$team_sql->num_rows; $i++)
    {
        if (in_array($stage_id, array(STAGE_2_QUALIFY, STAGE_3_QUALIFY)))
        {
            if ($i < $limit_half)
            {
                $team_result_array[0][] = $team_array[$i];
            }
            else
            {
                $team_result_array[1][] = $team_array[$i];
            }
        }
        else
        {
            if ($i < $limit_quater)
            {
                $team_result_array[0][] = $team_array[$i];
            }
            elseif ($i < $limit_half)
            {
                $team_result_array[1][] = $team_array[$i];
            }
            elseif ($i < $limit_three)
            {
                $team_result_array[2][] = $team_array[$i];
            }
            else
            {
                $team_result_array[3][] = $team_array[$i];
            }
        }
    }

    return $team_result_array;
}