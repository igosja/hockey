<?php

/**
 * Підраховуємо статистику команд і гравців в массиві $game_result
 * @param $game_result array
 * @return array
 * */
function f_igosja_calculate_statistic($game_result)
{
    if ($game_result['home']['team']['score']['total'] == $game_result['guest']['team']['score']['total'])
    {
        if ($game_result['home']['team']['score']['bullet'] > $game_result['guest']['team']['score']['bullet'])
        {
            $game_result['home']['team']['win_bullet'] = 1;
            $game_result['guest']['team']['loose_bullet'] = 1;
            $game_result['home']['player']['field'][$game_result['home']['team']['score']['last']['bullet']]['bullet_win'] = 1;
            $win    = 'home';
            $loose  = 'guest';
        }
        else
        {
            $game_result['guest']['team']['win_bullet'] = 1;
            $game_result['home']['team']['loose_bullet'] = 1;
            $game_result['guest']['player']['field'][$game_result['guest']['team']['score']['last']['bullet']]['bullet_win'] = 1;
            $win    = 'guest';
            $loose  = 'home';
        }
    }
    elseif ($game_result['home']['team']['score']['total'] > $game_result['guest']['team']['score']['total'])
    {
        if (0 != $game_result['home']['team']['score']['over'])
        {
            $game_result['home']['team']['win_over'] = 1;
            $game_result['guest']['team']['loose_over'] = 1;
            $game_result['home']['player']['field'][$game_result['home']['team']['score']['last']['score']]['score_win'] = 1;
        }
        else
        {
            $game_result['home']['team']['win'] = 1;
            $game_result['guest']['team']['loose'] = 1;
            $game_result['home']['player']['field'][$game_result['home']['team']['score']['last']['score']]['score_win'] = 1;
        }

        $win    = 'home';
        $loose  = 'guest';
    }
    else
    {
        if (0 != $game_result['guest']['team']['score']['over'])
        {
            $game_result['guest']['team']['win_over'] = 1;
            $game_result['home']['team']['loose_over'] = 1;
            $game_result['guest']['player']['field'][$game_result['guest']['team']['score']['last']['score']]['score_win'] = 1;
        }
        else
        {
            $game_result['guest']['team']['win'] = 1;
            $game_result['home']['team']['loose'] = 1;
            $game_result['guest']['player']['field'][$game_result['guest']['team']['score']['last']['score']]['score_win'] = 1;
        }

        $loose  = 'home';
        $win    = 'guest';
    }

    $game_result[$win]['player']['gk']['win'] = 1;

    for ($j=1; $j<=3; $j++)
    {
        for ($k=POSITION_LD; $k<=POSITION_RW; $k++)
        {
            if     (POSITION_LD == $k) { $key = 'ld'; }
            elseif (POSITION_RD == $k) { $key = 'rd'; }
            elseif (POSITION_LW == $k) { $key = 'lw'; }
            elseif (POSITION_C  == $k) { $key =  'c'; }
            else                       { $key = 'rw'; }

            $key = $key . '_' . $j;

            $game_result[$win]['player']['field'][$key]['win'] = 1;
        }
    }

    $game_result[$loose]['player']['gk']['loose'] = 1;

    for ($j=1; $j<=3; $j++)
    {
        for ($k=POSITION_LD; $k<=POSITION_RW; $k++)
        {
            if     (POSITION_LD == $k) { $key = 'ld'; }
            elseif (POSITION_RD == $k) { $key = 'rd'; }
            elseif (POSITION_LW == $k) { $key = 'lw'; }
            elseif (POSITION_C  == $k) { $key =  'c'; }
            else                       { $key = 'rw'; }

            $key = $key . '_' . $j;

            $game_result[$loose]['player']['field'][$key]['loose'] = 1;
        }
    }

    $game_result['home']['player']['gk']['point']   = $game_result['home']['player']['gk']['assist'];
    $game_result['guest']['player']['gk']['point']  = $game_result['guest']['player']['gk']['assist'];

    for ($j=1; $j<=3; $j++)
    {
        for ($k=POSITION_LD; $k<=POSITION_RW; $k++)
        {
            if     (POSITION_LD == $k) { $key = 'ld'; }
            elseif (POSITION_RD == $k) { $key = 'rd'; }
            elseif (POSITION_LW == $k) { $key = 'lw'; }
            elseif (POSITION_C  == $k) { $key =  'c'; }
            else                       { $key = 'rw'; }

            $key = $key . '_' . $j;

            $game_result['home']['player']['field'][$key]['point'] =
                $game_result['home']['player']['field'][$key]['assist'] +
                $game_result['home']['player']['field'][$key]['score'];

            $game_result['guest']['player']['field'][$key]['point'] =
                $game_result['guest']['player']['field'][$key]['assist'] +
                $game_result['guest']['player']['field'][$key]['score'];
        }
    }

    $game_result['home']['player']['gk']['save'] =
        $game_result['home']['player']['gk']['shot'] -
        $game_result['home']['player']['gk']['pass'];

    $game_result['guest']['player']['gk']['save'] =
        $game_result['guest']['player']['gk']['shot'] -
        $game_result['guest']['player']['gk']['pass'];

    if (0 == $game_result['home']['team']['score']['total'])
    {
        $game_result['guest']['player']['gk']['shutout'] = 1;
        $game_result['guest']['team']['no_pass'] = 1;
        $game_result['home']['team']['no_score'] = 1;
    }

    if (0 == $game_result['guest']['team']['score']['total'])
    {
        $game_result['home']['player']['gk']['shutout'] = 1;
        $game_result['home']['team']['no_pass'] = 1;
        $game_result['guest']['team']['no_score'] = 1;
    }

    $game_result['guest']['team']['penalty']['opponent']    = $game_result['home']['team']['penalty']['total'];
    $game_result['home']['team']['penalty']['opponent']     = $game_result['guest']['team']['penalty']['total'];
    $game_result['guest']['team']['pass']                   = $game_result['home']['team']['score']['total'];
    $game_result['home']['team']['pass']                    = $game_result['guest']['team']['score']['total'];

    return $game_result;
}