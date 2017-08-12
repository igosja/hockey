<?php

/**
 * Рахуємо кількість глядачів
 */
function f_igosja_generator_count_visitor()
{
    $sql = "SELECT `game_id`,
                   `game_ticket`,
                   `guest_team`.`team_visitor` AS `guest_team_visitor`,
                   `home_team`.`team_visitor` AS `home_team_visitor`,
                   `stadium_capacity`,
                   `stage_visitor`,
                   `tournamenttype_visitor`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            LEFT JOIN `tournamenttype`
            ON `schedule_tournamenttype_id`=`tournamenttype_id`
            LEFT JOIN `stage`
            ON `schedule_stage_id`=`stage_id`
            LEFT JOIN `team` AS `guest_team`
            ON `game_guest_team_id`=`guest_team`.`team_id`
            LEFT JOIN `team` AS `home_team`
            ON `game_home_team_id`=`home_team`.`team_id`
            LEFT JOIN `stadium`
            ON `game_stadium_id`=`stadium_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(1);

    foreach ($game_array as $game)
    {
        $game_id                = $game['game_id'];
        $game_ticket            = $game['game_ticket'];
        $guest_visitor          = $game['guest_team_visitor'];
        $home_visitor           = $game['home_team_visitor'];
        $stadium_capacity       = $game['stadium_capacity'];
        $stage_visitor          = $game['stage_visitor'];
        $tournamenttype_visitor = $game['tournamenttype_visitor'];

        $game_visitor = $stadium_capacity;
        $game_visitor = $game_visitor * $tournamenttype_visitor;
        $game_visitor = $game_visitor * $stage_visitor;

        if ($game_ticket < GAME_TICKET_MIN_PRICE)
        {
            $game_ticket = GAME_TICKET_MIN_PRICE;
        }
        elseif ($game_ticket > GAME_TICKET_MAX_PRICE)
        {
            $game_ticket = GAME_TICKET_MAX_PRICE;
        }

        $game_visitor = $game_visitor / pow(($game_ticket - GAME_TICKET_BASE_PRICE) / 10, 1.1);
        $game_visitor = $game_visitor * ($home_visitor * 2 + $guest_visitor) / 3;
        $game_visitor = $game_visitor / 1000000;

        $sql = "UPDATE `game`
                SET `game_stadium_capacity`=$stadium_capacity,
                    `game_visitor`=$game_visitor
                WHERE `game_id`=$game_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}