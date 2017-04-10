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
    }

//    $player_id = $player_array['player_id'];
//
//    $sql = "SELECT `playerspecial_level`,
//                   `playerspecial_special_id`
//            FROM `playerspecial`
//            WHERE `playerspecial_player_id`=$player_id";
//    $playerspesial_sql = f_igosja_mysqli_query($sql);
//
//    $playerspecial_array = $playerspesial_sql->fetch_all(1);
//
//    foreach ($playerspecial_array as $item)
//    {
//        if (SPECIAL_SPEED == $item['playerspecial_special_id'])
//        {
//            if (STYLE_SPEED == $game_result['game_info'][$team . '_style_id'])
//            {
//                $player_array['bonus'] = $player_array['bonus'] * (100 + 10 * $item['playerspecial_level']) / 100;
//            }
//            elseif (STYLE_TECHNIQUE == $game_result['game_info'][$team . '_style_id'])
//            {
//                $player_array['bonus'] = $player_array['bonus'] * (100 + 4 * $item['playerspecial_level']) / 100;
//            }
//            else
//            {
//                $player_array['bonus'] = $player_array['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
//            }
//        }
//        elseif (SPECIAL_POWER == $item['playerspecial_special_id'])
//        {
//            if (STYLE_POWER == $game_result['game_info'][$team . '_style_id'])
//            {
//                $player_array['bonus'] = $player_array['bonus'] * (100 + 10 * $item['playerspecial_level']) / 100;
//            }
//            elseif (STYLE_SPEED == $game_result['game_info'][$team . '_style_id'])
//            {
//                $player_array['bonus'] = $player_array['bonus'] * (100 + 4 * $item['playerspecial_level']) / 100;
//            }
//            else
//            {
//                $player_array['bonus'] = $player_array['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
//            }
//        }
//        elseif (SPECIAL_COMBINE == $item['playerspecial_special_id'])
//        {
//            if (STYLE_TECHNIQUE == $game_result['game_info'][$team . '_style_id'])
//            {
//                $player_array['bonus'] = $player_array['bonus'] * (100 + 10 * $item['playerspecial_level']) / 100;
//            }
//            elseif (STYLE_POWER == $game_result['game_info'][$team . '_style_id'])
//            {
//                $player_array['bonus'] = $player_array['bonus'] * (100 + 4 * $item['playerspecial_level']) / 100;
//            }
//            else
//            {
//                $player_array['bonus'] = $player_array['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
//            }
//        }
//        elseif (SPECIAL_TACKLE == $item['playerspecial_special_id'])
//        {
//            $player_array['bonus'] = $player_array['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
//        }
//        elseif (SPECIAL_REACTION == $item['playerspecial_special_id'])
//        {
//            $player_array['bonus'] = $player_array['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
//        }
//        elseif (SPECIAL_SHOT == $item['playerspecial_special_id'])
//        {
//            $player_array['bonus'] = $player_array['bonus'] * (100 + 5 * $item['playerspecial_level']) / 100;
//        }
//    }

    return $player_array['bonus'];
}