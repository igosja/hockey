<?php

function f_igosja_player_assist_1_increase($game_result, $team)
{
    $count_event = count($game_result['event']);

    if (POSITION_LD == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['ld_1']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['ld_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['ld_2']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['ld_2']['player_id'];
        }
        else
        {
            $game_result[$team]['player']['field']['ld_3']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['ld_3']['player_id'];
        }
    }
    elseif (POSITION_RD == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rd_1']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['rd_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rd_2']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['rd_2']['player_id'];
        }
        else
        {
            $game_result[$team]['player']['field']['rd_3']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['rd_3']['player_id'];
        }
    }
    elseif (POSITION_LW == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['lw_1']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['lw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['lw_2']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['lw_2']['player_id'];
        }
        else
        {
            $game_result[$team]['player']['field']['lw_3']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['lw_3']['player_id'];
        }
    }
    elseif (POSITION_C == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['c_1']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['c_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['c_2']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['c_2']['player_id'];
        }
        else
        {
            $game_result[$team]['player']['field']['c_3']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['c_3']['player_id'];
        }
    }
    elseif (POSITION_RW == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rw_1']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['rw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result[$team]['player']['field']['rw_2']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['rw_2']['player_id'];
        }
        else
        {
            $game_result[$team]['player']['field']['rw_3']['assist']++;
            $event_player_id = $game_result[$team]['player']['field']['rw_3']['player_id'];
        }
    }

    if (isset($event_player_id))
    {
        $game_result['event'][$count_event - 1]['event_player_assist_1_id'] = $event_player_id;
    }

    return $game_result;
}