<?php

/**
 * Рахуємо кількість глядачів
 */
function f_igosja_generator_count_visitor()
{
    $sql = "SELECT `game_id`,
                   `game_ticket`,
                   `guest_national`.`national_visitor` AS `guest_national_visitor`,
                   `home_national`.`national_visitor` AS `home_national_visitor`,
                   `guest_team`.`team_visitor` AS `guest_team_visitor`,
                   `home_team`.`team_visitor` AS `home_team_visitor`,
                   IFNULL(`playerspecial_level`, 0) AS `playerspecial_level`,
                   `stadium_capacity`,
                   `stage_visitor`,
                   `tournamenttype_id`,
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
            LEFT JOIN `national` AS `guest_national`
            ON `game_guest_national_id`=`guest_national`.`national_id`
            LEFT JOIN `national` AS `home_national`
            ON `game_home_national_id`=`home_national`.`national_id`
            LEFT JOIN `stadium`
            ON `game_stadium_id`=`stadium_id`
            LEFT JOIN
            (
                SELECT `lineup_game_id`,
                       SUM(`playerspecial_level`) AS `playerspecial_level`
                FROM `playerspecial`
                LEFT JOIN `lineup`
                ON `playerspecial_player_id`=`lineup_player_id`
                WHERE `playerspecial_special_id`=" . SPECIAL_IDOL . "
                AND `lineup_game_id` IN
                (
                    SELECT `game_id`
                    FROM `game`
                    LEFT JOIN `schedule`
                    ON `game_schedule_id`=`schedule_id`
                    WHERE `game_played`=0
                    AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
                )
                GROUP BY `lineup_game_id`
            ) AS `t1`
            ON `game_id`=`lineup_game_id`
            WHERE `game_played`=0
            AND FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($game_array as $game)
    {
        $game_id                = $game['game_id'];
        $game_ticket            = $game['game_ticket'];
        $special                = $game['playerspecial_level'];
        $stadium_capacity       = $game['stadium_capacity'];
        $stage_visitor          = $game['stage_visitor'];
        $tournamenttype_id      = $game['tournamenttype_id'];
        $tournamenttype_visitor = $game['tournamenttype_visitor'];

        if (TOURNAMENTTYPE_NATIONAL == $tournamenttype_id)
        {
            $guest_visitor  = $game['guest_national_visitor'];
            $home_visitor   = $game['home_national_visitor'];
        }
        else
        {
            $guest_visitor  = $game['guest_team_visitor'];
            $home_visitor   = $game['home_team_visitor'];
        }

        $game_visitor = $stadium_capacity;
        $game_visitor = $game_visitor * $tournamenttype_visitor;
        $game_visitor = $game_visitor * $stage_visitor;
        $game_visitor = $game_visitor * (100 + $special * 5) / 100;

        if ($game_ticket < GAME_TICKET_MIN_PRICE)
        {
            $game_ticket = GAME_TICKET_MIN_PRICE;
        }
        elseif ($game_ticket > GAME_TICKET_MAX_PRICE)
        {
            $game_ticket = GAME_TICKET_MAX_PRICE;
        }

        $game_visitor = $game_visitor / pow(($game_ticket - GAME_TICKET_BASE_PRICE) / 10, 1.1);

        if (in_array($tournamenttype_id, array(TOURNAMENTTYPE_FRIENDLY, TOURNAMENTTYPE_NATIONAL)))
        {
            $game_visitor = $game_visitor * ($home_visitor + $guest_visitor) / 2;
        }
        else
        {
            $game_visitor = $game_visitor * ($home_visitor * 2 + $guest_visitor) / 3;
        }

        $game_visitor = $game_visitor / 1000000;
        $game_visitor = round($game_visitor);

        if ($game_visitor > $stadium_capacity)
        {
            $game_visitor = $stadium_capacity;
        }

        $sql = "UPDATE `game`
                SET `game_stadium_capacity`=$stadium_capacity,
                    `game_visitor`=$game_visitor
                WHERE `game_id`=$game_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}