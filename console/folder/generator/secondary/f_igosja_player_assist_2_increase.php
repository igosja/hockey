<?php

/**
 * Записуємо дані про другу результативну передачу
 * @param $game_result array
 * @param $team string home або guest
 * @param $opponent string home або guest
 * @return array
 */
function f_igosja_player_assist_2_increase($game_result, $team, $opponent)
{
    $power_short            = '';
    $count_team_penalty     = count($game_result[$team]['team']['penalty']['current']);
    $count_opponent_penalty = count($game_result[$opponent]['team']['penalty']['current']);

    if ($count_team_penalty < $count_opponent_penalty && 2 > $count_team_penalty)
    {
        $power_short = 'assist_power';
    }
    elseif ($count_team_penalty > $count_opponent_penalty && 2 > $count_opponent_penalty)
    {
        $power_short = 'assist_short';
    }

    $count_event = count($game_result['event']);

    if (POSITION_GK == $game_result['assist_2'])
    {
        if ($power_short)
        {
            $game_result[$team]['player']['gk'][$power_short]++;
        }

        $game_result[$team]['player']['gk']['assist']++;
        $event_player_id = $game_result[$team]['player']['gk']['player_id'];
        $game_result['event'][$count_event - 1]['event_player_assist_2_id'] = $event_player_id;
    }
    elseif (POSITION_LD == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $player = 'ld_1';
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $player = 'ld_2';
        }
        else
        {
            $player = 'ld_3';
        }
    }
    elseif (POSITION_RD == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $player = 'rd_1';
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $player = 'rd_2';
        }
        else
        {
            $player = 'rd_3';
        }
    }
    elseif (POSITION_LW == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $player = 'lw_1';
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $player = 'lw_2';
        }
        else
        {
            $player = 'lw_3';
        }
    }
    elseif (POSITION_C == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $player = 'c_1';
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $player = 'c_2';
        }
        else
        {
            $player = 'c_3';
        }
    }
    elseif (POSITION_RW == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $player = 'rw_1';
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $player = 'rw_2';
        }
        else
        {
            $player = 'rw_3';
        }
    }

    if (isset($player))
    {
        if ($power_short)
        {
            $game_result[$team]['player']['field'][$player][$power_short]++;
        }

        $game_result[$team]['player']['field'][$player]['assist']++;
        $event_player_id = $game_result[$team]['player']['field'][$player]['player_id'];
        $game_result['event'][$count_event - 1]['event_player_assist_2_id'] = $event_player_id;
    }

    return $game_result;
}