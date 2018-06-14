<?php

/**
 * Записуємо дані про гол в масив хокеїста
 * @param $game_result array
 * @param $team string home або guest
 * @param $opponent string home або guest
 * @return array
 */
function f_igosja_player_score_increase($game_result, $team, $opponent)
{
    $count_team_penalty     = count($game_result[$team]['team']['penalty']['current']);
    $count_opponent_penalty = count($game_result[$opponent]['team']['penalty']['current']);
    $draw                   = '';
    $power_short            = '';

    if ($count_team_penalty < $count_opponent_penalty && 2 > $count_team_penalty)
    {
        $power_short = 'score_power';
    }
    elseif ($count_team_penalty > $count_opponent_penalty && 2 > $count_opponent_penalty)
    {
        $power_short = 'score_short';
    }

    if ($game_result[$team]['team']['score']['total'] == $game_result[$opponent]['team']['score']['total'])
    {
        $draw = 'score_draw';
    }

    $count_event = count($game_result['event']);

    if (POSITION_LD == $game_result['player'])
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
    elseif (POSITION_RD == $game_result['player'])
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
    elseif (POSITION_LW == $game_result['player'])
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
    elseif (POSITION_C == $game_result['player'])
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
    elseif (POSITION_RW == $game_result['player'])
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

        if ($draw)
        {
            $game_result[$team]['player']['field'][$player][$draw]++;
        }

        $game_result[$team]['player']['field'][$player]['score']++;
        $event_player_id = $game_result[$team]['player']['field'][$player]['player_id'];
        $game_result['event'][$count_event - 1]['event_player_score_id'] = $event_player_id;
        $game_result[$team]['team']['score']['last']['score'] = $player;
    }

    return $game_result;
}