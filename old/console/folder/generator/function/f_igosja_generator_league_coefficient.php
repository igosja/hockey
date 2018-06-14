<?php

/**
 * Оновлюємо таблицю коефіцієнтів
 */
function f_igosja_generator_league_coefficient()
{
    global $igosja_season_id;

    $sql = "SELECT `game_guest_national_id`,
                   `game_guest_score`,
                   `game_guest_score_bullet`,
                   `game_guest_score_over`,
                   `game_guest_team_id`,
                   `game_home_national_id`,
                   `game_home_score`,
                   `game_home_score_bullet`,
                   `game_home_score_over`,
                   `game_home_team_id`,
                   `schedule_season_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND `game_played`=0
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $game)
    {
        $guest_loose        = 0;
        $guest_loose_bullet = 0;
        $guest_loose_over   = 0;
        $guest_win          = 0;
        $guest_win_bullet   = 0;
        $guest_win_over     = 0;
        $home_loose         = 0;
        $home_loose_bullet  = 0;
        $home_loose_over    = 0;
        $home_win           = 0;
        $home_win_bullet    = 0;
        $home_win_over      = 0;

        if ($game['game_home_score'] > $game['game_guest_score'])
        {
            if (0 == $game['game_home_score_over'])
            {
                $home_win++;
                $guest_loose++;
            }
            else
            {
                $home_win_over++;
                $guest_loose_over++;
            }
        }
        elseif ($game['game_guest_score'] > $game['game_home_score'])
        {
            if (0 == $game['game_guest_score_over'])
            {
                $guest_win++;
                $home_loose++;
            }
            else
            {
                $guest_win_over++;
                $home_loose_over++;
            }
        }
        elseif ($game['game_guest_score'] == $game['game_home_score'])
        {
            if ($game['game_guest_score_bullet'] > $game['game_home_score_bullet'])
            {
                $guest_win_bullet++;
                $home_loose_bullet++;
            }
            elseif ($game['game_guest_score_bullet'] == $game['game_home_score_bullet'])
            {
                $home_loose_bullet++;
                $guest_loose_bullet++;
            }
            else
            {
                $home_win_bullet++;
                $guest_loose_bullet++;
            }
        }

        $sql = "UPDATE `leaguecoefficient`
                SET `leaguecoefficient_loose`=`leaguecoefficient_loose`+$home_loose,
                    `leaguecoefficient_loose_bullet`=`leaguecoefficient_loose_bullet`+$home_loose_bullet,
                    `leaguecoefficient_loose_over`=`leaguecoefficient_loose_over`+$home_loose_over,
                    `leaguecoefficient_win`=`leaguecoefficient_win`+$home_win,
                    `leaguecoefficient_win_bullet`=`leaguecoefficient_win_bullet`+$home_win_bullet,
                    `leaguecoefficient_win_over`=`leaguecoefficient_win_over`+$home_win_over
                WHERE `leaguecoefficient_team_id`=" . $game['game_home_team_id'] . "
                AND `leaguecoefficient_season_id`=" . $game['schedule_season_id'] . "
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `leaguecoefficient`
                SET `leaguecoefficient_loose`=`leaguecoefficient_loose`+$guest_loose,
                    `leaguecoefficient_loose_bullet`=`leaguecoefficient_loose_bullet`+$guest_loose_bullet,
                    `leaguecoefficient_loose_over`=`leaguecoefficient_loose_over`+$guest_loose_over,
                    `leaguecoefficient_win`=`leaguecoefficient_win`+$guest_win,
                    `leaguecoefficient_win_bullet`=`leaguecoefficient_win_bullet`+$guest_win_bullet,
                    `leaguecoefficient_win_over`=`leaguecoefficient_win_over`+$guest_win_over
                WHERE `leaguecoefficient_team_id`=" . $game['game_guest_team_id'] . "
                AND `leaguecoefficient_season_id`=" . $game['schedule_season_id'] . "
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `leaguecoefficient`
                SET `leaguecoefficient_point`=`leaguecoefficient_win`*3+`leaguecoefficient_win_over`*2+`leaguecoefficient_win_bullet`*2+`leaguecoefficient_loose_over`+`leaguecoefficient_loose_bullet`
                WHERE `leaguecoefficient_season_id`=$igosja_season_id";
        f_igosja_mysqli_query($sql);
    }
}