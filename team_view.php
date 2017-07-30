<?php

/**
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_team_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_team_id)
    {
        redirect('/team_ask.php');
    }

    $num_get = $auth_team_id;
}

include(__DIR__ . '/include/sql/team_view_left.php');
include(__DIR__ . '/include/sql/team_view_right.php');

$sql = "SELECT `country_id`,
               `country_name`,
               `line_color`,
               `name_name`,
               `phisical_id`,
               `phisical_value`,
               `player_age`,
               `player_game_row`,
               `player_id`,
               `player_power_nominal`,
               `player_power_old`,
               `player_power_real`,
               `player_price`,
               `player_tire`,
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
        LEFT JOIN `playerposition`
        ON `player_id`=`playerposition_player_id`
        LEFT JOIN `playerspecial`
        ON `player_id`=`playerspecial_player_id`
        LEFT JOIN `line`
        ON `player_line_id`=`line_id`
        WHERE `player_team_id`=$num_get
        ORDER BY `player_position_id` ASC";
$player_sql = f_igosja_mysqli_query($sql);

$player_array = $player_sql->fetch_all(1);

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

$rating_array = $rating_sql->fetch_all(1);

$player_id = array();

foreach ($player_array as $item)
{
    $player_id[] = $item['player_id'];
}

if (count($player_id))
{
    $player_id = implode(', ', $player_id);

    $sql = "SELECT `playerposition_player_id`,
                   `position_name`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id` IN ($player_id)
            ORDER BY `playerposition_position_id` ASC";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(1);

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_player_id`,
                   `special_name`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id` IN ($player_id)
            ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $playerspecial_array = $playerspecial_sql->fetch_all(1);
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
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
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE (`game_home_team_id`=$num_get
            OR `game_guest_team_id`=$num_get)
            AND `game_played`=0
            ORDER BY `shedule_id` ASC
            LIMIT 1";
    $check_game_send_sql = f_igosja_mysqli_query($sql);

    if ($check_game_send_sql->num_rows)
    {
        $check_game_send_array = $check_game_send_sql->fetch_all(1);

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
            LEFT JOIN `shedule`
            ON `game_shedule_id`=`shedule_id`
            WHERE (`game_home_team_id`=$num_get
            OR `game_guest_team_id`=$num_get)
            AND `game_played`=0
            ORDER BY `shedule_id` ASC
            LIMIT 1";
    $check_mood_sql = f_igosja_mysqli_query($sql);

    if ($check_mood_sql->num_rows)
    {
        $check_mood_array = $check_mood_sql->fetch_all(1);

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

    $vip_array = $vip_sql->fetch_all(1);

    if ($vip_array[0]['count'])
    {
        $notification_array[] = 'Ваш VIP-клуб заканчивается менее, чем через неделю - не забудьте <a href="/shop.php">продлить</a>.';
    }

    /*
    $sql = "SELECT `country_id`
            FROM `country`
            LEFT JOIN `city`
            ON `country_id`=`city_country_id`
            LEFT JOIN `stadium`
            ON `city_id`=`stadium_city_id`
            LEFT JOIN `team`
            ON `stadium_id`=`team_stadium_id`
            WHERE `team_id`=$num_get
            AND `country_president_id`=0
            LIMIT 1";
    $president_sql = f_igosja_mysqli_query($sql);

    if ($president_sql->num_rows)
    {
        $president_array = $president_sql->fetch_all(1);

        $notification_array[] = 'Открыт <a href="/president_application.php?num=' . $president_array[0]['country_id'] . '">прием заявок</a> от кандидатов на пост президента федерации вашей страны';
        $notification_array[] = 'В вашей стране проходят выборы президента федерации, результаты можно посмотреть <a href="/president_vote.php?num=' . 1 . '">здесь</a>';
    }

    $sql = "SELECT `country_id`
            FROM `country`
            LEFT JOIN `city`
            ON `country_id`=`city_country_id`
            LEFT JOIN `stadium`
            ON `city_id`=`stadium_city_id`
            LEFT JOIN `team`
            ON `stadium_id`=`team_stadium_id`
            WHERE `team_id`=$num_get
            AND `country_vice_id`=0
            AND `country_president_id`!=0
            LIMIT 1";
    $vice_sql = f_igosja_mysqli_query($sql);

    if ($vice_sql->num_rows)
    {
        $vice_array = $vice_sql->fetch_all(1);

        $notification_array[] = 'Открыт <a href="/president_application.php?num=' . $vice_array[0]['country_id'] . '">прием заявок</a> от кандидатов на пост заместителя президента федерации вашей страны';
        $notification_array[] = 'В вашей стране проходят выборы заместителя президента федерации, результаты можно посмотреть <a href="/president_vote.php?num=' . 1 . '">здесь</a>';
    }

    $sql = "SELECT `country_id`
            FROM `national`
            LEFT JOIN `country`
            ON `national_country_id`=`country_id`
            LEFT JOIN `city`
            ON `country_id`=`city_country_id`
            LEFT JOIN `stadium`
            ON `city_id`=`stadium_city_id`
            LEFT JOIN `team`
            ON `stadium_id`=`team_stadium_id`
            WHERE `team_id`=$num_get
            AND `national_vice_id`=0
            AND `national_user_id`!=0
            AND `national_nationaltype_id`=" . NATIONALTYPE_MAIN . "
            LIMIT 1";
    $vice_sql = f_igosja_mysqli_query($sql);

    if ($vice_sql->num_rows)
    {
        $vice_array = $vice_sql->fetch_all(1);

        $notification_array[] = 'Открыт <a href="/national_application.php?num=' . $vice_array[0]['country_id'] . '&type=' . NATIONALTYPE_MAIN . '">прием заявок</a> от кандидатов на пост заместителя тренера национальной сборной вашей страны';
        $notification_array[] = 'В вашей стране проходят выборы заместителя тренера молодёжной сборной, результаты можно посмотреть <a href="/national_vote.php?num=' . 1 . '&type=' . NATIONALTYPE_MAIN . '">здесь</a>';
    }

    $sql = "SELECT `country_id`
            FROM `national`
            LEFT JOIN `country`
            ON `national_country_id`=`country_id`
            LEFT JOIN `city`
            ON `country_id`=`city_country_id`
            LEFT JOIN `stadium`
            ON `city_id`=`stadium_city_id`
            LEFT JOIN `team`
            ON `stadium_id`=`team_stadium_id`
            WHERE `team_id`=$num_get
            AND `national_vice_id`=0
            AND `national_user_id`!=0
            AND `national_nationaltype_id`=" . NATIONALTYPE_21 . "
            LIMIT 1";
    $vice_sql = f_igosja_mysqli_query($sql);

    if ($vice_sql->num_rows)
    {
        $vice_array = $vice_sql->fetch_all(1);

        $notification_array[] = 'Открыт <a href="/national_application.php?num=' . $vice_array[0]['country_id'] . '&type=' . NATIONALTYPE_21 . '">прием заявок</a> от кандидатов на пост заместителя тренера молодёжной сборной вашей страны';
        $notification_array[] = 'В вашей стране проходят выборы заместителя тренера национальной сборной, результаты можно посмотреть <a href="/national_vote.php?num=' . 1 . '&type=' . NATIONALTYPE_21 . '">здесь</a>';
    }

    $sql = "SELECT `country_id`
            FROM `national`
            LEFT JOIN `country`
            ON `national_country_id`=`country_id`
            LEFT JOIN `city`
            ON `country_id`=`city_country_id`
            LEFT JOIN `stadium`
            ON `city_id`=`stadium_city_id`
            LEFT JOIN `team`
            ON `stadium_id`=`team_stadium_id`
            WHERE `team_id`=$num_get
            AND `national_vice_id`=0
            AND `national_user_id`!=0
            AND `national_nationaltype_id`=" . NATIONALTYPE_19 . "
            LIMIT 1";
    $vice_sql = f_igosja_mysqli_query($sql);

    if ($vice_sql->num_rows)
    {
        $vice_array = $vice_sql->fetch_all(1);

        $notification_array[] = 'Открыт <a href="/national_application.php?num=' . $vice_array[0]['country_id'] . '&type=' . NATIONALTYPE_19 . '">прием заявок</a> от кандидатов на пост заместителя тренера юношеской сборной вашей страны';
        $notification_array[] = 'В вашей стране проходят выборы заместителя тренера юношеской сборной, результаты можно посмотреть <a href="/national_vote.php?num=' . 1 . '&type=' . NATIONALTYPE_19 . '">здесь</a>';
    }

    $sql = "SELECT `basetraining_position_count`,
                   `basetraining_power_count`,
                   `basetraining_special_count`
            FROM `team`
            LEFT JOIN `basetraining`
            ON `team_basetraining_id`=`basetraining_id`
            WHERE `team_id`=$num_get
            LIMIT 1";
    $training_sql = f_igosja_mysqli_query($sql);

    $training_array = $training_sql->fetch_all(1);

    $notification_array[] = 'Ваш <a href="/training.php">тренировочный центр</a> простаивает - осталось ' . $training_array[0]['basetraining_power_count'] . ' баллов силы, ' . $training_array[0]['basetraining_special_count'] . ' спецвозможности, ' . $training_array[0]['basetraining_position_count'] . ' совмещение';
    $notification_array[] = 'Ваша <a href="/school.php">спортшкола</a> простаивает - можно подготовить ещё одного молодого игрока для основной команды';
*/
    $sql = "SELECT `shedule_nationalvotestep_id`
            FROM `shedule`
            WHERE `shedule_date`>UNIX_TIMESTAMP()
            ORDER BY `shedule_id` ASC
            LIMIT 1";
    $shedule_sql = f_igosja_mysqli_query($sql);

    if ($shedule_sql->num_rows)
    {
        $shedule_array = $shedule_sql->fetch_all(1);

        $auth_country_id = $team_array[0]['country_id'];

        if (NATIONALVOTESTEP_MAIN_APPLICATION == $shedule_array[0]['shedule_nationalvotestep_id'])
        {
            $notification_array[] = 'Открыт <a href="/national_application_country.php?type=' . NATIONALTYPE_MAIN . '">прием заявок</a> от кандидатов в тренеры национальных сборных.';
        }
        elseif (NATIONALVOTESTEP_MAIN_VOTE == $shedule_array[0]['shedule_nationalvotestep_id'])
        {
            $notification_array[] = 'В вашей стране проходят выборы тренера национальной сборной, результаты можно посмотреть <a href="/national_vote.php?type=' . NATIONALTYPE_MAIN . '&num=' . $auth_country_id . '">здесь</a>';
        }
        elseif (NATIONALVOTESTEP_21_APPLICATION == $shedule_array[0]['shedule_nationalvotestep_id'])
        {
            $notification_array[] = 'Открыт <a href="/national_application_country.php?type=' . NATIONALTYPE_21 . '">прием заявок</a> от кандидатов в тренеры молодежных сборных';
        }
        elseif (NATIONALVOTESTEP_21_VOTE == $shedule_array[0]['shedule_nationalvotestep_id'])
        {
            $notification_array[] = 'В вашей стране проходят выборы тренера молодёжной сборной, результаты можно посмотреть <a href="/national_vote.php?type=' . NATIONALTYPE_21 . '&num=' . $auth_country_id . '"">здесь</a>';
        }
        elseif (NATIONALVOTESTEP_19_APPLICATION == $shedule_array[0]['shedule_nationalvotestep_id'])
        {
            $notification_array[] = 'Открыт <a href="/national_application_country.php?type=' . NATIONALTYPE_19 . '">прием заявок</a> от кандидатов в тренеры юношеских сборных';
        }
        elseif (NATIONALVOTESTEP_19_VOTE == $shedule_array[0]['shedule_nationalvotestep_id'])
        {
            $notification_array[] = 'В вашей стране проходят выборы тренера юношеской сборной, результаты можно посмотреть <a href="/national_vote.php?type=' . NATIONALTYPE_19 . '&num=' . $auth_country_id . '"">здесь</a>';
        }
        else
        {
            for ($i=NATIONALTYPE_MAIN; $i<=NATIONALTYPE_19; $i++)
            {
                $sql = "SELECT COUNT(`national_id`) AS `count`
                        FROM `national`
                        WHERE `national_country_id`=$auth_country_id
                        AND `national_nationaltype_id`=$i
                        AND `national_user_id`!=0
                        AND `national_vice_id`=0
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                $check_array = $check_sql->fetch_all(1);

                if ($check_array[0]['count'])
                {
                    $sql = "SELECT COUNT(`electionnationalvice_id`) AS `count`
                        FROM `electionnationalvice`
                        WHERE `electionnationalvice_country_id`=$auth_country_id
                        AND `electionnationalvice_nationaltype_id`=$i
                        AND `electionnationalvice_electionstatus_id` IN (
                            " . ELECTIONSTATUS_CANDIDATES . ",
                            " . ELECTIONSTATUS_OPEN . "
                        )";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(1);

                    if (0 == $check_array[0]['count'])
                    {
                        $sql = "INSERT INTO `electionnationalvice`
                            SET `electionnationalvice_country_id`=$auth_country_id,
                                `electionnationalvice_date`=UNIX_TIMESTAMP(),
                                `electionnationalvice_nationaltype_id`=$i";
                        f_igosja_mysqli_query($sql);
                    }
                }
            }

            $sql = "SELECT `electionnationalvice_electionstatus_id`,
                           `electionnationalvice_nationaltype_id`
                    FROM `electionnationalvice`
                    WHERE `electionnationalvice_country_id`=$auth_country_id
                    AND `electionnationalvice_electionstatus_id` IN (
                        " . ELECTIONSTATUS_CANDIDATES . ",
                        " . ELECTIONSTATUS_OPEN . "
                    )";
            $election_sql = f_igosja_mysqli_query($sql);

            $election_array = $election_sql->fetch_all(1);

            foreach ($election_array as $item)
            {
                if (NATIONALTYPE_MAIN == $item['electionnationalvice_nationaltype_id'])
                {
                    if (ELECTIONSTATUS_CANDIDATES == $item['electionnationalvice_electionstatus_id'])
                    {
                        $notification_array[] = 'В вашей стране открыт <a href="/national_vice_application.php?type=' . NATIONALTYPE_MAIN  . '&num=' . $auth_country_id . '">прием заявок</a> от кандидатов в заместители тренера национальной сборной';
                    }
                    elseif (ELECTIONSTATUS_OPEN == $item['electionnationalvice_electionstatus_id'])
                    {
                        $notification_array[] = 'В вашей стране проходят выборы заместитетя тренера национальной сборной, результаты можно посмотреть <a href="/national_vice_vote.php?type=' . NATIONALTYPE_MAIN . '&num=' . $auth_country_id . '"">здесь</a>';
                    }
                }
                elseif (NATIONALTYPE_21 == $item['electionnationalvice_nationaltype_id'])
                {
                    if (ELECTIONSTATUS_CANDIDATES == $item['electionnationalvice_electionstatus_id'])
                    {
                        $notification_array[] = 'В вашей стране открыт <a href="/national_vice_application.php?type=' . NATIONALTYPE_21  . '&num=' . $auth_country_id . '">прием заявок</a> от кандидатов в заместители тренера молодёжной сборной';
                    }
                    elseif (ELECTIONSTATUS_OPEN == $item['electionnationalvice_electionstatus_id'])
                    {
                        $notification_array[] = 'В вашей стране проходят выборы заместитетя тренера молодёжной сборной, результаты можно посмотреть <a href="/national_vice_vote.php?type=' . NATIONALTYPE_21 . '&num=' . $auth_country_id . '"">здесь</a>';
                    }
                }
                elseif (NATIONALTYPE_19 == $item['electionnationalvice_nationaltype_id'])
                {
                    if (ELECTIONSTATUS_CANDIDATES == $item['electionnationalvice_electionstatus_id'])
                    {
                        $notification_array[] = 'В вашей стране открыт <a href="/national_vice_application.php?type=' . NATIONALTYPE_19  . '&num=' . $auth_country_id . '">прием заявок</a> от кандидатов в заместители тренера юношеской сборной';
                    }
                    elseif (ELECTIONSTATUS_OPEN == $item['electionnationalvice_electionstatus_id'])
                    {
                        $notification_array[] = 'В вашей стране проходят выборы заместитетя тренера юношеской сборной, результаты можно посмотреть <a href="/national_vice_vote.php?type=' . NATIONALTYPE_19 . '&num=' . $auth_country_id . '"">здесь</a>';
                    }
                }
            }
        }

        $sql = "SELECT COUNT(`country_id`) AS `count`
                FROM `country`
                WHERE `country_id`=$auth_country_id
                AND `country_president_id`=0
                AND `country_vice_id`=0
                LIMIT 1";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(1);

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

            $check_array = $check_sql->fetch_all(1);

            if (0 == $check_array[0]['count'])
            {
                $sql = "INSERT INTO `electionpresident`
                        SET `electionpresident_country_id`=$auth_country_id,
                            `electionpresident_date`=UNIX_TIMESTAMP()";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT `electionpresident_electionstatus_id`
                FROM `electionpresident`
                WHERE `electionpresident_country_id`=$auth_country_id
                AND `electionpresident_electionstatus_id` IN (
                    " . ELECTIONSTATUS_CANDIDATES . ",
                    " . ELECTIONSTATUS_OPEN . "
                )";
        $election_sql = f_igosja_mysqli_query($sql);

        $election_array = $election_sql->fetch_all(1);

        foreach ($election_array as $item)
        {
            if (ELECTIONSTATUS_CANDIDATES == $item['electionpresident_electionstatus_id'])
            {
                $notification_array[] = 'В вашей стране открыт <a href="/president_application.php?num=' . $auth_country_id . '">прием заявок</a> от кандидатов президентов федерации';
            }
            elseif (ELECTIONSTATUS_OPEN == $item['electionpresident_electionstatus_id'])
            {
                $notification_array[] = 'В вашей стране проходят выборы презитента федерации, результаты можно посмотреть <a href="/president_vote.php?num=' . $auth_country_id . '"">здесь</a>';
            }
        }

        $sql = "SELECT COUNT(`country_id`) AS `count`
                FROM `country`
                WHERE `country_id`=$auth_country_id
                AND `country_president_id`!=0
                AND `country_vice_id`=0
                LIMIT 1";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(1);

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

            $check_array = $check_sql->fetch_all(1);

            if (0 == $check_array[0]['count'])
            {
                $sql = "INSERT INTO `electionpresidentvice`
                        SET `electionpresidentvice_country_id`=$auth_country_id,
                            `electionpresidentvice_date`=UNIX_TIMESTAMP()";
                f_igosja_mysqli_query($sql);
            }
        }

        $sql = "SELECT `electionpresidentvice_electionstatus_id`
                FROM `electionpresidentvice`
                WHERE `electionpresidentvice_country_id`=$auth_country_id
                AND `electionpresidentvice_electionstatus_id` IN (
                    " . ELECTIONSTATUS_CANDIDATES . ",
                    " . ELECTIONSTATUS_OPEN . "
                )";
        $election_sql = f_igosja_mysqli_query($sql);

        $election_array = $election_sql->fetch_all(1);

        foreach ($election_array as $item)
        {
            if (ELECTIONSTATUS_CANDIDATES == $item['electionpresidentvice_electionstatus_id'])
            {
                $notification_array[] = 'В вашей стране открыт <a href="/president_vice_application.php?num=' . $auth_country_id . '">прием заявок</a> от кандидатов заместителей президента федерации';
            }
            elseif (ELECTIONSTATUS_OPEN == $item['electionpresidentvice_electionstatus_id'])
            {
                $notification_array[] = 'В вашей стране проходят выборы заместителя презитента федерации, результаты можно посмотреть <a href="/president_vice_vote.php?num=' . $auth_country_id . '"">здесь</a>';
            }
        }
    }
}

$seo_title          = $team_array[0]['team_name'] . '. Профиль команды';
$seo_description    = $team_array[0]['team_name'] . '. Профиль команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' профиль команды';

include(__DIR__ . '/view/layout/main.php');