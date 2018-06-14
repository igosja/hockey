<?php

/**
 * Рахуємо силу всіх ланок команд
 * @param $game_result array
 * @return array
 */
function f_igosja_team_power($game_result)
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

        $game_result[$team]['team']['power']['gk'] = $game_result[$team]['player']['gk']['power_real'];
        $game_result[$team]['team']['power']['defence'][1]
            = $game_result[$team]['player']['field']['ld_1']['power_real']
            + $game_result[$team]['player']['field']['rd_1']['power_real'];
        $game_result[$team]['team']['power']['defence'][2]
            = $game_result[$team]['player']['field']['ld_2']['power_real']
            + $game_result[$team]['player']['field']['rd_2']['power_real'];
        $game_result[$team]['team']['power']['defence'][3]
            = $game_result[$team]['player']['field']['ld_3']['power_real']
            + $game_result[$team]['player']['field']['rd_3']['power_real'];
        $game_result[$team]['team']['power']['forward'][1]
            = $game_result[$team]['player']['field']['lw_1']['power_real']
            + $game_result[$team]['player']['field']['c_1']['power_real']
            + $game_result[$team]['player']['field']['rw_1']['power_real'];
        $game_result[$team]['team']['power']['forward'][2]
            = $game_result[$team]['player']['field']['lw_2']['power_real']
            + $game_result[$team]['player']['field']['c_2']['power_real']
            + $game_result[$team]['player']['field']['rw_2']['power_real'];
        $game_result[$team]['team']['power']['forward'][3]
            = $game_result[$team]['player']['field']['lw_3']['power_real']
            + $game_result[$team]['player']['field']['c_3']['power_real']
            + $game_result[$team]['player']['field']['rw_3']['power_real'];
        $game_result[$team]['team']['power']['total']
            = $game_result[$team]['team']['power']['gk']
            + $game_result[$team]['team']['power']['defence'][1]
            + $game_result[$team]['team']['power']['defence'][2]
            + $game_result[$team]['team']['power']['defence'][3]
            + $game_result[$team]['team']['power']['forward'][1]
            + $game_result[$team]['team']['power']['forward'][2]
            + $game_result[$team]['team']['power']['forward'][3];
        $game_result[$team]['team']['power']['optimal']
            = $game_result[$team]['player']['gk']['power_optimal']
            + $game_result[$team]['player']['field']['ld_1']['power_optimal']
            + $game_result[$team]['player']['field']['rd_1']['power_optimal']
            + $game_result[$team]['player']['field']['lw_1']['power_optimal']
            + $game_result[$team]['player']['field']['c_1']['power_optimal']
            + $game_result[$team]['player']['field']['rw_1']['power_optimal']
            + $game_result[$team]['player']['field']['ld_2']['power_optimal']
            + $game_result[$team]['player']['field']['rd_2']['power_optimal']
            + $game_result[$team]['player']['field']['lw_2']['power_optimal']
            + $game_result[$team]['player']['field']['c_2']['power_optimal']
            + $game_result[$team]['player']['field']['rw_2']['power_optimal']
            + $game_result[$team]['player']['field']['ld_3']['power_optimal']
            + $game_result[$team]['player']['field']['rd_3']['power_optimal']
            + $game_result[$team]['player']['field']['lw_3']['power_optimal']
            + $game_result[$team]['player']['field']['c_3']['power_optimal']
            + $game_result[$team]['player']['field']['rw_3']['power_optimal'];
    }

    return $game_result;
}