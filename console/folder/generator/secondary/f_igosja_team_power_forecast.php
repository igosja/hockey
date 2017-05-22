<?php

/**
 * Записуємо прогнозовану силу команд на гру
 * @param $game_result array
 * @return array
 */
function f_igosja_team_power_forecast($game_result)
{
    for ($i=0; $i<2; $i++)
    {
        if (0 == $i)
        {
            $team = TEAM_HOME;
        }
        else
        {
            $team = TEAM_GUEST;
        }

        $team_id = $game_result['game_info'][$team . '_team_id'];

        $sql = "SELECT `team_power_vs`
                FROM `team`
                WHERE `team_id`=$team_id
                LIMIT 1";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(1);

        $game_result[$team]['team']['power']['forecast'] = $team_array[0]['team_power_vs'];
    }

    return $game_result;
}