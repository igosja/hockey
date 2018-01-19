<?php

include(__DIR__ . '/include/include.php');

$sql = "UPDATE `championship`
        SET `championship_game`=0,
            `championship_loose`=0,
            `championship_loose_bullet`=0,
            `championship_loose_over`=0,
            `championship_pass`=0,
            `championship_score`=0,
            `championship_win`=0,
            `championship_win_bullet`=0,
            `championship_win_over`=0
        WHERE `championship_season_id`=$igosja_season_id";
f_igosja_mysqli_query($sql);

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
               `schedule_season_id`,
               `schedule_stage_id`,
               `schedule_tournamenttype_id`
        FROM `game`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        WHERE `game_played`=1
        AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
        ORDER BY `game_id` ASC";
$game_sql = f_igosja_mysqli_query($sql);

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

foreach ($game_array as $game) {
    $guest_loose = 0;
    $guest_loose_bullet = 0;
    $guest_loose_over = 0;
    $guest_win = 0;
    $guest_win_bullet = 0;
    $guest_win_over = 0;
    $home_loose = 0;
    $home_loose_bullet = 0;
    $home_loose_over = 0;
    $home_win = 0;
    $home_win_bullet = 0;
    $home_win_over = 0;

    if ($game['game_home_score'] > $game['game_guest_score']) {
        if (0 == $game['game_home_score_over']) {
            $home_win++;
            $guest_loose++;
        } else {
            $home_win_over++;
            $guest_loose_over++;
        }
    } elseif ($game['game_guest_score'] > $game['game_home_score']) {
        if (0 == $game['game_guest_score_over']) {
            $guest_win++;
            $home_loose++;
        } else {
            $guest_win_over++;
            $home_loose_over++;
        }
    } elseif ($game['game_guest_score'] == $game['game_home_score']) {
        if (0 == $game['game_home_score_bullet']) {
            $guest_win_bullet++;
            $home_loose_bullet++;
        } else {
            $home_win_bullet++;
            $guest_loose_bullet++;
        }
    }

    $sql = "UPDATE `championship`
            SET `championship_game`=`championship_game`+1,
                `championship_loose`=`championship_loose`+$home_loose,
                `championship_loose_bullet`=`championship_loose_bullet`+$home_loose_bullet,
                `championship_loose_over`=`championship_loose_over`+$home_loose_over,
                `championship_pass`=`championship_pass`+" . $game['game_guest_score'] . ",
                `championship_score`=`championship_score`+" . $game['game_home_score'] . ",
                `championship_win`=`championship_win`+$home_win,
                `championship_win_bullet`=`championship_win_bullet`+$home_win_bullet,
                `championship_win_over`=`championship_win_over`+$home_win_over
            WHERE `championship_team_id`=" . $game['game_home_team_id'] . "
            AND `championship_season_id`=" . $game['schedule_season_id'] . "
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `championship`
            SET `championship_game`=`championship_game`+1,
                `championship_loose`=`championship_loose`+$guest_loose,
                `championship_loose_bullet`=`championship_loose_bullet`+$guest_loose_bullet,
                `championship_loose_over`=`championship_loose_over`+$guest_loose_over,
                `championship_pass`=`championship_pass`+" . $game['game_home_score'] . ",
                `championship_score`=`championship_score`+" . $game['game_guest_score'] . ",
                `championship_win`=`championship_win`+$guest_win,
                `championship_win_bullet`=`championship_win_bullet`+$guest_win_bullet,
                `championship_win_over`=`championship_win_over`+$guest_win_over
            WHERE `championship_team_id`=" . $game['game_guest_team_id'] . "
            AND `championship_season_id`=" . $game['schedule_season_id'] . "
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}

$sql = "SELECT `championship_country_id`
        FROM `championship`
        WHERE `championship_season_id`=$igosja_season_id
        GROUP BY `championship_country_id`
        ORDER BY `championship_country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

foreach ($country_array as $country)
{
    $sql = "SELECT `championship_division_id`
            FROM `championship`
            WHERE `championship_season_id`=$igosja_season_id
            AND `championship_country_id`=" . $country['championship_country_id'] . "
            GROUP BY `championship_division_id`
            ORDER BY `championship_division_id` ASC";
    $division_sql = f_igosja_mysqli_query($sql);

    $division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($division_array as $division)
    {
        $sql = "SELECT `championship_id`
                FROM `championship`
                LEFT JOIN `team`
                ON `championship_team_id`=`team_id`
                WHERE `championship_season_id`=$igosja_season_id
                AND `championship_country_id`=" . $country['championship_country_id'] . "
                AND `championship_division_id`=" . $division['championship_division_id'] . "
                ORDER BY `championship_point` DESC, `championship_win` DESC, `championship_win_over` DESC, `championship_win_bullet` DESC, `championship_loose_bullet` DESC, `championship_loose_over` DESC, `championship_score`-`championship_pass` DESC, `championship_score` DESC, `team_power_vs` ASC, `team_id` ASC";
        $championship_sql = f_igosja_mysqli_query($sql);

        $championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

        for ($i=0; $i<$championship_sql->num_rows; $i++)
        {
            $sql = "UPDATE `championship`
                    SET `championship_place`=" . ( $i + 1 ) . "
                    WHERE `championship_id`=" . $championship_array[$i]['championship_id'] . "
                    LIMIT 1";
            f_igosja_mysqli_query($sql);
        }
    }
}