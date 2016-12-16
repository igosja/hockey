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

function f_igosja_home_player_penalty_increase($game_result)
{
    if (1 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_1']['penalty']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_2']['penalty']++;
        }
        else
        {
            $game_result['home']['player']['field']['ld_3']['penalty']++;
        }
    }
    elseif (2 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_1']['penalty']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_2']['penalty']++;
        }
        else
        {
            $game_result['home']['player']['field']['rd_3']['penalty']++;
        }
    }
    elseif (3 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lf_1']['penalty']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lf_2']['penalty']++;
        }
        else
        {
            $game_result['home']['player']['field']['lf_3']['penalty']++;
        }
    }
    elseif (4 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_1']['penalty']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_2']['penalty']++;
        }
        else
        {
            $game_result['home']['player']['field']['c_3']['penalty']++;
        }
    }
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rf_1']['penalty']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rf_2']['penalty']++;
        }
        else
        {
            $game_result['home']['player']['field']['rf_3']['penalty']++;
        }
    }

    return $game_result;
}

function f_igosja_guest_player_penalty_increase($game_result)
{
    if (1 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_1']['penalty']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_2']['penalty']++;
        }
        else
        {
            $game_result['guest']['player']['field']['ld_3']['penalty']++;
        }
    }
    elseif (2 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_1']['penalty']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_2']['penalty']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rd_3']['penalty']++;
        }
    }
    elseif (3 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lf_1']['penalty']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lf_2']['penalty']++;
        }
        else
        {
            $game_result['guest']['player']['field']['lf_3']['penalty']++;
        }
    }
    elseif (4 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_1']['penalty']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_2']['penalty']++;
        }
        else
        {
            $game_result['guest']['player']['field']['c_3']['penalty']++;
        }
    }
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rf_1']['penalty']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rf_2']['penalty']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rf_3']['penalty']++;
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
    if (1 == $game_result['player'])
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
    elseif (2 == $game_result['player'])
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
    elseif (3 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lf_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lf_2']['shot']++;
        }
        else
        {
            $game_result['home']['player']['field']['lf_3']['shot']++;
        }
    }
    elseif (4 == $game_result['player'])
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
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rf_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rf_2']['shot']++;
        }
        else
        {
            $game_result['home']['player']['field']['rf_3']['shot']++;
        }
    }

    return $game_result;
}

function f_igosja_guest_player_shot_increase($game_result)
{
    if (1 == $game_result['player'])
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
    elseif (2 == $game_result['player'])
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
    elseif (3 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lf_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lf_2']['shot']++;
        }
        else
        {
            $game_result['guest']['player']['field']['lf_3']['shot']++;
        }
    }
    elseif (4 == $game_result['player'])
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
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rf_1']['shot']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rf_2']['shot']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rf_3']['shot']++;
        }
    }

    return $game_result;
}

function f_igosja_home_player_shot_power($game_result)
{
    if (1 == $game_result['player'])
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
    elseif (2 == $game_result['player'])
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
    elseif (3 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['lf_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['lf_2']['power_real'];
        }
        else
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['lf_3']['power_real'];
        }
    }
    elseif (4 == $game_result['player'])
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
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['rf_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['rf_2']['power_real'];
        }
        else
        {
            $game_result['home']['team']['power']['shot'] = $game_result['home']['player']['field']['rf_3']['power_real'];
        }
    }

    return $game_result;
}

function f_igosja_guest_player_shot_power($game_result)
{
    if (1 == $game_result['player'])
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
    elseif (2 == $game_result['player'])
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
    elseif (3 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['lf_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['lf_2']['power_real'];
        }
        else
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['lf_3']['power_real'];
        }
    }
    elseif (4 == $game_result['player'])
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
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['rf_1']['power_real'];
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['rf_2']['power_real'];
        }
        else
        {
            $game_result['guest']['team']['power']['shot'] = $game_result['guest']['player']['field']['rf_3']['power_real'];
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
    if (0 == $game_result['minute'] % 3)
    {
        $game_result['home']['player']['field']['ld_1']['plus_minus']++;
        $game_result['home']['player']['field']['rd_1']['plus_minus']++;
        $game_result['home']['player']['field']['lf_1']['plus_minus']++;
        $game_result['home']['player']['field']['c_1']['plus_minus']++;
        $game_result['home']['player']['field']['rf_1']['plus_minus']++;

        $game_result['guest']['player']['field']['ld_1']['plus_minus']--;
        $game_result['guest']['player']['field']['rd_1']['plus_minus']--;
        $game_result['guest']['player']['field']['lf_1']['plus_minus']--;
        $game_result['guest']['player']['field']['c_1']['plus_minus']--;
        $game_result['guest']['player']['field']['rf_1']['plus_minus']--;
    }
    elseif (1 == $game_result['minute'] % 3)
    {
        $game_result['home']['player']['field']['ld_2']['plus_minus']++;
        $game_result['home']['player']['field']['rd_2']['plus_minus']++;
        $game_result['home']['player']['field']['lf_2']['plus_minus']++;
        $game_result['home']['player']['field']['c_2']['plus_minus']++;
        $game_result['home']['player']['field']['rf_2']['plus_minus']++;

        $game_result['guest']['player']['field']['ld_2']['plus_minus']--;
        $game_result['guest']['player']['field']['rd_2']['plus_minus']--;
        $game_result['guest']['player']['field']['lf_2']['plus_minus']--;
        $game_result['guest']['player']['field']['c_2']['plus_minus']--;
        $game_result['guest']['player']['field']['rf_2']['plus_minus']--;
    }
    else
    {
        $game_result['home']['player']['field']['ld_3']['plus_minus']++;
        $game_result['home']['player']['field']['rd_3']['plus_minus']++;
        $game_result['home']['player']['field']['lf_3']['plus_minus']++;
        $game_result['home']['player']['field']['c_3']['plus_minus']++;
        $game_result['home']['player']['field']['rf_3']['plus_minus']++;

        $game_result['guest']['player']['field']['ld_3']['plus_minus']--;
        $game_result['guest']['player']['field']['rd_3']['plus_minus']--;
        $game_result['guest']['player']['field']['lf_3']['plus_minus']--;
        $game_result['guest']['player']['field']['c_3']['plus_minus']--;
        $game_result['guest']['player']['field']['rf_3']['plus_minus']--;
    }

    return $game_result;
}

function f_igosja_guest_plus_minus_increase($game_result)
{
    if (0 == $game_result['minute'] % 3)
    {
        $game_result['guest']['player']['field']['ld_1']['plus_minus']++;
        $game_result['guest']['player']['field']['rd_1']['plus_minus']++;
        $game_result['guest']['player']['field']['lf_1']['plus_minus']++;
        $game_result['guest']['player']['field']['c_1']['plus_minus']++;
        $game_result['guest']['player']['field']['rf_1']['plus_minus']++;

        $game_result['home']['player']['field']['ld_1']['plus_minus']--;
        $game_result['home']['player']['field']['rd_1']['plus_minus']--;
        $game_result['home']['player']['field']['lf_1']['plus_minus']--;
        $game_result['home']['player']['field']['c_1']['plus_minus']--;
        $game_result['home']['player']['field']['rf_1']['plus_minus']--;
    }
    elseif (1 == $game_result['minute'] % 3)
    {
        $game_result['guest']['player']['field']['ld_2']['plus_minus']++;
        $game_result['guest']['player']['field']['rd_2']['plus_minus']++;
        $game_result['guest']['player']['field']['lf_2']['plus_minus']++;
        $game_result['guest']['player']['field']['c_2']['plus_minus']++;
        $game_result['guest']['player']['field']['rf_2']['plus_minus']++;

        $game_result['home']['player']['field']['ld_2']['plus_minus']--;
        $game_result['home']['player']['field']['rd_2']['plus_minus']--;
        $game_result['home']['player']['field']['lf_2']['plus_minus']--;
        $game_result['home']['player']['field']['c_2']['plus_minus']--;
        $game_result['home']['player']['field']['rf_2']['plus_minus']--;
    }
    else
    {
        $game_result['guest']['player']['field']['ld_3']['plus_minus']++;
        $game_result['guest']['player']['field']['rd_3']['plus_minus']++;
        $game_result['guest']['player']['field']['lf_3']['plus_minus']++;
        $game_result['guest']['player']['field']['c_3']['plus_minus']++;
        $game_result['guest']['player']['field']['rf_3']['plus_minus']++;

        $game_result['home']['player']['field']['ld_3']['plus_minus']--;
        $game_result['home']['player']['field']['rd_3']['plus_minus']--;
        $game_result['home']['player']['field']['lf_3']['plus_minus']--;
        $game_result['home']['player']['field']['c_3']['plus_minus']--;
        $game_result['home']['player']['field']['rf_3']['plus_minus']--;
    }

    return $game_result;
}

function f_igosja_home_player_score_increase($game_result)
{
    if (1 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_1']['score']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_2']['score']++;
        }
        else
        {
            $game_result['home']['player']['field']['ld_3']['score']++;
        }
    }
    elseif (2 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_1']['score']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_2']['score']++;
        }
        else
        {
            $game_result['home']['player']['field']['rd_3']['score']++;
        }
    }
    elseif (3 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lf_1']['score']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lf_2']['score']++;
        }
        else
        {
            $game_result['home']['player']['field']['lf_3']['score']++;
        }
    }
    elseif (4 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_1']['score']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_2']['score']++;
        }
        else
        {
            $game_result['home']['player']['field']['c_3']['score']++;
        }
    }
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rf_1']['score']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rf_2']['score']++;
        }
        else
        {
            $game_result['home']['player']['field']['rf_3']['score']++;
        }
    }

    return $game_result;
}

function f_igosja_guest_player_score_increase($game_result)
{
    if (1 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_1']['score']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_2']['score']++;
        }
        else
        {
            $game_result['guest']['player']['field']['ld_3']['score']++;
        }
    }
    elseif (2 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_1']['score']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_2']['score']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rd_3']['score']++;
        }
    }
    elseif (3 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lf_1']['score']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lf_2']['score']++;
        }
        else
        {
            $game_result['guest']['player']['field']['lf_3']['score']++;
        }
    }
    elseif (4 == $game_result['player'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_1']['score']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_2']['score']++;
        }
        else
        {
            $game_result['guest']['player']['field']['c_3']['score']++;
        }
    }
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rf_1']['score']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rf_2']['score']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rf_3']['score']++;
        }
    }

    return $game_result;
}

function f_igosja_home_player_assist_1_increase($game_result)
{
    if (1 == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_2']['assist']++;
        }
        else
        {
            $game_result['home']['player']['field']['ld_3']['assist']++;
        }
    }
    elseif (2 == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_2']['assist']++;
        }
        else
        {
            $game_result['home']['player']['field']['rd_3']['assist']++;
        }
    }
    elseif (3 == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lf_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lf_2']['assist']++;
        }
        else
        {
            $game_result['home']['player']['field']['lf_3']['assist']++;
        }
    }
    elseif (4 == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_2']['assist']++;
        }
        else
        {
            $game_result['home']['player']['field']['c_3']['assist']++;
        }
    }
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rf_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rf_2']['assist']++;
        }
        else
        {
            $game_result['home']['player']['field']['rf_3']['assist']++;
        }
    }

    return $game_result;
}

function f_igosja_guest_player_assist_1_increase($game_result)
{
    if (1 == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_2']['assist']++;
        }
        else
        {
            $game_result['guest']['player']['field']['ld_3']['assist']++;
        }
    }
    elseif (2 == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_2']['assist']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rd_3']['assist']++;
        }
    }
    elseif (3 == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lf_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lf_2']['assist']++;
        }
        else
        {
            $game_result['guest']['player']['field']['lf_3']['assist']++;
        }
    }
    elseif (4 == $game_result['assist_1'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_2']['assist']++;
        }
        else
        {
            $game_result['guest']['player']['field']['c_3']['assist']++;
        }
    }
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rf_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rf_2']['assist']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rf_3']['assist']++;
        }
    }

    return $game_result;
}

function f_igosja_home_player_assist_2_increase($game_result)
{
    if (0 == $game_result['assist_2'])
    {
        $game_result['home']['player']['gk']['assist']++;
    }
    elseif (1 == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['ld_2']['assist']++;
        }
        else
        {
            $game_result['home']['player']['field']['ld_3']['assist']++;
        }
    }
    elseif (2 == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rd_2']['assist']++;
        }
        else
        {
            $game_result['home']['player']['field']['rd_3']['assist']++;
        }
    }
    elseif (3 == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lf_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['lf_2']['assist']++;
        }
        else
        {
            $game_result['home']['player']['field']['lf_3']['assist']++;
        }
    }
    elseif (4 == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['c_2']['assist']++;
        }
        else
        {
            $game_result['home']['player']['field']['c_3']['assist']++;
        }
    }
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rf_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['home']['player']['field']['rf_2']['assist']++;
        }
        else
        {
            $game_result['home']['player']['field']['rf_3']['assist']++;
        }
    }

    return $game_result;
}

function f_igosja_guest_player_assist_2_increase($game_result)
{
    if (0 == $game_result['assist_2'])
    {
        $game_result['guest']['player']['gk']['assist']++;
    }
    elseif (1 == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['ld_2']['assist']++;
        }
        else
        {
            $game_result['guest']['player']['field']['ld_3']['assist']++;
        }
    }
    elseif (2 == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rd_2']['assist']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rd_3']['assist']++;
        }
    }
    elseif (3 == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lf_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['lf_2']['assist']++;
        }
        else
        {
            $game_result['guest']['player']['field']['lf_3']['assist']++;
        }
    }
    elseif (4 == $game_result['assist_2'])
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['c_2']['assist']++;
        }
        else
        {
            $game_result['guest']['player']['field']['c_3']['assist']++;
        }
    }
    else
    {
        if (0 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rf_1']['assist']++;
        }
        elseif (1 == $game_result['minute'] % 3)
        {
            $game_result['guest']['player']['field']['rf_2']['assist']++;
        }
        else
        {
            $game_result['guest']['player']['field']['rf_3']['assist']++;
        }
    }

    return $game_result;
}

function f_igosja_generator_assist_1($game_result)
{
    $game_result['assist_1'] = rand(1, 5);

    if ($game_result['player'] == $game_result['assist_1'])
    {
        $game_result = f_igosja_generator_assist_1($game_result);
    }

    return $game_result;
}

function f_igosja_generator_assist_2($game_result)
{
    $game_result['assist_2'] = rand(0, 5);

    if (in_array($game_result['assist_2'], array($game_result['player'], $game_result['assist_1'])))
    {
        $game_result = f_igosja_generator_assist_2($game_result);
    }

    return $game_result;
}