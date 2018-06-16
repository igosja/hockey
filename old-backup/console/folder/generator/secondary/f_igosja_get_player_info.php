<?php

/**
 * Отримуємо дані про хокеїстів з БД
 * @param $game_result array
 * @return array
 */
function f_igosja_get_player_info($game_result)
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

        $sql = "SELECT `lineup_id`,
                       `player_age`,
                       `player_id`,
                       `player_power_nominal`,
                       `player_power_real`,
                       `player_style_id`
                FROM `lineup`
                LEFT JOIN `player`
                ON `lineup_player_id`=`player_id`
                WHERE `lineup_game_id`=" . $game_result['game_info']['game_id'] . "
                AND `lineup_national_id`=" . $game_result['game_info'][$team . '_national_id'] . "
                AND `lineup_team_id`=" . $game_result['game_info'][$team . '_team_id'] . "
                ORDER BY `lineup_line_id` ASC, `lineup_position_id` ASC";
        $lineup_sql = f_igosja_mysqli_query($sql);

        $lineup_array = $lineup_sql->fetch_all(MYSQLI_ASSOC);

        $game_result[$team]['player']['gk']['age']              = $lineup_array[0]['player_age'];
        $game_result[$team]['player']['gk']['lineup_id']        = $lineup_array[0]['lineup_id'];
        $game_result[$team]['player']['gk']['player_id']        = $lineup_array[0]['player_id'];
        $game_result[$team]['player']['gk']['power_nominal']    = $lineup_array[0]['player_power_nominal'];

        if (TOURNAMENTTYPE_FRIENDLY == $game_result['game_info']['tournamenttype_id'])
        {
            $game_result[$team]['player']['gk']['power_optimal'] = round($lineup_array[0]['player_power_nominal'] * 0.75);
        }
        else
        {
            $game_result[$team]['player']['gk']['power_optimal'] = $lineup_array[0]['player_power_real'];
        }

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

            $game_result[$team]['player']['field'][$key]['age']             = $lineup_array[$j]['player_age'];
            $game_result[$team]['player']['field'][$key]['lineup_id']       = $lineup_array[$j]['lineup_id'];
            $game_result[$team]['player']['field'][$key]['player_id']       = $lineup_array[$j]['player_id'];
            $game_result[$team]['player']['field'][$key]['power_nominal']   = $lineup_array[$j]['player_power_nominal'];
            $game_result[$team]['player']['field'][$key]['style']           = $lineup_array[$j]['player_style_id'];

            if (TOURNAMENTTYPE_FRIENDLY == $game_result['game_info']['tournamenttype_id'])
            {
                $game_result[$team]['player']['field'][$key]['power_optimal'] = round($lineup_array[$j]['player_power_nominal'] * 0.75);
            }
            else
            {
                $game_result[$team]['player']['field'][$key]['power_optimal'] = $lineup_array[$j]['player_power_real'];
            }
        }
    }

    return $game_result;
}