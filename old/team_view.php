<?php

/**
 * @var $auth_country_id integer
 * @var $auth_team_id integer
 * @var $auth_team_vice_id integer
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if ($auth_team_select = f_igosja_request_post('auth_team_id'))
{
    $_SESSION['team_id'] = $auth_team_select;

    refresh();
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_team_id) && !isset($auth_team_vice_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_team_id)
    {
        redirect('/team_ask.php');
    }

    if (0 != $auth_team_vice_id)
    {
        $num_get = $auth_team_vice_id;
    }
    else
    {
        $num_get = $auth_team_id;
    }
}

include(__DIR__ . '/include/sql/team_view_left.php');
include(__DIR__ . '/include/sql/team_view_right.php');

$order = '`player_position_id` ASC, `player_id` ASC';

if ($num_get == $auth_team_id)
{
    $order = '`player_order` ASC, ' . $order;
}

$sql = "SELECT `country_id`,
               `country_name`,
               `line_color`,
               `name_name`,
               `phisical_id`,
               `phisical_name`,
               `player_age`,
               `player_game_row`,
               `player_id`,
               `player_injury`,
               `player_injury_day`,
               `player_national_id`,
               `player_power_nominal`,
               `player_power_old`,
               `player_power_real`,
               `player_price`,
               `player_rent_on`,
               `player_rent_team_id`,
               `player_team_id`,
               `player_tire`,
               `player_transfer_on`,
               `style_id`,
               `style_name`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `phisical`
        ON `player_phisical_id`=`phisical_id`
        LEFT JOIN `line`
        ON `player_line_id`=`line_id`
        LEFT JOIN `style`
        ON `player_style_id`=`style_id`
        WHERE `player_team_id`=$num_get
        AND `player_rent_team_id`=0
        ORDER BY $order";
$player_sql = f_igosja_mysqli_query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`,
               `line_color`,
               `name_name`,
               `phisical_id`,
               `phisical_name`,
               `player_age`,
               `player_game_row`,
               `player_id`,
               `player_injury`,
               `player_injury_day`,
               `player_national_id`,
               `player_power_nominal`,
               `player_power_old`,
               `player_power_real`,
               `player_price`,
               `player_rent_day`,
               `player_rent_on`,
               `player_rent_team_id`,
               `player_team_id`,
               `player_tire`,
               `player_transfer_on`,
               `style_id`,
               `style_name`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `phisical`
        ON `player_phisical_id`=`phisical_id`
        LEFT JOIN `line`
        ON `player_line_id`=`line_id`
        LEFT JOIN `style`
        ON `player_style_id`=`style_id`
        WHERE `player_team_id`=$num_get
        AND `player_rent_team_id`!=0
        ORDER BY `player_position_id` ASC, `player_id` ASC";
$player_rent_out_sql = f_igosja_mysqli_query($sql);

$player_rent_out_array = $player_rent_out_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`,
               `line_color`,
               `name_name`,
               `phisical_id`,
               `phisical_name`,
               `player_age`,
               `player_game_row`,
               `player_id`,
               `player_injury`,
               `player_injury_day`,
               `player_national_id`,
               `player_power_nominal`,
               `player_power_old`,
               `player_power_real`,
               `player_price`,
               `player_rent_day`,
               `player_rent_on`,
               `player_rent_team_id`,
               `player_team_id`,
               `player_tire`,
               `player_transfer_on`,
               `style_id`,
               `style_name`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `phisical`
        ON `player_phisical_id`=`phisical_id`
        LEFT JOIN `line`
        ON `player_line_id`=`line_id`
        LEFT JOIN `style`
        ON `player_style_id`=`style_id`
        WHERE `player_rent_team_id`=$num_get
        AND `player_team_id`!=$num_get
        ORDER BY `player_position_id` ASC, `player_id` ASC";
$player_rent_in_sql = f_igosja_mysqli_query($sql);

$player_rent_in_array = $player_rent_in_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `team_power_s_16`,
               `team_power_s_21`,
               `team_power_s_27`,
               `team_power_vs`,
               `team_price_base`,
               `team_price_total`
        FROM `team`
        WHERE `team_id`=$num_get
        LIMIT 1";
$rating_sql = f_igosja_mysqli_query($sql);

$rating_array = $rating_sql->fetch_all(MYSQLI_ASSOC);

$player_id = array();

foreach ($player_array as $item)
{
    $player_id[] = $item['player_id'];
}

foreach ($player_rent_out_array as $item)
{
    $player_id[] = $item['player_id'];
}

foreach ($player_rent_in_array as $item)
{
    $player_id[] = $item['player_id'];
}

if (count($player_id))
{
    $player_id = implode(', ', $player_id);

    $sql = "SELECT `playerposition_player_id`,
                   `position_name`,
                   `position_short`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id` IN ($player_id)";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_player_id`,
                   `special_name`,
                   `special_short`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id` IN ($player_id)
            ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $playerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT SUM(`statisticplayer_assist`) AS `statisticplayer_assist`,
                   SUM(`statisticplayer_game`) AS `statisticplayer_game`,
                   `statisticplayer_player_id`,
                   SUM(`statisticplayer_plus_minus`) AS `statisticplayer_plus_minus`,
                   SUM(`statisticplayer_score`) AS `statisticplayer_score`
            FROM `statisticplayer`
            WHERE `statisticplayer_player_id` IN ($player_id)
            AND `statisticplayer_season_id`=$igosja_season_id
            GROUP BY `statisticplayer_player_id`";
    $playerstatistic_sql = f_igosja_mysqli_query($sql);

    $playerstatistic_array = $playerstatistic_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `training_player_id`
            FROM `training`
            WHERE `training_player_id` IN ($player_id)
            ANd `training_ready`=0";
    $training_sql = f_igosja_mysqli_query($sql);

    $training_array = $training_sql->fetch_all(MYSQLI_ASSOC);

    if (isset($auth_team_id))
    {
        $sql = "SELECT COUNT(`scout_id`) AS `count_scout`,
                       `scout_player_id`
                FROM `scout`
                WHERE `scout_player_id` IN ($player_id)
                AND `scout_team_id`=$auth_team_id
                AND `scout_style`=1
                AND `scout_ready`=1
                GROUP BY `scout_player_id`";
        $scout_sql = f_igosja_mysqli_query($sql);

        $scout_array = $scout_sql->fetch_all(MYSQLI_ASSOC);
    }
    else
    {
        $scout_array = array();
    }
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
    $playerstatistic_array  = array();
    $training_array         = array();
    $scout_array            = array();
}

$notification_array = array();

if (isset($auth_team_id) && $auth_team_id == $num_get)
{
    $sql = "SELECT `game_guest_mood_id`,
                   `game_guest_team_id`,
                   `game_home_mood_id`,
                   `game_home_team_id`,
                   `game_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE (`game_home_team_id`=$num_get
            OR `game_guest_team_id`=$num_get)
            AND `game_played`=0
            ORDER BY `schedule_id` ASC
            LIMIT 1";
    $check_game_send_sql = f_igosja_mysqli_query($sql);

    if ($check_game_send_sql->num_rows)
    {
        $check_game_send_array = $check_game_send_sql->fetch_all(MYSQLI_ASSOC);

        if (($num_get == $check_game_send_array[0]['game_guest_team_id'] && 0 == $check_game_send_array[0]['game_guest_mood_id']) ||
            ($num_get == $check_game_send_array[0]['game_home_team_id'] && 0 == $check_game_send_array[0]['game_home_mood_id']))
        {
            $notification_array[] = 'Вы не отправили состав на ближайший <a href="/game_send.php?num=' . $check_game_send_array[0]['game_id'] . '">матч</a> своей команды.';
        }
    }

    $sql = "SELECT `game_guest_mood_id`,
                   `game_guest_team_id`,
                   `game_home_mood_id`,
                   `game_home_team_id`,
                   `game_id`
            FROM `game`
            LEFT JOIN `schedule`
            ON `game_schedule_id`=`schedule_id`
            WHERE (`game_home_team_id`=$num_get
            OR `game_guest_team_id`=$num_get)
            AND `game_played`=0
            ORDER BY `schedule_id` ASC
            LIMIT 1";
    $check_mood_sql = f_igosja_mysqli_query($sql);

    if ($check_mood_sql->num_rows)
    {
        $check_mood_array = $check_mood_sql->fetch_all(MYSQLI_ASSOC);

        if (($num_get == $check_mood_array[0]['game_guest_team_id'] && MOOD_SUPER == $check_mood_array[0]['game_guest_mood_id']) ||
            ($num_get == $check_mood_array[0]['game_home_team_id'] && MOOD_SUPER == $check_mood_array[0]['game_home_mood_id']))
        {
            $notification_array[] = 'В ближайшем <a href="/game_send.php?num=' . $check_mood_array[0]['game_id'] . '">матче</a> ваша команда будет использовать супер.';
        }
        elseif (($num_get == $check_mood_array[0]['game_guest_team_id'] && MOOD_REST == $check_mood_array[0]['game_guest_mood_id']) ||
            ($num_get == $check_mood_array[0]['game_home_team_id'] && MOOD_REST == $check_mood_array[0]['game_home_mood_id']))
        {
            $notification_array[] = 'В ближайшем <a href="/game_send.php?num=' . $check_mood_array[0]['game_id'] . '">матче</a> ваша команда будет использовать отдых.';
        }
    }

    $sql = "SELECT COUNT(`user_id`) AS `count`
            FROM `user`
            WHERE `user_id`=$auth_user_id
            AND `user_date_vip`>UNIX_TIMESTAMP()
            AND `user_date_vip`<UNIX_TIMESTAMP()-604800";
    $vip_sql = f_igosja_mysqli_query($sql);

    $vip_array = $vip_sql->fetch_all(MYSQLI_ASSOC);

    if ($vip_array[0]['count'])
    {
        $notification_array[] = 'Ваш VIP-клуб заканчивается менее, чем через неделю - не забудьте <a href="/shop.php">продлить</a>.';
    }

    $sql = "SELECT COUNT(`country_id`) AS `count`
            FROM `country`
            WHERE `country_id`=$auth_country_id
            AND `country_president_id`=0
            AND `country_vice_id`=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if ($check_array[0]['count'])
    {
        $sql = "SELECT COUNT(`electionpresident_id`) AS `count`
                FROM `electionpresident`
                WHERE `electionpresident_country_id`=$auth_country_id
                AND `electionpresident_electionstatus_id` IN (
                    " . ELECTIONSTATUS_CANDIDATES . ",
                    " . ELECTIONSTATUS_OPEN . "
                )";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if (0 == $check_array[0]['count'])
        {
            $sql = "INSERT INTO `electionpresident`
                    SET `electionpresident_country_id`=$auth_country_id,
                        `electionpresident_date`=UNIX_TIMESTAMP()";
            f_igosja_mysqli_query($sql);
        }
    }

    $sql = "SELECT `electionpresident_electionstatus_id`,
                   `electionpresident_id`
            FROM `electionpresident`
            WHERE `electionpresident_country_id`=$auth_country_id
            AND `electionpresident_electionstatus_id` IN (
                " . ELECTIONSTATUS_CANDIDATES . ",
                " . ELECTIONSTATUS_OPEN . "
            )";
    $election_sql = f_igosja_mysqli_query($sql);

    $election_array = $election_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($election_array as $item)
    {
        if (ELECTIONSTATUS_CANDIDATES == $item['electionpresident_electionstatus_id'])
        {
            $notification_array[] = 'В вашей стране открыт <a href="/president_application.php?num=' . $auth_country_id . '">прием заявок</a> от кандидатов президентов федерации';
        }
        elseif (ELECTIONSTATUS_OPEN == $item['electionpresident_electionstatus_id'])
        {
            $electionpresident_id = $item['electionpresident_id'];

            $sql = "SELECT COUNT(`electionpresidentuser_electionpresidentapplication_id`) AS `count`
                    FROM `electionpresidentuser`
                    WHERE `electionpresidentuser_electionpresident_id`=$electionpresident_id
                    AND `electionpresidentuser_user_id`=$auth_user_id";
            $electionpresidentuser_sql = f_igosja_mysqli_query($sql);

            $electionpresidentuser_array = $electionpresidentuser_sql->fetch_all(MYSQLI_ASSOC);

            if (0 == $electionpresidentuser_array[0]['count'])
            {
                redirect('/president_vote.php?num=' . $auth_country_id);
            }

            $notification_array[] = 'В вашей стране проходят выборы презитента федерации, результаты можно посмотреть <a href="/president_vote.php?num=' . $auth_country_id . '">здесь</a>';
        }
    }

    $sql = "SELECT COUNT(`country_id`) AS `count`
            FROM `country`
            WHERE `country_id`=$auth_country_id
            AND `country_president_id`!=0
            AND `country_vice_id`=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if ($check_array[0]['count'])
    {
        $sql = "SELECT COUNT(`electionpresidentvice_id`) AS `count`
                FROM `electionpresidentvice`
                WHERE `electionpresidentvice_country_id`=$auth_country_id
                AND `electionpresidentvice_electionstatus_id` IN (
                    " . ELECTIONSTATUS_CANDIDATES . ",
                    " . ELECTIONSTATUS_OPEN . "
                )";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if (0 == $check_array[0]['count'])
        {
            $sql = "INSERT INTO `electionpresidentvice`
                    SET `electionpresidentvice_country_id`=$auth_country_id,
                        `electionpresidentvice_date`=UNIX_TIMESTAMP()";
            f_igosja_mysqli_query($sql);
        }
    }

    $sql = "SELECT `electionpresidentvice_electionstatus_id`,
                   `electionpresidentvice_id`
            FROM `electionpresidentvice`
            WHERE `electionpresidentvice_country_id`=$auth_country_id
            AND `electionpresidentvice_electionstatus_id` IN (
                " . ELECTIONSTATUS_CANDIDATES . ",
                " . ELECTIONSTATUS_OPEN . "
            )";
    $election_sql = f_igosja_mysqli_query($sql);

    $election_array = $election_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($election_array as $item)
    {
        if (ELECTIONSTATUS_CANDIDATES == $item['electionpresidentvice_electionstatus_id'])
        {
            $notification_array[] = 'В вашей стране открыт <a href="/president_vice_application.php?num=' . $auth_country_id . '">прием заявок</a> от кандидатов заместителей президента федерации';
        }
        elseif (ELECTIONSTATUS_OPEN == $item['electionpresidentvice_electionstatus_id'])
        {
            $electionpresidentvice_id = $item['electionpresidentvice_id'];

            $sql = "SELECT COUNT(`electionpresidentviceuser_electionpresidentviceapplication_id`) AS `count`
                    FROM `electionpresidentviceuser`
                    WHERE `electionpresidentviceuser_electionpresidentvice_id`=$electionpresidentvice_id
                    AND `electionpresidentviceuser_user_id`=$auth_user_id";
            $electionpresidentviceuser_sql = f_igosja_mysqli_query($sql);

            $electionpresidentviceuser_array = $electionpresidentviceuser_sql->fetch_all(MYSQLI_ASSOC);

            if (0 == $electionpresidentviceuser_array[0]['count'])
            {
                redirect('/president_vice_vote.php?num=' . $auth_country_id);
            }

            $notification_array[] = 'В вашей стране проходят выборы заместителя презитента федерации, результаты можно посмотреть <a href="/president_vice_vote.php?num=' . $auth_country_id . '">здесь</a>';
        }
    }

    if ($igosja_season_id > 1)
    {
        $sql = "SELECT COUNT(`national_id`) AS `count`
                FROM `national`
                LEFT JOIN `country`
                ON `national_country_id`=`country_id`
                WHERE `country_id`=$auth_country_id
                AND `national_nationaltype_id`=" . NATIONALTYPE_MAIN . "
                AND `national_user_id`=0
                AND `national_vice_id`=0";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if ($check_array[0]['count'])
        {
            $sql = "SELECT COUNT(`electionnational_id`) AS `count`
                    FROM `electionnational`
                    WHERE `electionnational_country_id`=$auth_country_id
                    AND `electionnational_nationaltype_id`=" . NATIONALTYPE_MAIN . "
                    AND `electionnational_electionstatus_id` IN (
                        " . ELECTIONSTATUS_CANDIDATES . ",
                        " . ELECTIONSTATUS_OPEN . "
                    )";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (0 == $check_array[0]['count'])
            {
                $sql = "INSERT INTO `electionnational`
                        SET `electionnational_country_id`=$auth_country_id,
                            `electionnational_date`=UNIX_TIMESTAMP(),
                            `electionnational_nationaltype_id`=" . NATIONALTYPE_MAIN;
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT `electionnational_electionstatus_id`,
                       `electionnational_id`
                FROM `electionnational`
                WHERE `electionnational_country_id`=$auth_country_id
                AND `electionnational_nationaltype_id`=" . NATIONALTYPE_MAIN . "
                AND `electionnational_electionstatus_id` IN (
                    " . ELECTIONSTATUS_CANDIDATES . ",
                    " . ELECTIONSTATUS_OPEN . "
                )";
        $election_sql = f_igosja_mysqli_query($sql);

        $election_array = $election_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($election_array as $item)
        {
            if (ELECTIONSTATUS_CANDIDATES == $item['electionnational_electionstatus_id'])
            {
                $notification_array[] = 'В вашей стране открыт <a href="/national_application.php?num=' . $auth_country_id . '&type=' . NATIONALTYPE_MAIN . '">прием заявок</a> от кандидатов тренеров сборных';
            }
            elseif (ELECTIONSTATUS_OPEN == $item['electionnational_electionstatus_id'])
            {
                $electionnational_id = $item['electionnational_id'];

                $sql = "SELECT COUNT(`electionnationaluser_electionnationalapplication_id`) AS `count`
                        FROM `electionnationaluser`
                        WHERE `electionnationaluser_electionnational_id`=$electionnational_id
                        AND `electionnationaluser_user_id`=$auth_user_id";
                $electionnationaluser_sql = f_igosja_mysqli_query($sql);

                $electionnationaluser_array = $electionnationaluser_sql->fetch_all(MYSQLI_ASSOC);

                if (0 == $electionnationaluser_array[0]['count'])
                {
                    redirect('/national_vote.php?num=' . $auth_country_id . '&type=' . NATIONALTYPE_MAIN);
                }

                $notification_array[] = 'В вашей стране проходят выборы тренера сборной, результаты можно посмотреть <a href="/national_vote.php?num=' . $auth_country_id . '&type=' . NATIONALTYPE_MAIN . '">здесь</a>';
            }
        }

        $sql = "SELECT COUNT(`national_id`) AS `count`
                FROM `national`
                LEFT JOIN `country`
                ON `national_country_id`=`country_id`
                WHERE `country_id`=$auth_country_id
                AND `national_nationaltype_id`=" . NATIONALTYPE_MAIN . "
                AND `national_user_id`!=0
                AND `national_vice_id`=0";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if ($check_array[0]['count'])
        {
            $sql = "SELECT COUNT(`electionnationalvice_id`) AS `count`
                    FROM `electionnationalvice`
                    WHERE `electionnationalvice_country_id`=$auth_country_id
                    AND `electionnationalvice_nationaltype_id`=" . NATIONALTYPE_MAIN . "
                    AND `electionnationalvice_electionstatus_id` IN (
                        " . ELECTIONSTATUS_CANDIDATES . ",
                        " . ELECTIONSTATUS_OPEN . "
                    )";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

            if (0 == $check_array[0]['count'])
            {
                $sql = "INSERT INTO `electionnationalvice`
                        SET `electionnationalvice_country_id`=$auth_country_id,
                            `electionnationalvice_date`=UNIX_TIMESTAMP(),
                            `electionnationalvice_nationaltype_id`=" . NATIONALTYPE_MAIN;
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT `electionnationalvice_electionstatus_id`,
                       `electionnationalvice_id`
                FROM `electionnationalvice`
                WHERE `electionnationalvice_country_id`=$auth_country_id
                AND `electionnationalvice_nationaltype_id`=" . NATIONALTYPE_MAIN . "
                AND `electionnationalvice_electionstatus_id` IN (
                    " . ELECTIONSTATUS_CANDIDATES . ",
                    " . ELECTIONSTATUS_OPEN . "
                )";
        $election_sql = f_igosja_mysqli_query($sql);

        $election_array = $election_sql->fetch_all(MYSQLI_ASSOC);

        foreach ($election_array as $item)
        {
            if (ELECTIONSTATUS_CANDIDATES == $item['electionnationalvice_electionstatus_id'])
            {
                $notification_array[] = 'В вашей стране открыт <a href="/national_vice_application.php?num=' . $auth_country_id . '&type=' . NATIONALTYPE_MAIN . '">прием заявок</a> от кандидатов заместителей тренера сборной';
            }
            elseif (ELECTIONSTATUS_OPEN == $item['electionnationalvice_electionstatus_id'])
            {
                $electionnationalvice_id = $item['electionnationalvice_id'];

                $sql = "SELECT COUNT(`electionnationalviceuser_electionnationalviceapplication_id`) AS `count`
                        FROM `electionnationalviceuser`
                        WHERE `electionnationalviceuser_electionnationalvice_id`=$electionnationalvice_id
                        AND `electionnationalviceuser_user_id`=$auth_user_id";
                $electionnationalviceuser_sql = f_igosja_mysqli_query($sql);

                $electionnationalviceuser_array = $electionnationalviceuser_sql->fetch_all(MYSQLI_ASSOC);

                if (0 == $electionnationalviceuser_array[0]['count'])
                {
                    redirect('/national_vice_vote.php?num=' . $auth_country_id . '&type=' . NATIONALTYPE_MAIN);
                }

                $notification_array[] = 'В вашей стране проходят выборы заместителя тренера сборной, результаты можно посмотреть <a href="/national_vice_vote.php?num=' . $auth_country_id . '&type=' . NATIONALTYPE_MAIN . '">здесь</a>';
            }
        }
    }

    $sql = "SELECT COUNT(`user_id`) AS `check`
            FROM `user`
            WHERE `user_id`=$auth_user_id
            AND (`user_shop_position`!=0
            OR `user_shop_special`!=0
            OR `user_shop_training`!=0)
            LIMIT 1";
    $user_training_sql = f_igosja_mysqli_query($sql);

    $user_training_array = $user_training_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $user_training_array[0]['check'])
    {
        $notification_array[] = 'У вас есть бонусные <a href="/training_bonus.php">тренировки</a> для хоккеистов';
    }
    
    $sql = "SELECT `team_free_base`
            FROM `team`
            WHERE `team_id`=$num_get
            LIMIT 1";
    $free_base_sql = f_igosja_mysqli_query($sql);

    $free_base_array = $free_base_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $free_base_array[0]['team_free_base'])
    {
        $notification_array[] = 'У вас есть бесплатные <a href="/base_free.php">улучшения</a> базы';
    }

    $sql = "SELECT `friendlyinvite_schedule_id`
            FROM `friendlyinvite`
            WHERE `friendlyinvite_guest_team_id`=$num_get
            AND `friendlyinvite_friendlyinvitestatus_id`=" . FRIENDLY_INVITE_STATUS_NEW . "
            ORDER BY `friendlyinvite_schedule_id` DESC
            LIMIT 1";
    $friendly_sql = f_igosja_mysqli_query($sql);

    if (0 != $friendly_sql->num_rows)
    {
        $friendly_array = $friendly_sql->fetch_all(MYSQLI_ASSOC);

        $notification_array[] = 'У вас есть новые <a href="/friendly.php?num=' . $friendly_array[0]['friendlyinvite_schedule_id'] . '">приглашения</a> сыграть товарищеский матч';
    }

    $sql = "SELECT `transfer_id`
            FROM `transfer`
            LEFT JOIN
            (
                SELECT SUM(`transfervote_rating`) AS `rating`,
                       `transfervote_transfer_id`
                FROM `transfervote`
                WHERE `transfervote_transfer_id` IN
                (
                    SELECT `transfer_id`
                    FROM `transfer`
                    WHERE `transfer_checked`=0
                    AND (`transfer_team_buyer_id`=$num_get
                    OR `transfer_team_seller_id`=$num_get)
                )
                GROUP BY `transfervote_transfer_id`
            ) AS `t1`
            ON `transfer_id`=`transfervote_transfer_id`
            WHERE `transfer_checked`=0
            AND `rating`<0
            AND (`transfer_team_buyer_id`=$num_get
            OR `transfer_team_seller_id`=$num_get)
            ORDER BY `transfer_id` ASC";
    $transfer_sql = f_igosja_mysqli_query($sql);

    $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($transfer_array as $item)
    {
        $notification_array[] = 'Ваша <a href="/transfer_view.php?num=' . $item['transfer_id'] . '">трансферная сделка</a> имеет отрицательную оценку и будет отменена после завершения голосования';
    }

    $sql = "SELECT `rent_id`
            FROM `rent`
            LEFT JOIN
            (
                SELECT SUM(`rentvote_rating`) AS `rating`,
                       `rentvote_rent_id`
                FROM `rentvote`
                WHERE `rentvote_rent_id` IN
                (
                    SELECT `rent_id`
                    FROM `rent`
                    WHERE `rent_checked`=0
                    AND (`rent_team_buyer_id`=$num_get
                    OR `rent_team_seller_id`=$num_get)
                )
                GROUP BY `rentvote_rent_id`
            ) AS `t1`
            ON `rent_id`=`rentvote_rent_id`
            WHERE `rent_checked`=0
            AND `rating`<0
            AND (`rent_team_buyer_id`=$num_get
            OR `rent_team_seller_id`=$num_get)
            ORDER BY `rent_id` ASC";
    $rent_sql = f_igosja_mysqli_query($sql);

    $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($rent_array as $item)
    {
        $notification_array[] = 'Ваша <a href="/rent_view.php?num=' . $item['rent_id'] . '">арендная сделка</a> имеет отрицательную оценку и будет отменена после завершения голосования';
    }

    $sql = "SELECT COUNT(`country_id`) AS `count`
            FROM `country`
            WHERE `country_president_id`=$auth_user_id
            OR `country_vice_id`=$auth_user_id";
    $president_sql = f_igosja_mysqli_query($sql);

    $president_array = $president_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $president_array[0]['count'])
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS
                       `transfer_id`
                FROM `transfer`
                LEFT JOIN
                (
                    SELECT `transfervote_transfer_id`
                    FROM `transfervote`
                    WHERE `transfervote_transfer_id` IN
                    (
                        SELECT `transfer_id`
                        FROM `transfer`
                        WHERE `transfer_ready`=1
                        AND `transfer_checked`=0
                    )
                    AND `transfervote_user_id`=$auth_user_id
                ) AS `t1`
                ON `transfer_id`=`transfervote_transfer_id`
                WHERE `transfer_ready`=1
                AND `transfer_checked`=0
                AND `transfervote_transfer_id` IS NULL
                ORDER BY `transfer_id` ASC
                LIMIT 1";
        $transfer_sql = f_igosja_mysqli_query($sql);

        if (0 != $transfer_sql->num_rows)
        {
            $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

            $sql = "SELECT FOUND_ROWS() AS `count`";
            $total = f_igosja_mysqli_query($sql);
            $total = $total->fetch_all(MYSQLI_ASSOC);
            $total = $total[0]['count'];

            $notification_array[] = 'У вас есть <a href="/transfer_view.php?num=' . $transfer_array[0]['transfer_id'] . '">' . $total . ' ' . f_igosja_count_case($total, 'непроверенная трансферная сделка', 'непроверенные трансферные сделки', 'непроверенных трансферных сделкок') . '</a>';
        }

        $sql = "SELECT SQL_CALC_FOUND_ROWS
                       `rent_id`
                FROM `rent`
                LEFT JOIN
                (
                    SELECT `rentvote_rent_id`
                    FROM `rentvote`
                    WHERE `rentvote_rent_id` IN
                    (
                        SELECT `rent_id`
                        FROM `rent`
                        WHERE `rent_ready`=1
                        AND `rent_checked`=0
                    )
                    AND `rentvote_user_id`=$auth_user_id
                ) AS `t1`
                ON `rent_id`=`rentvote_rent_id`
                WHERE `rent_ready`=1
                AND `rent_checked`=0
                AND `rentvote_rent_id` IS NULL
                ORDER BY `rent_id` ASC
                LIMIT 1";
        $rent_sql = f_igosja_mysqli_query($sql);

        if (0 != $rent_sql->num_rows)
        {
            $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

            $sql = "SELECT FOUND_ROWS() AS `count`";
            $total = f_igosja_mysqli_query($sql);
            $total = $total->fetch_all(MYSQLI_ASSOC);
            $total = $total[0]['count'];

            $notification_array[] = 'У вас есть <a href="/rent_view.php?num=' . $rent_array[0]['rent_id'] . '">' . $total . ' ' . f_igosja_count_case($total, 'непроверенная арендная сделка', 'непроверенные арендные сделки', 'непроверенных арендных сделкок') . '</a>';
        }
    }
}

if (isset($auth_team_id))
{
    if ($num_get == $auth_team_id)
    {
        $sql = "SELECT `forumtheme_id`,
                       `forumtheme_last_date`,
                       `forumtheme_name`,
                       CEIL(`forumtheme_count_message`/20) AS `last_page`
                FROM `forumtheme`
                LEFT JOIN `forumgroup`
                ON `forumtheme_forumgroup_id`=`forumgroup_id`
                WHERE `forumgroup_forumchapter_id`=" . FORUMGROUP_NATIONAL . "
                AND `forumgroup_country_id`=$auth_country_id
                ORDER BY `forumtheme_last_date` DESC
                LIMIT 4";
        $forum_sql = f_igosja_mysqli_query($sql);

        $forum_array = $forum_sql->fetch_all(MYSQLI_ASSOC);
    }
    else
    {
        $sql = "SELECT `team_power_s_16`,
                       `team_power_s_21`,
                       `team_power_s_27`,
                       `team_price_base`,
                       `team_price_total`,
                       `team_power_vs`
                FROM `team`
                WHERE `team_id`=$auth_team_id
                LIMIT 1";
        $my_team_sql = f_igosja_mysqli_query($sql);

        $my_team_array = $my_team_sql->fetch_all(MYSQLI_ASSOC);
    }
}

$seo_title          = $team_array[0]['team_name'] . '. Профиль команды';
$seo_description    = $team_array[0]['team_name'] . '. Профиль команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' профиль команды';

include(__DIR__ . '/view/layout/main.php');