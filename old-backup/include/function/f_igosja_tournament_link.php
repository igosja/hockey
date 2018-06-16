<?php

/**
 * Посилання на сторінку турніра на строрінці гри
 * @param $game_array array дані з БД по грі
 * @return string
 */

function f_igosja_game_tournament_link($game_array)
{
    if (TOURNAMENTTYPE_NATIONAL == $game_array[0]['tournamenttype_id'])
    {
        $result = '<a href="/worldcup.php?season_id=' . $game_array[0]['schedule_season_id'] . '&stage_id=' . $game_array[0]['stage_id'] . '">' . $game_array[0]['tournamenttype_name'] . ', ' . $game_array[0]['stage_name'] . '</a>';
    }
    elseif (TOURNAMENTTYPE_LEAGUE == $game_array[0]['tournamenttype_id'])
    {
        if ($game_array[0]['stage_id'] <= STAGE_6_TOUR)
        {
            $round_id = ROUND_GROUP;
        }
        elseif ($game_array[0]['stage_id'] <= STAGE_4_QUALIFY)
        {
            $round_id = ROUND_QUALIFICATION;
        }
        else
        {
            $round_id = ROUND_PLAYOFF;
        }

        $result = '<a href="/league.php?season_id=' . $game_array[0]['schedule_season_id'] . '&stage_id=' . $game_array[0]['stage_id'] . '&round_id=' . $round_id . '">' . $game_array[0]['tournamenttype_name'] . ', ' . $game_array[0]['stage_name'] . '</a>';
    }
    elseif (TOURNAMENTTYPE_CHAMPIONSHIP == $game_array[0]['tournamenttype_id'])
    {
        $result = '<a href="/championship.php?country_id=' . $game_array[0]['championship_country_id'] . '&division_id=' . $game_array[0]['championship_division_id'] . '&season_id=' . $game_array[0]['schedule_season_id'] . '&stage_id=' . $game_array[0]['stage_id'] . '">' . $game_array[0]['tournamenttype_name'] . ', ' . $game_array[0]['stage_name'] . '</a>';
    }
    elseif (TOURNAMENTTYPE_CONFERENCE == $game_array[0]['tournamenttype_id'])
    {
        $result = '<a href="/conference_table.php?season_id=' . $game_array[0]['schedule_season_id'] . '">' . $game_array[0]['tournamenttype_name'] . ', ' . $game_array[0]['stage_name'] . '</a>';
    }
    elseif (TOURNAMENTTYPE_OFFSEASON == $game_array[0]['tournamenttype_id'])
    {
        $result = '<a href="/offseason_table.php?season_id=' . $game_array[0]['schedule_season_id'] . '">' . $game_array[0]['tournamenttype_name'] . ', ' . $game_array[0]['stage_name'] . '</a>';
    }
    else
    {
        $result = $game_array[0]['tournamenttype_name'];
    }

    return $result;
}