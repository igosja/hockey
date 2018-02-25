<?php

/**
 * Записуємо дані про гол в події матчу
 * @param $game_result array
 * @param $team string home або guest
 * @return array
 */
function f_igosja_event_score($game_result, $team)
{
    $sql = "SELECT `eventtextgoal_id`
            FROM `eventtextgoal`
            ORDER BY RAND()
            LIMIT 1";
    $eventtextgoal_sql = f_igosja_mysqli_query($sql);

    $eventtextgoal_array = $eventtextgoal_sql->fetch_all(MYSQLI_ASSOC);

    if ('home' == $team)
    {
        $second = rand(30, 44);
    }
    else
    {
        $second = rand(45, 59);
    }

    $game_result['event'][] = array(
        'event_eventtextbullet_id' => 0,
        'event_eventtextgoal_id' => $eventtextgoal_array[0]['eventtextgoal_id'],
        'event_eventtextpenalty_id' => 0,
        'event_eventtype_id' => EVENTTYPE_GOAL,
        'event_game_id' => $game_result['game_info']['game_id'],
        'event_guest_score' => $game_result['guest']['team']['score']['total'],
        'event_home_score' => $game_result['home']['team']['score']['total'],
        'event_minute' => $game_result['minute'],
        'event_national_id' => $game_result['game_info'][$team . '_national_id'],
        'event_player_assist_1_id' => 0,
        'event_player_assist_2_id' => 0,
        'event_player_score_id' => 0,
        'event_player_penalty_id' => 0,
        'event_second' => $second,
        'event_team_id' => $game_result['game_info'][$team . '_team_id'],
    );

    return $game_result;
}