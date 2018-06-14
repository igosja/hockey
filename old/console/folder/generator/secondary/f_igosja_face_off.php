<?php

/**
 * Рахуємо переможця вкидання шайби
 * @param $game_result array
 * @return array
 */
function f_igosja_face_off($game_result)
{
    $game_result = f_igosja_select_face_off($game_result, 'home');
    $game_result = f_igosja_select_face_off($game_result, 'guest');
    $game_result = f_igosja_player_face_off_increase($game_result, 'home');
    $game_result = f_igosja_player_face_off_increase($game_result, 'guest');
    $game_result = f_igosja_player_face_off_power($game_result, 'home');
    $game_result = f_igosja_player_face_off_power($game_result, 'guest');

    if (rand(0, $game_result['home']['team']['power']['face_off']) >= rand(0, $game_result['guest']['team']['power']['face_off']))
    {
        $game_result = f_igosja_player_face_off_win_increase($game_result, 'home');
    }
    else
    {
        $game_result = f_igosja_player_face_off_win_increase($game_result, 'guest');
    }

    return $game_result;
}