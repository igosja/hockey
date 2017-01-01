<?php

function f_igosja_event_bullet($game_result, $team, $eventtextbullet_id, $player_key)
{
    $game_result['event'][] = array(
        'event_eventtextbullet_id' => $eventtextbullet_id,
        'event_eventtextgoal_id' => 0,
        'event_eventtextpenalty_id' => 0,
        'event_eventtype_id' => EVENTTYPE_BULLET,
        'event_game_id' => $game_result['game_info']['game_id'],
        'event_guest_score' => $game_result['guest']['team']['score']['total'],
        'event_home_score' => $game_result['home']['team']['score']['total'],
        'event_minute' => $game_result['minute'],
        'event_player_assist_1_id' => 0,
        'event_player_assist_2_id' => 0,
        'event_player_score_id' => $game_result[$team]['player']['field'][$player_key]['player_id'],
        'event_player_penalty_id' => 0,
        'event_second' => 0,
        'event_team_id' => $game_result['game_info'][$team . '_team_id'],
    );

    return $game_result;
}