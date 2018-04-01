<?php

/**
 * Жереб в ЛЧ
 * @param $team_array array список команд, котрі треба прожеребкувати
 * @param $stage_id integer
 * @return array массив з матчами
 */
function f_igosja_league($team_array, $stage_id)
{
    if (in_array($stage_id, array(STAGE_2_QUALIFY, STAGE_3_QUALIFY)))
    {
        if (!$team_result_array = f_igosja_league_one($team_array))
        {
            $team_result_array = f_igosja_league($team_array, $stage_id);
        }
    }
    else
    {
        if (!$team_result_array = f_igosja_league_group($team_array))
        {
            $team_result_array = f_igosja_league($team_array, $stage_id);
        }
    }

    return $team_result_array;
}