<?php

function f_igosja_get_player_info($game_result, $team)
{
    if ('home' == $team)
    {
        $home_bonus = $game_result['game_info']['home_bonus'];
    }
    else
    {
        $home_bonus = 1;
    }

    $sql = "SELECT `lineup_id`,
                   `player_age`,
                   `player_id`,
                   `player_power_nominal`,
                   `player_power_real`
            FROM `lineup`
            LEFT JOIN `player`
            ON `lineup_player_id`=`player_id`
            WHERE `lineup_game_id`='" . $game_result['game_info']['game_id'] . "'
            AND `lineup_team_id`='" . $game_result['game_info'][$team . '_team_id'] . "'
            ORDER BY `lineup_line_id` ASC, `lineup_position_id` ASC";
    $lineup_sql = f_igosja_mysqli_query($sql);

    $lineup_array = $lineup_sql->fetch_all(1);

    $game_result[$team]['player']['gk']['age']            = $lineup_array[0]['player_age'];
    $game_result[$team]['player']['gk']['lineup_id']      = $lineup_array[0]['lineup_id'];
    $game_result[$team]['player']['gk']['player_id']      = $lineup_array[0]['player_id'];
    $game_result[$team]['player']['gk']['power_nominal']  = $lineup_array[0]['player_power_nominal'];
    $game_result[$team]['player']['gk']['power_real']     = round($lineup_array[0]['player_power_real'] * $home_bonus, 0);

    for ($j=1; $j<=15; $j++)
    {
        if     ( 1 == $j) { $key = 'ld_1'; }
        elseif ( 2 == $j) { $key = 'rd_1'; }
        elseif ( 3 == $j) { $key = 'lw_1'; }
        elseif ( 4 == $j) { $key =  'c_1'; }
        elseif ( 5 == $j) { $key = 'rw_1'; }
        elseif ( 6 == $j) { $key = 'ld_2'; }
        elseif ( 7 == $j) { $key = 'rd_2'; }
        elseif ( 8 == $j) { $key = 'lw_2'; }
        elseif ( 9 == $j) { $key =  'c_2'; }
        elseif (10 == $j) { $key = 'rw_2'; }
        elseif (11 == $j) { $key = 'ld_3'; }
        elseif (12 == $j) { $key = 'rd_3'; }
        elseif (13 == $j) { $key = 'lw_3'; }
        elseif (14 == $j) { $key =  'c_3'; }
        else              { $key = 'rw_3'; }

        $game_result[$team]['player']['field'][$key]['age']           = $lineup_array[$j]['player_age'];
        $game_result[$team]['player']['field'][$key]['lineup_id']     = $lineup_array[$j]['lineup_id'];
        $game_result[$team]['player']['field'][$key]['player_id']     = $lineup_array[$j]['player_id'];
        $game_result[$team]['player']['field'][$key]['power_nominal'] = $lineup_array[$j]['player_power_nominal'];
        $game_result[$team]['player']['field'][$key]['power_real']    = round($lineup_array[$j]['player_power_real'] * $home_bonus, 0);
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
        = $game_result[$team]['player']['field']['lw_2']['power_real']
        + $game_result[$team]['player']['field']['c_2']['power_real']
        + $game_result[$team]['player']['field']['rw_2']['power_real'];
    $game_result[$team]['team']['power']['total']
        = $game_result[$team]['team']['power']['gk']
        + $game_result[$team]['team']['power']['defence'][1]
        + $game_result[$team]['team']['power']['defence'][2]
        + $game_result[$team]['team']['power']['defence'][3]
        + $game_result[$team]['team']['power']['forward'][1]
        + $game_result[$team]['team']['power']['forward'][2]
        + $game_result[$team]['team']['power']['forward'][3];

    return $game_result;
}