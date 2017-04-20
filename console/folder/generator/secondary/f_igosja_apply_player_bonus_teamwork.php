<?php

function f_igosja_apply_player_bonus_teamwork($game_result)
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

        $game_result[$team]['player']['gk']['power_real'] = round($game_result[$team]['player']['gk']['power_real'] * (100 + $game_result[$team]['player']['gk']['bonus'] + $game_result[$team]['team']['leader'] + $game_result[$team]['team']['teamwork'][1] + $game_result[$team]['team']['teamwork'][2] + $game_result[$team]['team']['teamwork'][3]) / 100);

        for ($line=1; $line<=3; $line++)
        {
            for ($k=POSITION_LD; $k<=POSITION_RW; $k++)
            {
                if     (POSITION_LD == $k) { $key = 'ld'; }
                elseif (POSITION_RD == $k) { $key = 'rd'; }
                elseif (POSITION_LW == $k) { $key = 'lw'; }
                elseif (POSITION_C  == $k) { $key =  'c'; }
                else                       { $key = 'rw'; }

                $key = $key . '_' . $line;

                $game_result[$team]['player']['field'][$key]['power_real'] = round($game_result[$team]['player']['field'][$key]['power_real'] * (100 + $game_result[$team]['player']['field'][$key]['bonus'] + $game_result[$team]['team']['leader'] + $game_result[$team]['team']['teamwork'][$line]) / 100);
            }
        }
    }

    return $game_result;
}