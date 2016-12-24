<?php

function f_igosja_home_defence($result)
{
    if (0 == $result['minute'] % 3)
    {
        $result['home']['team']['power']['defence']['current'] = $result['home']['team']['power']['defence'][1];
    }
    elseif (1 == $result['minute'] % 3)
    {
        $result['home']['team']['power']['defence']['current'] = $result['home']['team']['power']['defence'][2];
    }
    else
    {
        $result['home']['team']['power']['defence']['current'] = $result['home']['team']['power']['defence'][3];
    }

    return $result;
}

function f_igosja_home_forward($result)
{
    if (0 == $result['minute'] % 3)
    {
        $result['home']['team']['power']['forward']['current'] = $result['home']['team']['power']['forward'][1];
    }
    elseif (1 == $result['minute'] % 3)
    {
        $result['home']['team']['power']['forward']['current'] = $result['home']['team']['power']['forward'][2];
    }
    else
    {
        $result['home']['team']['power']['forward']['current'] = $result['home']['team']['power']['forward'][3];
    }

    return $result;
}

function f_igosja_guest_defence($result)
{
    if (0 == $result['minute'] % 3)
    {
        $result['guest']['team']['power']['defence']['current'] = $result['guest']['team']['power']['defence'][1];
    }
    elseif (1 == $result['minute'] % 3)
    {
        $result['guest']['team']['power']['defence']['current'] = $result['guest']['team']['power']['defence'][2];
    }
    else
    {
        $result['guest']['team']['power']['defence']['current'] = $result['guest']['team']['power']['defence'][3];
    }

    return $result;
}

function f_igosja_guest_forward($result)
{
    if (0 == $result['minute'] % 3)
    {
        $result['guest']['team']['power']['forward']['current'] = $result['guest']['team']['power']['forward'][1];
    }
    elseif (1 == $result['minute'] % 3)
    {
        $result['guest']['team']['power']['forward']['current'] = $result['guest']['team']['power']['forward'][2];
    }
    else
    {
        $result['guest']['team']['power']['forward']['current'] = $result['guest']['team']['power']['forward'][3];
    }

    return $result;
}

function f_igosja_home_current_penalty_increase($game_result)
{
    $game_result['home']['team']['penalty']['current'][] = array(
        'minute' => $game_result['minute'],
        'position' => $game_result['player'],
    );

    return $game_result;
}

function f_igosja_guest_current_penalty_increase($game_result)
{
    $game_result['guest']['team']['penalty']['current'][] = array(
        'minute' => $game_result['minute'],
        'position' => $game_result['player'],
    );

    return $game_result;
}

function f_igosja_home_player_penalty_increase($game_result)
{
    $count_event = count($game_result['event']);

    if (POSITION_LD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_1']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['ld_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_2']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['ld_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['ld_3']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['ld_3']['player_id'];
        }
    }
    elseif (POSITION_RD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_1']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['rd_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_2']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['rd_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['rd_3']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['rd_3']['player_id'];
        }
    }
    elseif (POSITION_LW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lw_1']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['lw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lw_2']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['lw_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['lw_3']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['lw_3']['player_id'];
        }
    }
    elseif (POSITION_C == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_1']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['c_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_2']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['c_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['c_3']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['c_3']['player_id'];
        }
    }
    elseif (POSITION_RW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rw_1']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['rw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rw_2']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['rw_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['rw_3']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['home']['player']['field']['rw_3']['player_id'];
        }
    }

    return $game_result;
}

function f_igosja_guest_player_penalty_increase($game_result)
{
    $count_event = count($game_result['event']);

    if (POSITION_LD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_1']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['ld_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_2']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['ld_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['ld_3']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['ld_3']['player_id'];
        }
    }
    elseif (POSITION_RD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_1']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['rd_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_2']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['rd_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['rd_3']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['rd_3']['player_id'];
        }
    }
    elseif (POSITION_LW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lw_1']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['lw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lw_2']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['lw_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['lw_3']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['lw_3']['player_id'];
        }
    }
    elseif (POSITION_C == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_1']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['c_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_2']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['c_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['c_3']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['c_3']['player_id'];
        }
    }
    elseif (POSITION_RW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rw_1']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['rw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rw_2']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['rw_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['rw_3']['penalty']++;
            $game_result['event'][$count_event - 1]['event_player_penalty_id'] =
                $game_result['guest']['player']['field']['rw_3']['player_id'];
        }
    }

    return $game_result;
}

function f_igosja_home_team_penalty_increase($game_result)
{
    $game_result['home']['team']['penalty']['total']++;

    if (20 > $game_result['minute'])
    {
        $game_result['home']['team']['penalty'][1]++;
    }
    elseif (40 > $game_result['minute'])
    {
        $game_result['home']['team']['penalty'][2]++;
    }
    else
    {
        $game_result['home']['team']['penalty'][3]++;
    }

    return $game_result;
}

function f_igosja_guest_team_penalty_increase($game_result)
{
    $game_result['guest']['team']['penalty']['total']++;

    if (20 > $game_result['minute'])
    {
        $game_result['guest']['team']['penalty'][1]++;
    }
    elseif (40 > $game_result['minute'])
    {
        $game_result['guest']['team']['penalty'][2]++;
    }
    else
    {
        $game_result['guest']['team']['penalty'][3]++;
    }

    return $game_result;
}

function f_igosja_home_team_shot_increase($game_result)
{
    $game_result['guest']['player']['gk']['shot']++;
    $game_result['home']['team']['shot']['total']++;

    if (20 > $game_result['minute'])
    {
        $game_result['home']['team']['shot'][1]++;
    }
    elseif (40 > $game_result['minute'])
    {
        $game_result['home']['team']['shot'][2]++;
    }
    else
    {
        $game_result['home']['team']['shot'][3]++;
    }

    return $game_result;
}

function f_igosja_guest_team_shot_increase($game_result)
{
    $game_result['home']['player']['gk']['shot']++;
    $game_result['guest']['team']['shot']['total']++;

    if (20 > $game_result['minute'])
    {
        $game_result['guest']['team']['shot'][1]++;
    }
    elseif (40 > $game_result['minute'])
    {
        $game_result['guest']['team']['shot'][2]++;
    }
    else
    {
        $game_result['guest']['team']['shot'][3]++;
    }

    return $game_result;
}

function f_igosja_home_player_shot_increase($game_result)
{
    if (POSITION_LD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_2']['shot']++;
        }
        else
        {
            $game_result['home']['player']['field']['ld_3']['shot']++;
        }
    }
    elseif (POSITION_RD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_2']['shot']++;
        }
        else
        {
            $game_result['home']['player']['field']['rd_3']['shot']++;
        }
    }
    elseif (POSITION_LW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lw_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lw_2']['shot']++;
        }
        else
        {
            $game_result['home']['player']['field']['lw_3']['shot']++;
        }
    }
    elseif (POSITION_C == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_2']['shot']++;
        }
        else
        {
            $game_result['home']['player']['field']['c_3']['shot']++;
        }
    }
    elseif (POSITION_RW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rw_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rw_2']['shot']++;
        }
        else
        {
            $game_result['home']['player']['field']['rw_3']['shot']++;
        }
    }

    return $game_result;
}

function f_igosja_guest_player_shot_increase($game_result)
{
    if (POSITION_LD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_2']['shot']++;
        }
        else
        {
            $game_result['guest']['player']['field']['ld_3']['shot']++;
        }
    }
    elseif (POSITION_RD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_2']['shot']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rd_3']['shot']++;
        }
    }
    elseif (POSITION_LW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lw_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lw_2']['shot']++;
        }
        else
        {
            $game_result['guest']['player']['field']['lw_3']['shot']++;
        }
    }
    elseif (POSITION_C == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_2']['shot']++;
        }
        else
        {
            $game_result['guest']['player']['field']['c_3']['shot']++;
        }
    }
    elseif (POSITION_RW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rw_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rw_2']['shot']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rw_3']['shot']++;
        }
    }

    return $game_result;
}

function f_igosja_home_player_shot_power($game_result)
{
    if (POSITION_LD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['ld_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['ld_2']['power_real'];
        }
        else
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['ld_3']['power_real'];
        }
    }
    elseif (POSITION_RD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['rd_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['rd_2']['power_real'];
        }
        else
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['rd_3']['power_real'];
        }
    }
    elseif (POSITION_LW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['lw_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['lw_2']['power_real'];
        }
        else
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['lw_3']['power_real'];
        }
    }
    elseif (POSITION_C == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['c_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['c_2']['power_real'];
        }
        else
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['c_3']['power_real'];
        }
    }
    elseif (POSITION_RW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['rw_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['rw_2']['power_real'];
        }
        else
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['rw_3']['power_real'];
        }
    }

    return $game_result;
}

function f_igosja_guest_player_shot_power($game_result)
{
    if (POSITION_LD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['ld_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['ld_2']['power_real'];
        }
        else
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['ld_3']['power_real'];
        }
    }
    elseif (POSITION_RD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['rd_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['rd_2']['power_real'];
        }
        else
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['rd_3']['power_real'];
        }
    }
    elseif (POSITION_LW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['lw_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['lw_2']['power_real'];
        }
        else
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['lw_3']['power_real'];
        }
    }
    elseif (POSITION_C == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['c_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['c_2']['power_real'];
        }
        else
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['c_3']['power_real'];
        }
    }
    elseif (POSITION_RW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['rw_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['rw_2']['power_real'];
        }
        else
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['rw_3']['power_real'];
        }
    }

    return $game_result;
}

function f_igosja_home_team_score_increase($game_result)
{
    $game_result['home']['team']['score']['total']++;
    $game_result['guest']['player']['gk']['pass']++;

    if (20 > $game_result['minute'])
    {
        $game_result['home']['team']['score'][1]++;
    }
    elseif (40 > $game_result['minute'])
    {
        $game_result['home']['team']['score'][2]++;
    }
    else
    {
        $game_result['home']['team']['score'][3]++;
    }

    return $game_result;
}

function f_igosja_guest_team_score_increase($game_result)
{
    $game_result['guest']['team']['score']['total']++;
    $game_result['home']['player']['gk']['pass']++;

    if (20 > $game_result['minute'])
    {
        $game_result['guest']['team']['score'][1]++;
    }
    elseif (40 > $game_result['minute'])
    {
        $game_result['guest']['team']['score'][2]++;
    }
    else
    {
        $game_result['guest']['team']['score'][3]++;
    }

    return $game_result;
}

function f_igosja_home_plus_minus_increase($game_result)
{
    $penalty_position_home = array();

    $count_penalty = count($game_result['home']['team']['penalty']['current']);

    if (2 < $count_penalty)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position_home[] = $game_result['home']['team']['penalty']['current'][$i]['position'];
    }

    $penalty_position_guest = array();

    $count_penalty = count($game_result['guest']['team']['penalty']['current']);

    if (2 < $count_penalty)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position_guest[] = $game_result['guest']['team']['penalty']['current'][$i]['position'];
    }

    if (0 == $game_result['minute'] % 3)
    {
        if (!in_array(POSITION_LD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['ld_1']['plus_minus']++;
        }
        
        if (!in_array(POSITION_RD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rd_1']['plus_minus']++;
        }
        
        if (!in_array(POSITION_LW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['lw_1']['plus_minus']++;
        }
        
        if (!in_array(POSITION_C, $penalty_position_home))
        {
            $game_result['home']['player']['field']['c_1']['plus_minus']++;
        }

        if (!in_array(POSITION_RW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rw_1']['plus_minus']++;
        }

        if (!in_array(POSITION_LD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['ld_1']['plus_minus']--;
        }
        
        if (!in_array(POSITION_RD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rd_1']['plus_minus']--;
        }
        
        if (!in_array(POSITION_LW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['lw_1']['plus_minus']--;
        }
        
        if (!in_array(POSITION_C, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['c_1']['plus_minus']--;
        }
        
        if (!in_array(POSITION_RW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rw_1']['plus_minus']--;
        }
    }
    elseif (1 == $game_result['minute'] % 3)
    {
        if (!in_array(POSITION_LD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['ld_2']['plus_minus']++;
        }

        if (!in_array(POSITION_RD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rd_2']['plus_minus']++;
        }

        if (!in_array(POSITION_LW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['lw_2']['plus_minus']++;
        }

        if (!in_array(POSITION_C, $penalty_position_home))
        {
            $game_result['home']['player']['field']['c_2']['plus_minus']++;
        }

        if (!in_array(POSITION_RW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rw_2']['plus_minus']++;
        }

        if (!in_array(POSITION_LD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['ld_2']['plus_minus']--;
        }

        if (!in_array(POSITION_RD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rd_2']['plus_minus']--;
        }

        if (!in_array(POSITION_LW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['lw_2']['plus_minus']--;
        }

        if (!in_array(POSITION_C, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['c_2']['plus_minus']--;
        }

        if (!in_array(POSITION_RW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rw_2']['plus_minus']--;
        }
    }
    else
    {
        if (!in_array(POSITION_LD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['ld_3']['plus_minus']++;
        }

        if (!in_array(POSITION_RD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rd_3']['plus_minus']++;
        }

        if (!in_array(POSITION_LW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['lw_3']['plus_minus']++;
        }

        if (!in_array(POSITION_C, $penalty_position_home))
        {
            $game_result['home']['player']['field']['c_3']['plus_minus']++;
        }

        if (!in_array(POSITION_RW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rw_3']['plus_minus']++;
        }

        if (!in_array(POSITION_LD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['ld_3']['plus_minus']--;
        }

        if (!in_array(POSITION_RD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rd_3']['plus_minus']--;
        }

        if (!in_array(POSITION_LW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['lw_3']['plus_minus']--;
        }

        if (!in_array(POSITION_C, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['c_3']['plus_minus']--;
        }

        if (!in_array(POSITION_RW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rw_3']['plus_minus']--;
        }
    }

    return $game_result;
}

function f_igosja_guest_plus_minus_increase($game_result)
{
    $penalty_position_home = array();

    $count_penalty = count($game_result['home']['team']['penalty']['current']);

    if (2 < $count_penalty)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position_home[] = $game_result['home']['team']['penalty']['current'][$i]['position'];
    }

    $penalty_position_guest = array();

    $count_penalty = count($game_result['guest']['team']['penalty']['current']);

    if (2 < $count_penalty)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position_guest[] = $game_result['guest']['team']['penalty']['current'][$i]['position'];
    }

    if (0 == $game_result['minute'] % 3)
    {
        if (!in_array(POSITION_LD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['ld_1']['plus_minus']++;
        }

        if (!in_array(POSITION_RD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rd_1']['plus_minus']++;
        }

        if (!in_array(POSITION_LW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['lw_1']['plus_minus']++;
        }

        if (!in_array(POSITION_C, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['c_1']['plus_minus']++;
        }

        if (!in_array(POSITION_RW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rw_1']['plus_minus']++;
        }

        if (!in_array(POSITION_LD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['ld_1']['plus_minus']--;
        }

        if (!in_array(POSITION_RD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rd_1']['plus_minus']--;
        }

        if (!in_array(POSITION_LW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['lw_1']['plus_minus']--;
        }

        if (!in_array(POSITION_C, $penalty_position_home))
        {
            $game_result['home']['player']['field']['c_1']['plus_minus']--;
        }

        if (!in_array(POSITION_RW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rw_1']['plus_minus']--;
        }
    }
    elseif (1 == $game_result['minute'] % 3)
    {
        if (!in_array(POSITION_LD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['ld_2']['plus_minus']++;
        }

        if (!in_array(POSITION_RD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rd_2']['plus_minus']++;
        }

        if (!in_array(POSITION_LW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['lw_2']['plus_minus']++;
        }

        if (!in_array(POSITION_C, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['c_2']['plus_minus']++;
        }

        if (!in_array(POSITION_RW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rw_2']['plus_minus']++;
        }

        if (!in_array(POSITION_LD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['ld_2']['plus_minus']--;
        }

        if (!in_array(POSITION_RD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rd_2']['plus_minus']--;
        }

        if (!in_array(POSITION_LW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['lw_2']['plus_minus']--;
        }

        if (!in_array(POSITION_C, $penalty_position_home))
        {
            $game_result['home']['player']['field']['c_2']['plus_minus']--;
        }

        if (!in_array(POSITION_RW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rw_2']['plus_minus']--;
        }
    }
    else
    {
        if (!in_array(POSITION_LD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['ld_3']['plus_minus']++;
        }

        if (!in_array(POSITION_RD, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rd_3']['plus_minus']++;
        }

        if (!in_array(POSITION_LW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['lw_3']['plus_minus']++;
        }

        if (!in_array(POSITION_C, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['c_3']['plus_minus']++;
        }

        if (!in_array(POSITION_RW, $penalty_position_guest))
        {
            $game_result['guest']['player']['field']['rw_3']['plus_minus']++;
        }

        if (!in_array(POSITION_LD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['ld_3']['plus_minus']--;
        }

        if (!in_array(POSITION_RD, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rd_3']['plus_minus']--;
        }

        if (!in_array(POSITION_LW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['lw_3']['plus_minus']--;
        }

        if (!in_array(POSITION_C, $penalty_position_home))
        {
            $game_result['home']['player']['field']['c_3']['plus_minus']--;
        }

        if (!in_array(POSITION_RW, $penalty_position_home))
        {
            $game_result['home']['player']['field']['rw_3']['plus_minus']--;
        }
    }

    return $game_result;
}

function f_igosja_home_player_score_increase($game_result)
{
    $count_event = count($game_result['event']);

    if (POSITION_LD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_1']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['ld_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_2']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['ld_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['ld_3']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['ld_3']['player_id'];
        }
    }
    elseif (POSITION_RD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_1']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['rd_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_2']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['rd_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['rd_3']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['rd_3']['player_id'];
        }
    }
    elseif (POSITION_LW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lw_1']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['lw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lw_2']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['lw_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['lw_3']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['lw_3']['player_id'];
        }
    }
    elseif (POSITION_C == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_1']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['c_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_2']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['c_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['c_3']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['c_3']['player_id'];
        }
    }
    elseif (POSITION_RW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rw_1']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['rw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rw_2']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['rw_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['rw_3']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['home']['player']['field']['rw_3']['player_id'];
        }
    }

    return $game_result;
}

function f_igosja_guest_player_score_increase($game_result)
{
    $count_event = count($game_result['event']);

    if (POSITION_LD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_1']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['ld_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_2']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['ld_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['ld_3']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['ld_3']['player_id'];
        }
    }
    elseif (POSITION_RD == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_1']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['rd_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_2']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['rd_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['rd_3']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['rd_3']['player_id'];
        }
    }
    elseif (POSITION_LW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lw_1']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['lw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lw_2']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['lw_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['lw_3']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['lw_3']['player_id'];
        }
    }
    elseif (POSITION_C == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_1']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['c_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_2']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['c_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['c_3']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['c_3']['player_id'];
        }
    }
    elseif (POSITION_RW == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rw_1']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['rw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rw_2']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['rw_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['rw_3']['score']++;
            $game_result['event'][$count_event - 1]['event_player_score_id'] =
                $game_result['guest']['player']['field']['rw_3']['player_id'];
        }
    }

    return $game_result;
}

function f_igosja_home_player_assist_1_increase($game_result)
{
    $count_event = count($game_result['event']);

    if (POSITION_LD == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['ld_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['ld_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['ld_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['ld_3']['player_id'];
        }
    }
    elseif (POSITION_RD == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['rd_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['rd_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['rd_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['rd_3']['player_id'];
        }
    }
    elseif (POSITION_LW == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lw_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['lw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lw_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['lw_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['lw_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['lw_3']['player_id'];
        }
    }
    elseif (POSITION_C == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['c_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['c_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['c_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['c_3']['player_id'];
        }
    }
    elseif (POSITION_RW == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rw_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['rw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rw_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['rw_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['rw_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['home']['player']['field']['rw_3']['player_id'];
        }
    }

    return $game_result;
}

function f_igosja_guest_player_assist_1_increase($game_result)
{
    $count_event = count($game_result['event']);

    if (POSITION_LD == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['ld_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['ld_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['ld_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['ld_3']['player_id'];
        }
    }
    elseif (POSITION_RD == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['rd_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['rd_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['rd_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['rd_3']['player_id'];
        }
    }
    elseif (POSITION_LW == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lw_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['lw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lw_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['lw_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['lw_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['lw_3']['player_id'];
        }
    }
    elseif (POSITION_C == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['c_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['c_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['c_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['c_3']['player_id'];
        }
    }
    elseif (POSITION_RW == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rw_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['rw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rw_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['rw_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['rw_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_1_id'] =
                $game_result['guest']['player']['field']['rw_3']['player_id'];
        }
    }

    return $game_result;
}

function f_igosja_home_player_assist_2_increase($game_result)
{
    $count_event = count($game_result['event']);

    if (POSITION_GK == $game_result['assist_2'])
    {
        $game_result['home']['player']['gk']['assist']++;
        $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
            $game_result['home']['player']['gk']['player_id'];
    }
    elseif (POSITION_LD == $game_result['assist_2'])
    {

        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['ld_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['ld_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['ld_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['ld_3']['player_id'];
        }
    }
    elseif (POSITION_RD == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['rd_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['rd_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['rd_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['rd_3']['player_id'];
        }
    }
    elseif (POSITION_LW == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lw_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['lw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lw_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['lw_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['lw_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['lw_3']['player_id'];
        }
    }
    elseif (POSITION_C == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['c_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['c_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['c_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['c_3']['player_id'];
        }
    }
    elseif (POSITION_RW == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rw_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['rw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rw_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['rw_2']['player_id'];
        }
        else
        {
            $game_result['home']['player']['field']['rw_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['home']['player']['field']['rw_3']['player_id'];
        }
    }

    return $game_result;
}

function f_igosja_guest_player_assist_2_increase($game_result)
{
    $count_event = count($game_result['event']);

    if (POSITION_GK == $game_result['assist_2'])
    {
        $game_result['guest']['player']['gk']['assist']++;
        $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
            $game_result['guest']['player']['gk']['player_id'];
    }
    elseif (POSITION_LD == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['ld_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['ld_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['ld_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['ld_3']['player_id'];
        }
    }
    elseif (POSITION_RD == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['rd_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['rd_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['rd_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['rd_3']['player_id'];
        }
    }
    elseif (POSITION_LW == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lw_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['lw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lw_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['lw_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['lw_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['lw_3']['player_id'];
        }
    }
    elseif (POSITION_C == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['c_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['c_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['c_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['c_3']['player_id'];
        }
    }
    elseif (POSITION_RW == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rw_1']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['rw_1']['player_id'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rw_2']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['rw_2']['player_id'];
        }
        else
        {
            $game_result['guest']['player']['field']['rw_3']['assist']++;
            $game_result['event'][$count_event - 1]['event_player_assist_2_id'] =
                $game_result['guest']['player']['field']['rw_3']['player_id'];
        }
    }

    return $game_result;
}

function f_igosja_home_select_player_shot($game_result)
{
    $game_result['player'] = rand(POSITION_LD, POSITION_RW);

    $penalty_position = array();

    $count_penalty = count($game_result['home']['team']['penalty']['current']);

    if (2 < $count_penalty)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position[] = $game_result['home']['team']['penalty']['current'][$i]['position'];
    }

    if (in_array($game_result['player'], $penalty_position))
    {
        $game_result = f_igosja_home_select_player_shot($game_result);
    }

    return $game_result;
}

function f_igosja_guest_select_player_shot($game_result)
{
    $game_result['player'] = rand(POSITION_LD, POSITION_RW);

    $penalty_position = array();

    $count_penalty = count($game_result['guest']['team']['penalty']['current']);

    if (2 < $count_penalty)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position[] = $game_result['guest']['team']['penalty']['current'][$i]['position'];
    }

    if (in_array($game_result['player'], $penalty_position))
    {
        $game_result = f_igosja_home_select_player_shot($game_result);
    }

    return $game_result;
}

function f_igosja_home_assist_1($game_result)
{
    if (rand(0, 3))
    {
        $game_result = f_igosja_home_select_assist_1($game_result);
    }
    else
    {
        $game_result['assist_1'] = 0;
    }

    return $game_result;
}

function f_igosja_home_select_assist_1($game_result)
{
    $game_result['assist_1'] = rand(POSITION_LD, POSITION_RW);

    if ($game_result['player'] == $game_result['assist_1'])
    {
        $game_result = f_igosja_home_select_assist_1($game_result);
    }

    $penalty_position = array();

    $count_penalty = count($game_result['home']['team']['penalty']['current']);

    if (2 < $count_penalty)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position[] = $game_result['home']['team']['penalty']['current'][$i]['position'];
    }

    if (in_array($game_result['assist_1'], $penalty_position))
    {
        $game_result = f_igosja_home_select_assist_1($game_result);
    }

    return $game_result;
}

function f_igosja_home_assist_2($game_result)
{
    if (0 == rand(0, 4))
    {
        $game_result = f_igosja_home_select_assist_2($game_result);
    }
    else
    {
        $game_result['assist_2'] = 0;
    }

    return $game_result;
}

function f_igosja_home_select_assist_2($game_result)
{
    $game_result['assist_2'] = rand(POSITION_GK, POSITION_RW);

    if ($game_result['player'] == $game_result['assist_2'])
    {
        $game_result = f_igosja_home_select_assist_2($game_result);
    }

    $penalty_position = array();

    $count_penalty = count($game_result['home']['team']['penalty']['current']);

    if (2 < $count_penalty)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position[] = $game_result['home']['team']['penalty']['current'][$i]['position'];
    }

    if (in_array($game_result['assist_2'], $penalty_position))
    {
        $game_result = f_igosja_home_select_assist_2($game_result);
    }

    return $game_result;
}

function f_igosja_guest_assist_1($game_result)
{
    if (rand(0, 3))
    {
        $game_result = f_igosja_guest_select_assist_1($game_result);
    }
    else
    {
        $game_result['assist_1'] = 0;
    }

    return $game_result;
}

function f_igosja_guest_select_assist_1($game_result)
{
    $game_result['assist_1'] = rand(POSITION_LD, POSITION_RW);

    if ($game_result['player'] == $game_result['assist_1'])
    {
        $game_result = f_igosja_guest_select_assist_1($game_result);
    }

    $penalty_position = array();

    $count_penalty = count($game_result['guest']['team']['penalty']['current']);

    if (2 < $count_penalty)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position[] = $game_result['guest']['team']['penalty']['current'][$i]['position'];
    }

    if (in_array($game_result['assist_1'], $penalty_position))
    {
        $game_result = f_igosja_guest_select_assist_1($game_result);
    }

    return $game_result;
}

function f_igosja_guest_assist_2($game_result)
{
    if (0 == rand(0, 4))
    {
        $game_result = f_igosja_guest_select_assist_2($game_result);
    }
    else
    {
        $game_result['assist_2'] = 0;
    }

    return $game_result;
}

function f_igosja_guest_select_assist_2($game_result)
{
    $game_result['assist_2'] = rand(POSITION_GK, POSITION_RW);

    if ($game_result['player'] == $game_result['assist_2'])
    {
        $game_result = f_igosja_guest_select_assist_2($game_result);
    }

    $penalty_position = array();

    $count_penalty = count($game_result['guest']['team']['penalty']['current']);

    if (2 < $count_penalty)
    {
        $count_penalty = 2;
    }

    for ($i=0; $i<$count_penalty; $i++)
    {
        $penalty_position[] = $game_result['guest']['team']['penalty']['current'][$i]['position'];
    }

    if (in_array($game_result['assist_2'], $penalty_position))
    {
        $game_result = f_igosja_guest_select_assist_2($game_result);
    }

    return $game_result;
}

function f_igosja_event_home_penalty($game_result)
{
    $sql = "SELECT `eventtextpenalty_id`
            FROM `eventtextpenalty`
            ORDER BY RAND()
            LIMIT 1";
    $eventtextpenalty_sql = f_igosja_mysqli_query($sql);

    $eventtextpenalty_array = $eventtextpenalty_sql->fetch_all(1);

    $game_result['event'][] = array(
        'event_eventtextbullet_id' => 0,
        'event_eventtextgoal_id' => 0,
        'event_eventtextpenalty_id' => $eventtextpenalty_array[0]['eventtextpenalty_id'],
        'event_eventtype_id' => EVENTTYPE_PENALTY,
        'event_game_id' => $game_result['game_info']['game_id'],
        'event_guest_score' => $game_result['guest']['team']['score']['total'],
        'event_home_score' => $game_result['home']['team']['score']['total'],
        'event_minute' => $game_result['minute'],
        'event_player_assist_1_id' => 0,
        'event_player_assist_2_id' => 0,
        'event_player_score_id' => 0,
        'event_player_penalty_id' => 0,
        'event_second' => rand(0, 14),
        'event_team_id' => $game_result['game_info']['home_team_id'],
    );

    return $game_result;
}

function f_igosja_event_guest_penalty($game_result)
{
    $sql = "SELECT `eventtextpenalty_id`
            FROM `eventtextpenalty`
            ORDER BY RAND()
            LIMIT 1";
    $eventtextpenalty_sql = f_igosja_mysqli_query($sql);

    $eventtextpenalty_array = $eventtextpenalty_sql->fetch_all(1);

    $game_result['event'][] = array(
        'event_eventtextbullet_id' => 0,
        'event_eventtextgoal_id' => 0,
        'event_eventtextpenalty_id' => $eventtextpenalty_array[0]['eventtextpenalty_id'],
        'event_eventtype_id' => EVENTTYPE_PENALTY,
        'event_game_id' => $game_result['game_info']['game_id'],
        'event_guest_score' => $game_result['guest']['team']['score']['total'],
        'event_home_score' => $game_result['home']['team']['score']['total'],
        'event_minute' => $game_result['minute'],
        'event_player_assist_1_id' => 0,
        'event_player_assist_2_id' => 0,
        'event_player_score_id' => 0,
        'event_player_penalty_id' => 0,
        'event_second' => rand(15, 29),
        'event_team_id' => $game_result['game_info']['guest_team_id'],
    );

    return $game_result;
}

function f_igosja_event_home_score($game_result)
{
    $sql = "SELECT `eventtextgoal_id`
            FROM `eventtextgoal`
            ORDER BY RAND()
            LIMIT 1";
    $eventtextgoal_sql = f_igosja_mysqli_query($sql);

    $eventtextgoal_array = $eventtextgoal_sql->fetch_all(1);

    $game_result['event'][] = array(
        'event_eventtextbullet_id' => 0,
        'event_eventtextgoal_id' => $eventtextgoal_array[0]['eventtextgoal_id'],
        'event_eventtextpenalty_id' => 0,
        'event_eventtype_id' => EVENTTYPE_GOAL,
        'event_game_id' => $game_result['game_info']['game_id'],
        'event_guest_score' => $game_result['guest']['team']['score']['total'],
        'event_home_score' => $game_result['home']['team']['score']['total'],
        'event_minute' => $game_result['minute'],
        'event_player_assist_1_id' => 0,
        'event_player_assist_2_id' => 0,
        'event_player_score_id' => 0,
        'event_player_penalty_id' => 0,
        'event_second' => rand(30, 44),
        'event_team_id' => $game_result['game_info']['home_team_id'],
    );

    return $game_result;
}

function f_igosja_event_guest_score($game_result)
{
    $sql = "SELECT `eventtextgoal_id`
            FROM `eventtextgoal`
            ORDER BY RAND()
            LIMIT 1";
    $eventtextgoal_sql = f_igosja_mysqli_query($sql);

    $eventtextgoal_array = $eventtextgoal_sql->fetch_all(1);

    $game_result['event'][] = array(
        'event_eventtextbullet_id' => 0,
        'event_eventtextgoal_id' => $eventtextgoal_array[0]['eventtextgoal_id'],
        'event_eventtextpenalty_id' => 0,
        'event_eventtype_id' => EVENTTYPE_GOAL,
        'event_game_id' => $game_result['game_info']['game_id'],
        'event_guest_score' => $game_result['guest']['team']['score']['total'],
        'event_home_score' => $game_result['home']['team']['score']['total'],
        'event_minute' => $game_result['minute'],
        'event_player_assist_1_id' => 0,
        'event_player_assist_2_id' => 0,
        'event_player_score_id' => 0,
        'event_player_penalty_id' => 0,
        'event_second' => rand(45, 59),
        'event_team_id' => $game_result['game_info']['guest_team_id'],
    );

    return $game_result;
}

function f_igosja_home_current_penalty_decrease($game_result)
{
    $penalty_array_old = $game_result['home']['team']['penalty']['current'];
    $penalty_array_new = array();

    $count_penalty = count($penalty_array_old);

    for ($i=0; $i<$count_penalty; $i++)
    {
        if (0 == $i)
        {
            if ($game_result['minute'] < $penalty_array_old[$i]['minute'] + 2)
            {
                $penalty_array_new[] = $penalty_array_old[$i];
            }
        }
        elseif (1 < $i)
        {
            $penalty_array_new[] = array(
                'minute' => $game_result['minute'],
                'position' => $penalty_array_old[$i]['position'],
            );
        }
        else
        {
            $penalty_array_new[] = $penalty_array_old[$i];
        }
    }

    $game_result['home']['team']['penalty']['current'] = $penalty_array_new;

    return $game_result;
}

function f_igosja_guest_current_penalty_decrease($game_result)
{
    $penalty_array_old = $game_result['guest']['team']['penalty']['current'];
    $penalty_array_new = array();

    $count_penalty = count($penalty_array_old);

    for ($i=0; $i<$count_penalty; $i++)
    {
        if (0 == $i)
        {
            if ($game_result['minute'] < $penalty_array_old[$i]['minute'] + 2)
            {
                $penalty_array_new[] = $penalty_array_old[$i];
            }
        }
        elseif (1 < $i)
        {
            $penalty_array_new[] = array(
                'minute' => $game_result['minute'],
                'position' => $penalty_array_old[$i]['position'],
            );
        }
        else
        {
            $penalty_array_new[] = $penalty_array_old[$i];
        }
    }

    $game_result['guest']['team']['penalty']['current'] = $penalty_array_new;

    return $game_result;
}

function f_igosja_home_current_penalty_decrease_after_goal($game_result)
{
    if (count($game_result['guest']['team']['penalty']['current']) > count($game_result['home']['team']['penalty']['current']) && 2 > count($game_result['home']['team']['penalty']['current']))
    {
        $penalty_array_old = $game_result['home']['team']['penalty']['current'];
        $penalty_array_new = array();

        $count_penalty = count($penalty_array_old);

        for ($i=0; $i<$count_penalty; $i++)
        {
            if (1 < $i)
            {
                $penalty_array_new[] = array(
                    'minute' => $game_result['minute'],
                    'position' => $penalty_array_old[$i]['position'],
                );
            }
            elseif (0 != $i)
            {
                $penalty_array_new[] = $penalty_array_old[$i];
            }
        }

        $game_result['home']['team']['penalty']['current'] = $penalty_array_new;
    }

    return $game_result;
}

function f_igosja_guest_current_penalty_decrease_after_goal($game_result)
{
    if (count($game_result['home']['team']['penalty']['current']) > count($game_result['guest']['team']['penalty']['current']) && 2 > count($game_result['guest']['team']['penalty']['current']))
    {
        $penalty_array_old = $game_result['guest']['team']['penalty']['current'];
        $penalty_array_new = array();

        $count_penalty = count($penalty_array_old);

        for ($i=0; $i<$count_penalty; $i++)
        {
            if (0 == $i)
            {
                if ($game_result['minute'] < $penalty_array_old[$i]['minute'] + 2)
                {
                    $penalty_array_new[] = $penalty_array_old[$i];
                }
            }
            elseif (1 < $i)
            {
                $penalty_array_new[] = array(
                    'minute' => $game_result['minute'],
                    'position' => $penalty_array_old[$i]['position'],
                );
            }
            elseif (0 != $i)
            {
                $penalty_array_new[] = $penalty_array_old[$i];
            }
        }

        $game_result['guest']['team']['penalty']['current'] = $penalty_array_new;
    }

    return $game_result;
}