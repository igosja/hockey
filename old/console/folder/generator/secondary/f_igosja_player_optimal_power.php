<?php

/**
 * Розрахунок оптимальної сили гравців до корегування на оптимальність позиції
 * @param $game_result array
 * @return array
 */
function f_igosja_player_optimal_power($game_result)
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

        $game_result[$team]['player']['gk']['power_optimal'] = round(
            $game_result[$team]['player']['gk']['power_optimal']
            * (100 + $game_result[$team]['player']['gk']['bonus'] + $game_result[$team]['team']['leader']) / 100
            * (100 + ($game_result[$team]['team']['teamwork'][1] + $game_result[$team]['team']['teamwork'][2] + $game_result[$team]['team']['teamwork'][3]) / 3) / 100
            * (10 - $game_result[$team]['team']['mood'] + 2) / 10
            * (100 - AUTO_PENALTY * $game_result[$team]['team']['auto']) / 100
        );

        if (TEAM_HOME == $team)
        {
            $game_result[$team]['player']['gk']['power_optimal'] = round(
                $game_result[$team]['player']['gk']['power_optimal'] * $game_result['game_info']['home_bonus']
            );
        }

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

                if (in_array($k, array(POSITION_LD, POSITION_RD)))
                {
                    if (TACTIC_ATACK_SUPER == $game_result[$team]['team']['tactic'][$line])
                    {
                        $tactic = -10 / 2;
                    }
                    elseif (TACTIC_ATACK == $game_result[$team]['team']['tactic'][$line])
                    {
                        $tactic = -5 / 2;
                    }
                    elseif (TACTIC_DEFENCE == $game_result[$team]['team']['tactic'][$line])
                    {
                        $tactic = 5 / 2;
                    }
                    elseif (TACTIC_DEFENCE_SUPER == $game_result[$team]['team']['tactic'][$line])
                    {
                        $tactic = 10 / 2;
                    }
                    else
                    {
                        $tactic = 0;
                    }
                }
                else
                {
                    if (TACTIC_ATACK_SUPER == $game_result[$team]['team']['tactic'][$line])
                    {
                        $tactic = 10 / 3;
                    }
                    elseif (TACTIC_ATACK == $game_result[$team]['team']['tactic'][$line])
                    {
                        $tactic = 5 / 3;
                    }
                    elseif (TACTIC_DEFENCE == $game_result[$team]['team']['tactic'][$line])
                    {
                        $tactic = -5 / 3;
                    }
                    elseif (TACTIC_DEFENCE_SUPER == $game_result[$team]['team']['tactic'][$line])
                    {
                        $tactic = -10 / 3;
                    }
                    else
                    {
                        $tactic = 0;
                    }
                }

                if (-1 == $game_result[$team]['team']['collision'][$line])
                {
                    $collision = 0;
                }
                else
                {
                    $collision = $game_result[$team]['team']['collision'][$line];
                }

                $game_result[$team]['player']['field'][$key]['power_optimal'] = round(
                    $game_result[$team]['player']['field'][$key]['power_optimal']
                    * (100 + $game_result[$team]['player']['field'][$key]['bonus'] + $game_result[$team]['team']['leader']) / 100
                    * (100 + $game_result[$team]['team']['teamwork'][$line]) / 100
                    * (10 - $game_result[$team]['team']['mood'] + 2) / 10
                    * (100 + $game_result[$team]['team']['rude'][$line] - 1) / 100
                    * (10 + $collision) / 10
                    * (100 + $tactic) / 100
                    * (100 - AUTO_PENALTY * $game_result[$team]['team']['auto']) / 100
                );

                if (TEAM_HOME == $team)
                {
                    $game_result[$team]['player']['field'][$key]['power_optimal'] = round(
                        $game_result[$team]['player']['field'][$key]['power_optimal'] * $game_result['game_info']['home_bonus']
                    );
                }
            }
        }
    }

    return $game_result;
}