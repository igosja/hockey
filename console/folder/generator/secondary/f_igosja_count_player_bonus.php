<?php

function f_igosja_count_player_bonus($game_result)
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

        $player_id = $game_result[$team]['player']['gk']['player_id'];

        $sql = "SELECT `playerspecial_level`,
                       `playerspecial_special_id`
                FROM `playerspecial`
                WHERE `playerspecial_player_id`=$player_id";
        $playerspesial_sql = f_igosja_mysqli_query($sql);

        $playerspecial_array = $playerspesial_sql->fetch_all(1);

        foreach ($playerspecial_array as $item)
        {
            if (SPECIAL_SPEED == $item['playerspecial_special_id'])
            {
                if (in_array(STYLE_SPEED, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 10 * $item['playerspecial_level']) / 100;
                }
                elseif (in_array(STYLE_TECHNIQUE, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 4 * $item['playerspecial_level']) / 100;
                }
                else
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
                }
            }
            elseif (SPECIAL_POWER == $item['playerspecial_special_id'])
            {
                if (in_array(STYLE_POWER, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 10 * $item['playerspecial_level']) / 100;
                }
                elseif (in_array(STYLE_SPEED, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 4 * $item['playerspecial_level']) / 100;
                }
                else
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
                }
            }
            elseif (SPECIAL_COMBINE == $item['playerspecial_special_id'])
            {
                if (in_array(STYLE_TECHNIQUE, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 10 * $item['playerspecial_level']) / 100;
                }
                elseif (in_array(STYLE_POWER, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 4 * $item['playerspecial_level']) / 100;
                }
                else
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
                }
            }
            elseif (SPECIAL_TACKLE == $item['playerspecial_special_id'])
            {
                $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
            }
            elseif (SPECIAL_REACTION == $item['playerspecial_special_id'])
            {
                $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
            }
            elseif (SPECIAL_SHOT == $item['playerspecial_special_id'])
            {
                $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
            }
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

                $player_id = $game_result[$team]['player']['field'][$key]['player_id'];

                $sql = "SELECT `playerspecial_level`,
                               `playerspecial_special_id`
                        FROM `playerspecial`
                        WHERE `playerspecial_player_id`=$player_id";
                $playerspesial_sql = f_igosja_mysqli_query($sql);

                $playerspecial_array = $playerspesial_sql->fetch_all(1);

                foreach ($playerspecial_array as $item)
                {
                    if (SPECIAL_SPEED == $item['playerspecial_special_id'])
                    {
                        if (STYLE_SPEED == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 10 * $item['playerspecial_level']) / 100;
                        }
                        elseif (STYLE_TECHNIQUE == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 4 * $item['playerspecial_level']) / 100;
                        }
                        else
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
                        }
                    }
                    elseif (SPECIAL_POWER == $item['playerspecial_special_id'])
                    {
                        if (STYLE_POWER == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 10 * $item['playerspecial_level']) / 100;
                        }
                        elseif (STYLE_SPEED == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 4 * $item['playerspecial_level']) / 100;
                        }
                        else
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
                        }
                    }
                    elseif (SPECIAL_COMBINE == $item['playerspecial_special_id'])
                    {
                        if (STYLE_TECHNIQUE == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 10 * $item['playerspecial_level']) / 100;
                        }
                        elseif (STYLE_POWER == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 4 * $item['playerspecial_level']) / 100;
                        }
                        else
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
                        }
                    }
                    elseif (SPECIAL_TACKLE == $item['playerspecial_special_id'])
                    {
                        $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
                    }
                    elseif (SPECIAL_REACTION == $item['playerspecial_special_id'])
                    {
                        $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
                    }
                    elseif (SPECIAL_SHOT == $item['playerspecial_special_id'])
                    {
                        $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
                    }
                }
            }
        }
    }

    return $game_result;
}