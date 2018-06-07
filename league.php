<?php

/**
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

$sql = "SELECT `season_id`
        FROM `league`
        LEFT JOIN `season`
        ON `league_season_id`=`season_id`
        GROUP BY `league_season_id`
        ORDER BY `league_season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

if (!$round_id = (int) f_igosja_request_get('round_id'))
{
    $sql = "SELECT `schedule_stage_id`
            FROM `schedule`
            WHERE `schedule_date`<=UNIX_TIMESTAMP()
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
            AND `schedule_season_id`=$season_id
            ORDER BY `schedule_id` DESC
            LIMIT 1";
    $stage_sql = f_igosja_mysqli_query($sql);

    if (0 == $stage_sql->num_rows)
    {
        $sql = "SELECT `schedule_stage_id`
                FROM `schedule`
                WHERE `schedule_date`>UNIX_TIMESTAMP()
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                AND `schedule_season_id`=$season_id
                ORDER BY `schedule_id` ASC
                LIMIT 1";
        $stage_sql = f_igosja_mysqli_query($sql);
    }

    $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

    if ($stage_array[0]['schedule_stage_id'] <= STAGE_6_TOUR)
    {
        $round_id = ROUND_GROUP;
    }
    elseif ($stage_array[0]['schedule_stage_id'] <= STAGE_4_QUALIFY)
    {
        $round_id = ROUND_QUALIFICATION;
    }
    else
    {
        $round_id = ROUND_PLAYOFF;
    }
}

if (ROUND_GROUP == $round_id)
{
    $sql = "SELECT `schedule_date`,
                   `stage_id`,
                   `stage_name`
            FROM `schedule`
            LEFt JOIN `stage`
            ON `schedule_stage_id`=`stage_id`
            WHERE `schedule_season_id`=$season_id
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
            AND `schedule_stage_id`<=" . STAGE_6_TOUR. "
            ORDER BY `stage_id` ASC";
    $stage_sql = f_igosja_mysqli_query($sql);

    $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id = 0;

    if (!$stage_id = (int) f_igosja_request_get('stage_id'))
    {
        $sql = "SELECT `schedule_id`,
                       `schedule_stage_id`
                FROM `schedule`
                WHERE `schedule_date`<=UNIX_TIMESTAMP()
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                AND `schedule_season_id`=$season_id
                AND `schedule_stage_id`<=" . STAGE_6_TOUR . "
                ORDER BY `schedule_id` DESC
                LIMIT 1";
        $schedule_sql = f_igosja_mysqli_query($sql);

        if (0 == $schedule_sql->num_rows)
        {
            $sql = "SELECT `schedule_id`,
                           `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_date`>UNIX_TIMESTAMP()
                    AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                    AND `schedule_season_id`=$season_id
                    AND `schedule_stage_id`<=" . STAGE_6_TOUR . "
                    ORDER BY `schedule_id` ASC
                    LIMIT 1";
            $schedule_sql = f_igosja_mysqli_query($sql);
        }

        $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

        $schedule_id    = $schedule_array[0]['schedule_id'];
        $stage_id       = $schedule_array[0]['schedule_stage_id'];
    }
    else
    {
        $sql = "SELECT `schedule_id`
                FROM `schedule`
                WHERE `schedule_stage_id`=$stage_id
                AND `schedule_season_id`=$season_id
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                ORDER BY `schedule_id` ASC
                LIMIT 1";
        $schedule_sql = f_igosja_mysqli_query($sql);

        if (0 == $schedule_sql->num_rows)
        {
            redirect('/wrong_page.php');
        }

        $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

        $schedule_id = $schedule_array[0]['schedule_id'];
    }

    $group_array = array(
        1 => array('name' => 'A'),
        2 => array('name' => 'B'),
        3 => array('name' => 'C'),
        4 => array('name' => 'D'),
        5 => array('name' => 'E'),
        6 => array('name' => 'F'),
        7 => array('name' => 'G'),
        8 => array('name' => 'H'),
    );

    for ($group=1; $group<=8; $group++)
    {
        $sql = "SELECT `game_id`,
                       `game_guest_auto`,
                       `game_guest_score`,
                       `game_home_auto`,
                       `game_home_score`,
                       `game_played`,
                       `guest_team`.`team_id` AS `guest_team_id`,
                       `guest_team`.`team_name` AS `guest_team_name`,
                       `guest_city`.`city_name` AS `guest_city_name`,
                       `guest_country`.`country_name` AS `guest_country_name`,
                       `home_team`.`team_id` AS `home_team_id`,
                       `home_team`.`team_name` AS `home_team_name`,
                       `home_city`.`city_name` AS `home_city_name`,
                       `home_country`.`country_name` AS `home_country_name`
                FROM `game`
                LEFT JOIN `team` AS `guest_team`
                ON `game_guest_team_id`=`guest_team`.`team_id`
                LEFT JOIN `stadium` AS `guest_stadium`
                ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
                LEFT JOIN `city` AS `guest_city`
                ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
                LEFT JOIN `country` AS `guest_country`
                ON `guest_city`.`city_country_id`=`guest_country`.`country_id`
                LEFT JOIN `team` AS `home_team`
                ON `game_home_team_id`=`home_team`.`team_id`
                LEFT JOIN `stadium` AS `home_stadium`
                ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
                LEFT JOIN `city` AS `home_city`
                ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
                LEFT JOIN `country` AS `home_country`
                ON `home_city`.`city_country_id`=`home_country`.`country_id`
                LEFT JOIN `league`
                ON `game_guest_team_id`=`league_team_id`
                WHERE `game_schedule_id`=$schedule_id
                AND `league_season_id`=$season_id
                AND `league_group`=$group
                ORDER BY `game_id` ASC";
        $game_sql = f_igosja_mysqli_query($sql);

        if (0 == $game_sql->num_rows)
        {
            redirect('/wrong_page.php');
        }

        $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

        $group_array[$group]['game'] = $game_array;

        $sql = "SELECT `city_name`,
                       `country_id`,
                       `country_name`,
                       `league_game`,
                       `league_loose`,
                       `league_loose_bullet`,
                       `league_loose_over`,
                       `league_pass`,
                       `league_place`,
                       `league_point`,
                       `league_score`,
                       `league_win`,
                       `league_win_bullet`,
                       `league_win_over`,
                       `team_id`,
                       `team_name`,
                       `team_power_vs`
                FROM `league`
                LEFT JOIN `team`
                ON `league_team_id`=`team_id`
                LEFT JOIN `stadium`
                ON `team_stadium_id`=`stadium_id`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                LEFT JOIN `country`
                ON `city_country_id`=`country_id`
                WHERE `league_season_id`=$season_id
                AND `league_group`=$group
                ORDER BY `league_place` ASC";
        $team_sql = f_igosja_mysqli_query($sql);

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        $group_array[$group]['team'] = $team_array;
    }
}
elseif (ROUND_QUALIFICATION == $round_id)
{
    $playoff_array = array();

    $sql = "SELECT `stage_id`,
                   `stage_name`
            FROM `stage`
            WHERE `stage_id` IN (" . STAGE_1_QUALIFY . ", " . STAGE_2_QUALIFY . ", " . STAGE_3_QUALIFY . ")
            ORDER BY `stage_id` ASC";
    $stage_sql = f_igosja_mysqli_query($sql);

    $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($stage_array as $stage)
    {
        $stage_id = $stage['stage_id'];

        $sql = "SELECT `schedule_id`
                FROM `schedule`
                WHERE `schedule_stage_id`=$stage_id
                AND `schedule_season_id`=$season_id
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                ORDER BY `schedule_id` ASC";
        $schedule_sql = f_igosja_mysqli_query($sql);

        $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

        if ($schedule_array)
        {
            $schedule_id = array();

            foreach ($schedule_array as $schedule)
            {
                $schedule_id[] = $schedule['schedule_id'];
            }

            $schedule_id = implode(',', $schedule_id);

            $sql = "SELECT `game_id`,
                           `game_guest_score`,
                           `game_home_score`,
                           `game_played`,
                           `guest_city`.`city_name` AS `guest_city_name`,
                           `guest_participant`.`participantleague_stage_id` AS `guest_stage_id`,
                           `guest_team`.`team_id` AS `guest_team_id`,
                           `guest_team`.`team_name` AS `guest_team_name`,
                           `home_city`.`city_name` AS `home_city_name`,
                           `home_participant`.`participantleague_stage_id` AS `home_stage_id`,
                           `home_team`.`team_id` AS `home_team_id`,
                           `home_team`.`team_name` AS `home_team_name`
                    FROM `game`
                    LEFT JOIN `team` AS `guest_team`
                    ON `game_guest_team_id`=`guest_team`.`team_id`
                    LEFT JOIN `stadium` AS `guest_stadium`
                    ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
                    LEFT JOIN `city` AS `guest_city`
                    ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
                    LEFT JOIN `participantleague` AS `guest_participant`
                    ON (`guest_team`.`team_id`=`guest_participant`.`participantleague_team_id`
                    AND `guest_participant`.`participantleague_season_id`=$season_id)
                    LEFT JOIN `team` AS `home_team`
                    ON `game_home_team_id`=`home_team`.`team_id`
                    LEFT JOIN `stadium` AS `home_stadium`
                    ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
                    LEFT JOIN `city` AS `home_city`
                    ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
                    LEFT JOIN `participantleague` AS `home_participant`
                    ON (`home_team`.`team_id`=`home_participant`.`participantleague_team_id`
                    AND `home_participant`.`participantleague_season_id`=$season_id)
                    WHERE `game_schedule_id` IN ($schedule_id)
                    ORDER BY `game_id` ASC";
            $game_sql = f_igosja_mysqli_query($sql);

            $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

            if ($game_array)
            {
                $participant_array = array();

                foreach ($game_array as $game)
                {
                    $in_array = false;

                    for ($i=0, $count_participant=count($participant_array); $i<$count_participant; $i++)
                    {
                        if (in_array($game['home_team_id'], array($participant_array[$i]['home_team_id'], $participant_array[$i]['guest_team_id'])))
                        {
                            $in_array = true;

                            if ($game['home_team_id'] == $participant_array[$i]['home_team_id'])
                            {
                                $home_score     = $game['game_home_score'];
                                $guest_score    = $game['game_guest_score'];
                            }
                            else
                            {
                                $home_score     = $game['game_guest_score'];
                                $guest_score    = $game['game_home_score'];
                            }

                            $participant_array[$i]['game'][] = '<a href="/game_view.php?num=' . $game['game_id'] . '">' . f_igosja_game_score($game['game_played'], $home_score, $guest_score) . '</a>';
                        }
                    }

                    if (false == $in_array)
                    {
                        $participant_array[] = array(
                            'home_city_name'    => $game['home_city_name'],
                            'home_stage_id'     => $game['home_stage_id'],
                            'home_team_id'      => $game['home_team_id'],
                            'home_team_name'    => $game['home_team_name'],
                            'guest_city_name'   => $game['guest_city_name'],
                            'guest_stage_id'    => $game['guest_stage_id'],
                            'guest_team_id'     => $game['guest_team_id'],
                            'guest_team_name'   => $game['guest_team_name'],
                            'game'              => array(
                                '<a href="/game_view.php?num=' . $game['game_id'] . '">' . f_igosja_game_score($game['game_played'], $game['game_home_score'], $game['game_guest_score']) . '</a>',
                            ),
                        );
                    }
                }

                $playoff_array[] = array(
                    'stage_id' => $stage['stage_id'],
                    'stage_name' => $stage['stage_name'],
                    'participant' => $participant_array,
                );
            }
        }
    }

    $sql = "SELECT `schedule_id`,
                   `schedule_stage_id`
            FROM `schedule`
            WHERE `schedule_date`<=UNIX_TIMESTAMP()
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
            AND `schedule_season_id`=$season_id
            ORDER BY `schedule_id` DESC
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    if (0 == $schedule_sql->num_rows)
    {
        $sql = "SELECT `schedule_id`,
                       `schedule_stage_id`
                FROM `schedule`
                WHERE `schedule_date`>UNIX_TIMESTAMP()
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                AND `schedule_season_id`=$season_id
                ORDER BY `schedule_id` ASC
                LIMIT 1";
        $schedule_sql = f_igosja_mysqli_query($sql);
    }

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id    = $schedule_array[0]['schedule_id'];
    $stage_id       = $schedule_array[0]['schedule_stage_id'];
}
else
{
    $playoff_array = array();

    $sql = "SELECT `stage_id`,
                   `stage_name`
            FROM `stage`
            WHERE `stage_id` IN (" . STAGE_1_8_FINAL . ", " . STAGE_QUATER . ", " . STAGE_SEMI . ", " . STAGE_FINAL . ")
            ORDER BY `stage_id` ASC";
    $stage_sql = f_igosja_mysqli_query($sql);

    $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($stage_array as $stage)
    {
        $stage_id = $stage['stage_id'];

        $sql = "SELECT `schedule_id`
                FROM `schedule`
                WHERE `schedule_stage_id`=$stage_id
                AND `schedule_season_id`=$season_id
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                ORDER BY `schedule_id` ASC";
        $schedule_sql = f_igosja_mysqli_query($sql);

        $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

        if ($schedule_array)
        {
            $schedule_id = array();

            foreach ($schedule_array as $schedule)
            {
                $schedule_id[] = $schedule['schedule_id'];
            }

            $schedule_id = implode(',', $schedule_id);

            $sql = "SELECT `game_id`,
                           `game_guest_score`,
                           `game_home_score`,
                           `game_played`,
                           `guest_city`.`city_name` AS `guest_city_name`,
                           `guest_participant`.`participantleague_stage_id` AS `guest_stage_id`,
                           `guest_team`.`team_id` AS `guest_team_id`,
                           `guest_team`.`team_name` AS `guest_team_name`,
                           `home_city`.`city_name` AS `home_city_name`,
                           `home_participant`.`participantleague_stage_id` AS `home_stage_id`,
                           `home_team`.`team_id` AS `home_team_id`,
                           `home_team`.`team_name` AS `home_team_name`
                    FROM `game`
                    LEFT JOIN `team` AS `guest_team`
                    ON `game_guest_team_id`=`guest_team`.`team_id`
                    LEFT JOIN `stadium` AS `guest_stadium`
                    ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
                    LEFT JOIN `city` AS `guest_city`
                    ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
                    LEFT JOIN `participantleague` AS `guest_participant`
                    ON (`guest_team`.`team_id`=`guest_participant`.`participantleague_team_id`
                    AND `guest_participant`.`participantleague_season_id`=$season_id)
                    LEFT JOIN `team` AS `home_team`
                    ON `game_home_team_id`=`home_team`.`team_id`
                    LEFT JOIN `stadium` AS `home_stadium`
                    ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
                    LEFT JOIN `city` AS `home_city`
                    ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
                    LEFT JOIN `participantleague` AS `home_participant`
                    ON (`home_team`.`team_id`=`home_participant`.`participantleague_team_id`
                    AND `home_participant`.`participantleague_season_id`=$season_id)
                    WHERE `game_schedule_id` IN ($schedule_id)
                    ORDER BY `game_id` ASC";
            $game_sql = f_igosja_mysqli_query($sql);

            $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

            if ($game_array)
            {
                $participant_array = array();

                foreach ($game_array as $game)
                {
                    $in_array = false;

                    for ($i=0, $count_participant=count($participant_array); $i<$count_participant; $i++)
                    {
                        if (in_array($game['home_team_id'], array($participant_array[$i]['home_team_id'], $participant_array[$i]['guest_team_id'])))
                        {
                            $in_array = true;

                            if ($game['home_team_id'] == $participant_array[$i]['home_team_id'])
                            {
                                $home_score     = $game['game_home_score'];
                                $guest_score    = $game['game_guest_score'];
                            }
                            else
                            {
                                $home_score     = $game['game_guest_score'];
                                $guest_score    = $game['game_home_score'];
                            }

                            $participant_array[$i]['game'][] = '<a href="/game_view.php?num=' . $game['game_id'] . '">' . f_igosja_game_score($game['game_played'], $home_score, $guest_score) . '</a>';
                        }
                    }

                    if (false == $in_array)
                    {
                        $participant_array[] = array(
                            'home_city_name'    => $game['home_city_name'],
                            'home_stage_id'     => $game['home_stage_id'],
                            'home_team_id'      => $game['home_team_id'],
                            'home_team_name'    => $game['home_team_name'],
                            'guest_city_name'   => $game['guest_city_name'],
                            'guest_stage_id'    => $game['guest_stage_id'],
                            'guest_team_id'     => $game['guest_team_id'],
                            'guest_team_name'   => $game['guest_team_name'],
                            'game'              => array(
                                '<a href="/game_view.php?num=' . $game['game_id'] . '">' . f_igosja_game_score($game['game_played'], $game['game_home_score'], $game['game_guest_score']) . '</a>',
                            ),
                        );
                    }
                }

                $playoff_array[] = array(
                    'stage_id' => $stage['stage_id'],
                    'stage_name' => $stage['stage_name'],
                    'participant' => $participant_array,
                );
            }
        }
    }

    $sql = "SELECT `schedule_id`,
                   `schedule_stage_id`
            FROM `schedule`
            WHERE `schedule_date`<=UNIX_TIMESTAMP()
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
            AND `schedule_season_id`=$season_id
            ORDER BY `schedule_id` DESC
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    if (0 == $schedule_sql->num_rows)
    {
        $sql = "SELECT `schedule_id`,
                       `schedule_stage_id`
                FROM `schedule`
                WHERE `schedule_date`>UNIX_TIMESTAMP()
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_LEAGUE . "
                AND `schedule_season_id`=$season_id
                ORDER BY `schedule_id` ASC
                LIMIT 1";
        $schedule_sql = f_igosja_mysqli_query($sql);
    }

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id    = $schedule_array[0]['schedule_id'];
    $stage_id       = $schedule_array[0]['schedule_stage_id'];
}

$seo_title          = 'Лига чемпионов';
$seo_description    = 'Лига чемпионов, календарь игр и турнирная таблица на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'лига чемпионов';

include(__DIR__ . '/view/layout/main.php');