<?php

/**
 * Корегуємо сили хокеїстів на отпимальність позицій
 * @param $game_result array
 * @return array
 */
function f_igosja_get_player_real_power_from_optimal($game_result)
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

        $game_result[$team]['player']['gk']['power_real'] = $game_result[$team]['player']['gk']['power_optimal'];

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

                $player_id      = $game_result[$team]['player']['field'][$key]['player_id'];
                $player_power   = $game_result[$team]['player']['field'][$key]['power_optimal'];
                $position_array = array();

                $sql = "SELECT `playerposition_position_id`
                        FROM `playerposition`
                        WHERE `playerposition_player_id`=$player_id";
                $playerposition_sql = f_igosja_mysqli_query($sql);

                $playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

                foreach ($playerposition_array as $item)
                {
                    $position_array[] = $item['playerposition_position_id'];
                }

                $position_id = $k;

                if (POSITION_LD == $position_id)
                {
                    $position_coefficient = array(
                        POSITION_LD,
                        array(POSITION_RD, POSITION_LW)
                    );
                }
                elseif (POSITION_RD == $position_id)
                {
                    $position_coefficient = array(
                        POSITION_RD,
                        array(POSITION_LD, POSITION_RW)
                    );
                }
                elseif (POSITION_LW == $position_id)
                {
                    $position_coefficient = array(
                        POSITION_LW,
                        array(POSITION_LD, POSITION_C)
                    );
                }
                elseif (POSITION_C == $position_id)
                {
                    $position_coefficient = array(
                        POSITION_C,
                        array(POSITION_LW, POSITION_RW)
                    );
                }
                elseif (POSITION_RW == $position_id)
                {
                    $position_coefficient = array(
                        POSITION_RW,
                        array(POSITION_RD, POSITION_C)
                    );
                }
                else
                {
                    $position_coefficient = array(0, 0);
                }

                if (in_array($position_coefficient[0], $position_array))
                {
                    $power = $player_power;
                }
                elseif (in_array($position_coefficient[1][0], $position_array) || in_array($position_coefficient[1][1], $position_array))
                {
                    $power = round($player_power * 0.9);
                }
                else
                {
                    $power = round($player_power * 0.8);
                }

                $game_result[$team]['player']['field'][$key]['power_real'] = $power;
            }
        }
    }

    return $game_result;
}