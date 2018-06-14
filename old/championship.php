<?php

/**
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$country_id = (int) f_igosja_request_get('country_id'))
{
    redirect('/wrong_page.php');
}

if (!$division_id = (int) f_igosja_request_get('division_id'))
{
    redirect('/wrong_page.php');
}

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

$sql = "SELECT `country_name`,
               `division_name`
        FROM `championship`
        LEFT JOIN `country`
        ON `championship_country_id`=`country_id`
        LEFT JOIN `division`
        ON `championship_division_id`=`division_id`
        WHERE `championship_season_id`=$season_id
        AND `championship_country_id`=$country_id
        AND `championship_division_id`=$division_id
        LIMIT 1";
$country_sql = f_igosja_mysqli_query($sql);

if (0 == $country_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `season_id`
        FROM `championship`
        LEFT JOIN `season`
        ON `championship_season_id`=`season_id`
        WHERE `championship_country_id`=$country_id
        AND `championship_division_id`=$division_id
        GROUP BY `championship_season_id`
        ORDER BY `championship_season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `division_id`,
               `division_name`
        FROM `championship`
        LEFT JOIN `division`
        ON `championship_division_id`=`division_id`
        WHERE `championship_season_id`=$season_id
        AND `championship_country_id`=$country_id
        GROUP BY `championship_division_id`
        ORDER BY `division_id` ASC";
$division_sql = f_igosja_mysqli_query($sql);

$division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

if (!$round_id = (int) f_igosja_request_get('round_id'))
{
    $sql = "SELECT `schedule_stage_id`
            FROM `schedule`
            WHERE `schedule_date`<=UNIX_TIMESTAMP()
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
            AND `schedule_season_id`=$season_id
            ORDER BY `schedule_id` DESC
            LIMIT 1";
    $stage_sql = f_igosja_mysqli_query($sql);

    if (0 == $stage_sql->num_rows)
    {
        $sql = "SELECT `schedule_stage_id`
                FROM `schedule`
                WHERE `schedule_date`>UNIX_TIMESTAMP()
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
                AND `schedule_season_id`=$season_id
                ORDER BY `schedule_id` ASC
                LIMIT 1";
        $stage_sql = f_igosja_mysqli_query($sql);
    }

    $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

    if ($stage_array[0]['schedule_stage_id'] <= STAGE_30_TOUR)
    {
        $round_id = ROUND_SEASON;
    }
    else
    {
        $round_id = ROUND_PLAYOFF;
    }
}

if (ROUND_SEASON == $round_id)
{
    $sql = "SELECT `schedule_date`,
                   `stage_id`,
                   `stage_name`
            FROM `schedule`
            LEFt JOIN `stage`
            ON `schedule_stage_id`=`stage_id`
            WHERE `schedule_season_id`=$season_id
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
            AND `schedule_stage_id`<=" . STAGE_30_TOUR. "
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
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
                AND `schedule_season_id`=$season_id
                AND `schedule_stage_id`<=" . STAGE_30_TOUR . "
                ORDER BY `schedule_id` DESC
                LIMIT 1";
        $schedule_sql = f_igosja_mysqli_query($sql);

        if (0 == $schedule_sql->num_rows)
        {
            $sql = "SELECT `schedule_id`,
                           `schedule_stage_id`
                    FROM `schedule`
                    WHERE `schedule_date`>UNIX_TIMESTAMP()
                    AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
                    AND `schedule_season_id`=$season_id
                    AND `schedule_stage_id`<=" . STAGE_30_TOUR . "
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
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
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

    $sql = "SELECT `game_id`,
                   `game_guest_auto`,
                   `game_guest_score`,
                   `game_home_auto`,
                   `game_home_score`,
                   `game_played`,
                   `guest_team`.`team_id` AS `guest_team_id`,
                   `guest_team`.`team_name` AS `guest_team_name`,
                   `guest_city`.`city_name` AS `guest_city_name`,
                   `home_team`.`team_id` AS `home_team_id`,
                   `home_team`.`team_name` AS `home_team_name`,
                   `home_city`.`city_name` AS `home_city_name`
            FROM `game`
            LEFT JOIN `team` AS `guest_team`
            ON `game_guest_team_id`=`guest_team`.`team_id`
            LEFT JOIN `stadium` AS `guest_stadium`
            ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
            LEFT JOIN `city` AS `guest_city`
            ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
            LEFT JOIN `team` AS `home_team`
            ON `game_home_team_id`=`home_team`.`team_id`
            LEFT JOIN `stadium` AS `home_stadium`
            ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
            LEFT JOIN `city` AS `home_city`
            ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
            LEFT JOIN `championship`
            ON `game_guest_team_id`=`championship_team_id`
            WHERE `game_schedule_id`=$schedule_id
            AND `championship_season_id`=$season_id
            AND `championship_country_id`=$country_id
            AND `championship_division_id`=$division_id
            ORDER BY `game_id` ASC";
    $game_sql = f_igosja_mysqli_query($sql);

    if (0 == $game_sql->num_rows)
    {
        redirect('/wrong_page.php');
    }

    $game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `city_name`,
                   `championship_game`,
                   `championship_loose`,
                   `championship_loose_bullet`,
                   `championship_loose_over`,
                   `championship_pass`,
                   `championship_place`,
                   `championship_point`,
                   `championship_score`,
                   `championship_win`,
                   `championship_win_bullet`,
                   `championship_win_over`,
                   `team_id`,
                   `team_name`,
                   `team_power_vs`
            FROM `championship`
            LEFT JOIN `team`
            ON `championship_team_id`=`team_id`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            WHERE `championship_season_id`=$season_id
            AND `championship_country_id`=$country_id
            AND `championship_division_id`=$division_id
            ORDER BY `championship_place` ASC";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);
}
else
{
    $playoff_array = array();

    $sql = "SELECT `stage_id`,
                   `stage_name`
            FROM `stage`
            WHERE `stage_id` IN (" . STAGE_QUATER . ", " . STAGE_SEMI . ", " . STAGE_FINAL . ")
            ORDER BY `stage_id` ASC";
    $stage_sql = f_igosja_mysqli_query($sql);

    $stage_array = $stage_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($stage_array as $stage)
    {
        $stage_id = $stage['stage_id'];

        $sql = "SELECT `schedule_id`
                FROM `schedule`
                WHERE `schedule_stage_id`=$stage_id
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
                AND `schedule_season_id`=$season_id
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
                           `guest_participant`.`participantchampionship_stage_id` AS `guest_stage_id`,
                           `guest_team`.`team_id` AS `guest_team_id`,
                           `guest_team`.`team_name` AS `guest_team_name`,
                           `home_city`.`city_name` AS `home_city_name`,
                           `home_participant`.`participantchampionship_stage_id` AS `home_stage_id`,
                           `home_team`.`team_id` AS `home_team_id`,
                           `home_team`.`team_name` AS `home_team_name`
                    FROM `game`
                    LEFT JOIN `team` AS `guest_team`
                    ON `game_guest_team_id`=`guest_team`.`team_id`
                    LEFT JOIN `stadium` AS `guest_stadium`
                    ON `guest_team`.`team_stadium_id`=`guest_stadium`.`stadium_id`
                    LEFT JOIN `city` AS `guest_city`
                    ON `guest_stadium`.`stadium_city_id`=`guest_city`.`city_id`
                    LEFT JOIN `participantchampionship` AS `guest_participant`
                    ON (`guest_team`.`team_id`=`guest_participant`.`participantchampionship_team_id`
                    AND `guest_participant`.`participantchampionship_season_id`=$season_id)
                    LEFT JOIN `team` AS `home_team`
                    ON `game_home_team_id`=`home_team`.`team_id`
                    LEFT JOIN `stadium` AS `home_stadium`
                    ON `home_team`.`team_stadium_id`=`home_stadium`.`stadium_id`
                    LEFT JOIN `city` AS `home_city`
                    ON `home_stadium`.`stadium_city_id`=`home_city`.`city_id`
                    LEFT JOIN `participantchampionship` AS `home_participant`
                    ON (`home_team`.`team_id`=`home_participant`.`participantchampionship_team_id`
                    AND `home_participant`.`participantchampionship_season_id`=$season_id)
                    LEFT JOIN `championship`
                    ON `game_guest_team_id`=`championship_team_id`
                    WHERE `game_schedule_id` IN ($schedule_id)
                    AND `championship_season_id`=$season_id
                    AND `championship_country_id`=$country_id
                    AND `championship_division_id`=$division_id
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
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
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
                AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP . "
                AND `schedule_season_id`=$season_id
                ORDER BY `schedule_id` ASC
                LIMIT 1";
        $schedule_sql = f_igosja_mysqli_query($sql);
    }

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id    = $schedule_array[0]['schedule_id'];
    $stage_id       = $schedule_array[0]['schedule_stage_id'];
}

$sql = "SELECT COUNT(`conference_id`) AS `count`
        FROM `conference`
        LEFT JOIN `team`
        ON `conference_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `conference_season_id`=$season_id
        AND `city_country_id`=$country_id";
$conference_sql = f_igosja_mysqli_query($sql);

$conference_array = $conference_sql->fetch_all(MYSQLI_ASSOC);

$review_create = false;

if (isset($auth_team_id) && $game_array && $game_array[0]['game_played'])
{
    $sql = "SELECT COUNT(`review_id`) AS `check`
            FROM `review`
            WHERE `review_country_id`=$country_id
            AND `review_division_id`=$division_id
            AND `review_schedule_id`=$schedule_id
            AND `review_season_id`=$season_id
            AND `review_stage_id`=$stage_id
            AND `review_user_id`=$auth_user_id";
    $review_sql = f_igosja_mysqli_query($sql);

    $review_array = $review_sql->fetch_all(MYSQLI_ASSOC);

    if (0 == $review_array[0]['check'])
    {
        $review_create = true;
    }
}

$sql = "SELECT `review_title`,
               `review_id`,
               `stage_name`,
               `user_id`,
               `user_login`
        FROM `review`
        LEFT JOIN `stage`
        ON `review_stage_id`=`stage_id`
        LEFT JOIN `user`
        ON `review_user_id`=`user_id`
        WHERE `review_country_id`=$country_id
        AND `review_division_id`=$division_id
        AND `review_season_id`=$season_id
        ORDER BY `review_schedule_id` ASC";
$review_sql = f_igosja_mysqli_query($sql);

$review_array = $review_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $country_array[0]['country_name'] . ', национальный чемпионат, дивизион ' . $country_array[0]['division_name'];
$seo_description    = $country_array[0]['country_name'] . '. ' . $country_array[0]['division_name'] . '. Национальный чемпионат, календарь игр и турнирная таблица на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' национальный чемпионат ' . $country_array[0]['division_name'];

include(__DIR__ . '/view/layout/main.php');