<?php

/**
 * Змінюємо рейтинг відвідуваності команд після гри
 */
function f_igosja_generator_team_visitor_after_game()
{
    $sql = "SELECT `game_guest_score`,
                   `game_guest_team_id`,
                   `game_home_score`,
                   `game_home_team_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            AND `schedule_tournamenttype_id`!=" . TOURNAMENTTYPE_NATIONAL . "
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $item)
    {
        $home_score = $item['game_home_score'];

        if ($home_score > 9)
        {
            $home_score = 9;
        }

        $guest_score = $item['game_guest_score'];

        if ($guest_score > 9)
        {
            $guest_score = 9;
        }

        $home_visitor   = 0.5 + $home_score * 0.05 + 0.45 - $guest_score * 0.05;
        $guest_visitor  = 0.5 + $guest_score * 0.05 + 0.45 - $home_score * 0.05;
        $home_team_id   = $item['game_home_team_id'];
        $guest_team_id  = $item['game_guest_team_id'];

        $sql = "INSERT INTO `teamvisitor` (`teamvisitor_team_id`, `teamvisitor_visitor`)
                VALUES ($home_team_id, $home_visitor),
                       ($guest_team_id, $guest_visitor);";
        f_igosja_mysqli_query($sql);
    }
}