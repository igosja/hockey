<?php

/**
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `bcity`.`city_name` AS `bcity_name`,
               `bcountry`.`country_name` AS `bcountry_name`,
               `bteam`.`team_id` AS `bteam_id`,
               `bteam`.`team_name` AS `bteam_name`,
               `buser`.`user_id` AS `buser_id`,
               `buser`.`user_login` AS `buser_login`,
               `name_name`,
               `pl_country`.`country_id` AS `pl_country_id`,
               `pl_country`.`country_name` AS `pl_country_name`,
               `player_id`,
               `scity`.`city_name` AS `scity_name`,
               `scountry`.`country_name` AS `scountry_name`,
               `steam`.`team_id` AS `steam_id`,
               `steam`.`team_name` AS `steam_name`,
               `suser`.`user_id` AS `suser_id`,
               `suser`.`user_login` AS `suser_login`,
               `surname_name`,
               `rent_age`,
               `rent_cancel`,
               `rent_checked`,
               `rent_date`,
               `rent_day`,
               `rent_id`,
               `rent_power`,
               `rent_price_buyer`
        FROM `rent`
        LEFT JOIN `player`
        ON `rent_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `pl_country`
        ON `player_country_id`=`pl_country`.`country_id`
        LEFT JOIN `team` AS `bteam`
        ON `rent_team_buyer_id`=`bteam`.`team_id`
        LEFT JOIN `stadium` AS `bstadium`
        ON `bteam`.`team_stadium_id`=`bstadium`.`stadium_id`
        LEFT JOIN `city` AS `bcity`
        ON `bstadium`.`stadium_city_id`=`bcity`.`city_id`
        LEFT JOIN `country` AS `bcountry`
        ON `bcity`.`city_country_id`=`bcountry`.`country_id`
        LEFT JOIN `user` AS `buser`
        ON `rent_user_buyer_id`=`buser`.`user_id`
        LEFT JOIN `team` AS `steam`
        ON `rent_team_seller_id`=`steam`.`team_id`
        LEFT JOIN `stadium` AS `sstadium`
        ON `steam`.`team_stadium_id`=`sstadium`.`stadium_id`
        LEFT JOIN `city` AS `scity`
        ON `sstadium`.`stadium_city_id`=`scity`.`city_id`
        LEFT JOIN `country` AS `scountry`
        ON `scity`.`city_country_id`=`scountry`.`country_id`
        LEFT JOIN `user` AS `suser`
        ON `rent_user_seller_id`=`suser`.`user_id`
        WHERE `rent_ready`=1
        AND `rent_id`=$num_get
        LIMIT 1";
$rent_sql = f_igosja_mysqli_query($sql);

if (0 == $rent_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    if (isset($auth_user_id))
    {
        if (!isset($data['rating']))
        {
            f_igosja_session_front_flash_set('error', 'Укажите свою оценку сделки.');
        }

        $rating = (int) $data['rating'];

        $sql = "SELECT COUNT(`country_id`) AS `count`
                FROM `country`
                WHERE `country_president_id`=$auth_user_id
                OR `country_vice_id`=$auth_user_id";
        $check_sql = f_igosja_mysqli_query($sql);

        $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

        if (0 == $check_array[0]['count'])
        {
            if ($rating > 0)
            {
                $rating = 1;
            }
            else
            {
                $rating = -1;
            }
        }
        else
        {
            if ($rating > 0)
            {
                $rating = 10;
            }
            else
            {
                $rating = -10;
            }
        }

        $sql = "SELECT COUNT(`rent_id`) AS `check`
                FROM `rent`
                WHERE `rent_ready`=1
                AND `rent_id`=$num_get
                AND `rent_checked`=0
                LIMIT 1";
        $rent_sql = f_igosja_mysqli_query($sql);

        $rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

        if (0 == $rent_array[0]['check'])
        {
            redirect('/wrong_page.php');
        }

        $sql = "SELECT COUNT(`rentvote_rent_id`) AS `check`
                FROM `rentvote`
                WHERE `rentvote_rent_id`=$num_get
                AND `rentvote_user_id`=$auth_user_id";
        $rentvote_sql = f_igosja_mysqli_query($sql);

        $rentvote_array = $rentvote_sql->fetch_all(MYSQLI_ASSOC);

        if (0 != $rentvote_array[0]['check'])
        {
            $sql = "UPDATE `rentvote`
                    SET `rentvote_rating`=$rating
                    WHERE `rentvote_rent_id`=$num_get
                    AND `rentvote_user_id`=$auth_user_id";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $sql = "INSERT INTO `rentvote`
                    SET `rentvote_rating`=$rating,
                        `rentvote_rent_id`=$num_get,
                        `rentvote_user_id`=$auth_user_id";
            f_igosja_mysqli_query($sql);
        }

        f_igosja_session_front_flash_set('success', 'Ваш голос успешно сохранён.');

        if (isset($data['text']))
        {
            $text = htmlspecialchars($data['text']);
            $text = trim($text);

            if (!empty($text))
            {
                $publish = true;

                $sql = "SELECT `rentcomment_text`,
                               `rentcomment_user_id`
                        FROM `rentcomment`
                        WHERE `rentcomment_rent_id`=$num_get
                        ORDER BY `rentcomment_id` DESC
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                if (0 != $check_sql->num_rows)
                {
                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    if ($auth_user_id == $check_array[0]['rentcomment_user_id'] && $text == $check_array[0]['rentcomment_text'])
                    {
                        $publish = false;
                    }
                }

                if ($publish)
                {
                    $sql = "INSERT INTO `rentcomment`
                            SET `rentcomment_date`=UNIX_TIMESTAMP(),
                                `rentcomment_rent_id`=$num_get,
                                `rentcomment_text`=?,
                                `rentcomment_user_id`=$auth_user_id";
                    $prepare = $mysqli->prepare($sql);
                    $prepare->bind_param('s', $text);
                    $prepare->execute();
                    $prepare->close();
                }
            }
        }

        if (in_array($rating, array(1, -1)))
        {
            refresh();
        }

        $sql = "SELECT `transfer_id`
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

            redirect('/transfer_view.php?num=' . $transfer_array[0]['transfer_id']);
        }

        $sql = "SELECT `rent_id`
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

            redirect('/rent_view.php?num=' . $rent_array[0]['rent_id']);
        }

        redirect('/transfer_view.php?num=' . $num_get);
    }
}

$sql = "SELECT `rentposition_rent_id` AS `playerposition_player_id`,
               `position_name`,
               `position_short`
        FROM `rentposition`
        LEFT JOIN `position`
        ON `rentposition_position_id`=`position_id`
        WHERE `rentposition_rent_id`=$num_get
        ORDER BY `rentposition_position_id` ASC";
$playerposition_sql = f_igosja_mysqli_query($sql);

$playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `rentspecial_level` AS `playerspecial_level`,
               `rentspecial_rent_id` AS `playerspecial_player_id`,
               `special_name`,
               `special_short`
        FROM `rentspecial`
        LEFT JOIN `special`
        ON `rentspecial_special_id`=`special_id`
        WHERE `rentspecial_rent_id`=$num_get
        ORDER BY `rentspecial_level` DESC, `rentspecial_special_id` ASC";
$playerspecial_sql = f_igosja_mysqli_query($sql);

$playerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`rentvote_rating`) AS `rating`
        FROM `rentvote`
        WHERE `rentvote_rent_id`=$num_get
        AND `rentvote_rating`>0";
$rating_plus_sql = f_igosja_mysqli_query($sql);

$rating_plus_array = $rating_plus_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`rentvote_rating`) AS `rating`
        FROM `rentvote`
        WHERE `rentvote_rent_id`=$num_get
        AND `rentvote_rating`<0";
$rating_minus_sql = f_igosja_mysqli_query($sql);

$rating_minus_array = $rating_minus_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $rent_array[0]['rent_checked'] && isset($auth_user_id))
{
    $sql = "SELECT `rentvote_rating`
            FROM `rentvote`
            WHERE `rentvote_rent_id`=$num_get
            AND `rentvote_user_id`=$auth_user_id";
    $rating_my_sql = f_igosja_mysqli_query($sql);

    $rating_my_array = $rating_my_sql->fetch_all(MYSQLI_ASSOC);
}

$sql = "SELECT `city_name`,
               `country_name`,
               `rentapplication_date`,
               `rentapplication_day`,
               `rentapplication_price`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `rentapplication`
        LEFT JOIN `team`
        ON `rentapplication_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `user`
        ON `rentapplication_user_id`=`user_id`
        WHERE `rentapplication_rent_id`=$num_get
        ORDER BY `rentapplication_price`*`rentapplication_day` DESC, `rentapplication_date` ASC";
$rentapplication_sql = f_igosja_mysqli_query($sql);

$rentapplication_array = $rentapplication_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `rentcomment_date`,
               `rentcomment_text`,
               `user_id`,
               `user_login`
        FROM `rentcomment`
        LEFT JOIN `user`
        ON `rentcomment_user_id`=`user_id`
        WHERE `rentcomment_rent_id`=$num_get
        ORDER BY `rentcomment_id` ASC";
$rentcomment_sql = f_igosja_mysqli_query($sql);

$rentcomment_array = $rentcomment_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Арендная сделка';
$seo_description    = 'Арендная сделка на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'арендная сделка';

include(__DIR__ . '/view/layout/main.php');