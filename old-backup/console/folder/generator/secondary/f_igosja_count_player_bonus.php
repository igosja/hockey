<?php

/**
 * Рахуємо бонус хокеїстів за їх спецможливості залежно від стилю гри
 * @param $game_result array
 * @return array
 */
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

        $playerspecial_array = $playerspesial_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($playerspecial_array as $item)
        {
            if (SPECIAL_SPEED == $item['playerspecial_special_id'])
            {
                if (in_array(STYLE_SPEED, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 10 * $item['playerspecial_level'];
                }
                elseif (in_array(STYLE_TECHNIQUE, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 4 * $item['playerspecial_level'];
                }
                else
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 5 * $item['playerspecial_level'];
                }
            }
            elseif (SPECIAL_POWER == $item['playerspecial_special_id'])
            {
                if (in_array(STYLE_POWER, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 10 * $item['playerspecial_level'];
                }
                elseif (in_array(STYLE_SPEED, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 4 * $item['playerspecial_level'];
                }
                else
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 5 * $item['playerspecial_level'];
                }
            }
            elseif (SPECIAL_COMBINE == $item['playerspecial_special_id'])
            {
                if (in_array(STYLE_TECHNIQUE, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 10 * $item['playerspecial_level'];
                }
                elseif (in_array(STYLE_POWER, array($game_result[$team]['team']['style'][1], $game_result[$team]['team']['style'][2], $game_result[$team]['team']['style'][3])))
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 4 * $item['playerspecial_level'];
                }
                else
                {
                    $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 5 * $item['playerspecial_level'];
                }
            }
            elseif (SPECIAL_TACKLE == $item['playerspecial_special_id'])
            {
                $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 5 * $item['playerspecial_level'];
            }
            elseif (SPECIAL_REACTION == $item['playerspecial_special_id'])
            {
                $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 5 * $item['playerspecial_level'];
            }
            elseif (SPECIAL_SHOT == $item['playerspecial_special_id'])
            {
                $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 5 * $item['playerspecial_level'];
            }
            elseif (SPECIAL_STICK == $item['playerspecial_special_id'])
            {
                $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 4 * $item['playerspecial_level'];
            }
            elseif (SPECIAL_POSITION == $item['playerspecial_special_id'])
            {
                $game_result[$team]['player']['gk']['bonus'] = $game_result[$team]['player']['gk']['bonus'] + 5 * $item['playerspecial_level'];
            }
            elseif (SPECIAL_LEADER == $item['playerspecial_special_id'])
            {
                $game_result[$team]['team']['leader'] = $game_result[$team]['team']['leader'] + $item['playerspecial_level'];
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

                if ($game_result[$team]['team']['style'][$line] == $game_result[$team]['player']['field'][$key]['style'])
                {
                    $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 5;
                }

                $player_id = $game_result[$team]['player']['field'][$key]['player_id'];

                $sql = "SELECT `playerspecial_level`,
                               `playerspecial_special_id`
                        FROM `playerspecial`
                        WHERE `playerspecial_player_id`=$player_id";
                $playerspesial_sql = f_igosja_mysqli_query($sql);

                $playerspecial_array = $playerspesial_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($playerspecial_array as $item)
                {
                    if (SPECIAL_SPEED == $item['playerspecial_special_id'])
                    {
                        if (STYLE_SPEED == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 10 * $item['playerspecial_level'];
                        }
                        elseif (STYLE_TECHNIQUE == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 4 * $item['playerspecial_level'];
                        }
                        else
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 5 * $item['playerspecial_level'];
                        }
                    }
                    elseif (SPECIAL_POWER == $item['playerspecial_special_id'])
                    {
                        if (STYLE_POWER == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 10 * $item['playerspecial_level'];
                        }
                        elseif (STYLE_SPEED == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 4 * $item['playerspecial_level'];
                        }
                        else
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 5 * $item['playerspecial_level'];
                        }
                    }
                    elseif (SPECIAL_COMBINE == $item['playerspecial_special_id'])
                    {
                        if (STYLE_TECHNIQUE == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 10 * $item['playerspecial_level'];
                        }
                        elseif (STYLE_POWER == $game_result[$team]['team']['style'][$line])
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 4 * $item['playerspecial_level'];
                        }
                        else
                        {
                            $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 5 * $item['playerspecial_level'];
                        }
                    }
                    elseif (SPECIAL_TACKLE == $item['playerspecial_special_id'])
                    {
                        $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 5 * $item['playerspecial_level'];
                    }
                    elseif (SPECIAL_REACTION == $item['playerspecial_special_id'])
                    {
                        $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 5 * $item['playerspecial_level'];
                    }
                    elseif (SPECIAL_SHOT == $item['playerspecial_special_id'])
                    {
                        $game_result[$team]['player']['field'][$key]['bonus'] = $game_result[$team]['player']['field'][$key]['bonus'] + 5 * $item['playerspecial_level'];
                    }
                    elseif (SPECIAL_LEADER == $item['playerspecial_special_id'])
                    {
                        $game_result[$team]['team']['leader'] = $game_result[$team]['team']['leader'] + $item['playerspecial_level'];
                    }
                }
            }
        }
    }

    return $game_result;
}