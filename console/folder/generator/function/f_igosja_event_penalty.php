<?php

function f_igosja_event_penalty($game_result, $team, $opponent)
{
    $sql = "SELECT `eventtextpenalty_id`
            FROM `eventtextpenalty`
            ORDER BY RAND()
            LIMIT 1";
    $eventtextpenalty_sql = f_igosja_mysqli_query($sql);

    $eventtextpenalty_array = $eventtextpenalty_sql->fetch_all(1);

    if ('home' == $team)
    {
        $second = rand(0, 14);
    }
    else
    {
        $second = rand(15, 29);
    }

    $game_result['event'][] = array(
        'event_eventtextbullet_id' => 0,
        'event_eventtextgoal_id' => 0,
        'event_eventtextpenalty_id' => $eventtextpenalty_array[0]['eventtextpenalty_id'],
        'event_eventtype_id' => EVENTTYPE_PENALTY,
        'event_game_id' => $game_result['game_info']['game_id'],
        'event_guest_score' => $game_result[$opponent]['team']['score']['total'],
        'event_home_score' => $game_result[$team]['team']['score']['total'],
        'event_minute' => $game_result['minute'],
        'event_player_assist_1_id' => 0,
        'event_player_assist_2_id' => 0,
        'event_player_score_id' => 0,
        'event_player_penalty_id' => 0,
        'event_second' => $second,
        'event_team_id' => $game_result['game_info'][$team . '_team_id'],
    );

    return $game_result;
}