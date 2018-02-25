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

        $team_id        = $game_result['game_info'][$team . '_team_id'];
        $national_id    = $game_result['game_info'][$team . '_national_id'];

        if (0 != $team_id)
        {
            $sql = "SELECT `team_power_vs`
                    FROM `team`
                    WHERE `team_id`=$team_id
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

            $game_result[$team]['team']['power']['forecast'] = $team_array[0]['team_power_vs'];
        }
        else
        {
            $sql = "SELECT `national_power_vs`
                    FROM `national`
                    WHERE `national_id`=$team_id
                    LIMIT 1";
            $national_sql = f_igosja_mysqli_query($sql);

            $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

            $game_result[$team]['team']['power']['forecast'] = $national_array[0]['national_power_vs'];
        }

        if (0 == $game_result[$team]['team']['power']['forecast'])
        {
            $game_result[$team]['team']['power']['forecast'] = $game_result[$team]['team']['power']['optimal'];
        }
    }

    return $game_result;
}