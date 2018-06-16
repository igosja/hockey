<?php

/**
 * @var $auth_date_block_dealcomment integer
 * @var $auth_date_block_comment integer
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
               `transfer_age`,
               `transfer_cancel`,
               `transfer_checked`,
               `transfer_date`,
               `transfer_id`,
               ROUND(`transfer_price_buyer`/`transfer_player_price`*100) AS `transfer_percent`,
               `transfer_power`,
               `transfer_price_buyer`
        FROM `transfer`
        LEFT JOIN `player`
        ON `transfer_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `pl_country`
        ON `player_country_id`=`pl_country`.`country_id`
        LEFT JOIN `team` AS `bteam`
        ON `transfer_team_buyer_id`=`bteam`.`team_id`
        LEFT JOIN `stadium` AS `bstadium`
        ON `bteam`.`team_stadium_id`=`bstadium`.`stadium_id`
        LEFT JOIN `city` AS `bcity`
        ON `bstadium`.`stadium_city_id`=`bcity`.`city_id`
        LEFT JOIN `country` AS `bcountry`
        ON `bcity`.`city_country_id`=`bcountry`.`country_id`
        LEFT JOIN `user` AS `buser`
        ON `transfer_user_buyer_id`=`buser`.`user_id`
        LEFT JOIN `team` AS `steam`
        ON `transfer_team_seller_id`=`steam`.`team_id`
        LEFT JOIN `stadium` AS `sstadium`
        ON `steam`.`team_stadium_id`=`sstadium`.`stadium_id`
        LEFT JOIN `city` AS `scity`
        ON `sstadium`.`stadium_city_id`=`scity`.`city_id`
        LEFT JOIN `country` AS `scountry`
        ON `scity`.`city_country_id`=`scountry`.`country_id`
        LEFT JOIN `user` AS `suser`
        ON `transfer_user_seller_id`=`suser`.`user_id`
        WHERE `transfer_ready`=1
        AND `transfer_id`=$num_get
        LIMIT 1";
$transfer_sql = f_igosja_mysqli_query($sql);

if (0 == $transfer_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

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

        $sql = "SELECT COUNT(`transfer_id`) AS `check`
                FROM `transfer`
                WHERE `transfer_ready`=1
                AND `transfer_id`=$num_get
                AND `transfer_checked`=0
                LIMIT 1";
        $transfer_sql = f_igosja_mysqli_query($sql);

        $transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

        if (0 == $transfer_array[0]['check'])
        {
            redirect('/wrong_page.php');
        }

        $sql = "SELECT COUNT(`transfervote_transfer_id`) AS `check`
                FROM `transfervote`
                WHERE `transfervote_transfer_id`=$num_get
                AND `transfervote_user_id`=$auth_user_id";
        $transfervote_sql = f_igosja_mysqli_query($sql);

        $transfervote_array = $transfervote_sql->fetch_all(MYSQLI_ASSOC);

        if (0 != $transfervote_array[0]['check'])
        {
            $sql = "UPDATE `transfervote`
                    SET `transfervote_rating`=$rating
                    WHERE `transfervote_transfer_id`=$num_get
                    AND `transfervote_user_id`=$auth_user_id";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $sql = "INSERT INTO `transfervote`
                    SET `transfervote_rating`=$rating,
                        `transfervote_transfer_id`=$num_get,
                        `transfervote_user_id`=$auth_user_id";
            f_igosja_mysqli_query($sql);
        }

        f_igosja_session_front_flash_set('success', 'Ваш голос успешно сохранён.');

        if (isset($data['text']) && $auth_date_block_dealcomment < time() && $auth_date_block_comment < time())
        {
            $text = htmlspecialchars($data['text']);
            $text = trim($text);

            if (!empty($text))
            {
                $publish = true;

                $sql = "SELECT `transfercomment_text`,
                               `transfercomment_user_id`
                        FROM `transfercomment`
                        WHERE `transfercomment_transfer_id`=$num_get
                        ORDER BY `transfercomment_id` DESC
                        LIMIT 1";
                $check_sql = f_igosja_mysqli_query($sql);

                if (0 != $check_sql->num_rows)
                {
                    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                    if ($auth_user_id == $check_array[0]['transfercomment_user_id'] && $text == $check_array[0]['transfercomment_text'])
                    {
                        $publish = false;
                    }
                }

                if ($publish)
                {
                    $sql = "INSERT INTO `transfercomment`
                            SET `transfercomment_date`=UNIX_TIMESTAMP(),
                                `transfercomment_text`=?,
                                `transfercomment_transfer_id`=$num_get,
                                `transfercomment_user_id`=$auth_user_id";
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

        f_igosja_deal_redirect($auth_user_id);

        redirect('/transfer_view.php?num=' . $num_get);
    }
}

$sql = "SELECT `transferposition_transfer_id` AS `playerposition_player_id`,
               `position_name`,
               `position_short`
        FROM `transferposition`
        LEFT JOIN `position`
        ON `transferposition_position_id`=`position_id`
        WHERE `transferposition_transfer_id`=$num_get
        ORDER BY `transferposition_position_id` ASC";
$playerposition_sql = f_igosja_mysqli_query($sql);

$playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `transferspecial_level` AS `playerspecial_level`,
               `transferspecial_transfer_id` AS `playerspecial_player_id`,
               `special_name`,
               `special_short`
        FROM `transferspecial`
        LEFT JOIN `special`
        ON `transferspecial_special_id`=`special_id`
        WHERE `transferspecial_transfer_id`=$num_get
        ORDER BY `transferspecial_level` DESC, `transferspecial_special_id` ASC";
$playerspecial_sql = f_igosja_mysqli_query($sql);

$playerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`transfervote_rating`) AS `rating`
        FROM `transfervote`
        WHERE `transfervote_transfer_id`=$num_get
        AND `transfervote_rating`>0";
$rating_plus_sql = f_igosja_mysqli_query($sql);

$rating_plus_array = $rating_plus_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT SUM(`transfervote_rating`) AS `rating`
        FROM `transfervote`
        WHERE `transfervote_transfer_id`=$num_get
        AND `transfervote_rating`<0";
$rating_minus_sql = f_igosja_mysqli_query($sql);

$rating_minus_array = $rating_minus_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $transfer_array[0]['transfer_checked'] && isset($auth_user_id))
{
    $sql = "SELECT `transfervote_rating`
            FROM `transfervote`
            WHERE `transfervote_transfer_id`=$num_get
            AND `transfervote_user_id`=$auth_user_id";
    $rating_my_sql = f_igosja_mysqli_query($sql);

    $rating_my_array = $rating_my_sql->fetch_all(MYSQLI_ASSOC);
}

$sql = "SELECT `city_name`,
               `country_name`,
               `transferapplication_date`,
               `transferapplication_price`,
               `team_id`,
               `team_name`,
               `user_id`,
               `user_login`
        FROM `transferapplication`
        LEFT JOIN `team`
        ON `transferapplication_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        LEFT JOIN `user`
        ON `transferapplication_user_id`=`user_id`
        WHERE `transferapplication_transfer_id`=$num_get
        ORDER BY `transferapplication_price` DESC, `transferapplication_date` ASC";
$transferapplication_sql = f_igosja_mysqli_query($sql);

$transferapplication_array = $transferapplication_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `transfercomment_date`,
               `transfercomment_id`,
               `transfercomment_text`,
               `user_id`,
               `user_login`
        FROM `transfercomment`
        LEFT JOIN `user`
        ON `transfercomment_user_id`=`user_id`
        WHERE `transfercomment_transfer_id`=$num_get
        ORDER BY `transfercomment_id` ASC";
$transfercomment_sql = f_igosja_mysqli_query($sql);

$transfercomment_array = $transfercomment_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $transfer_array[0]['transfer_checked'])
{
    $alert_array = f_igosja_deal_alert($transfer_array[0]['steam_id'], $transfer_array[0]['suser_id'], $transfer_array[0]['bteam_id'], $transfer_array[0]['buser_id']);
}
else
{
    $alert_array = array();
}

$seo_title          = 'Трансферная сделка';
$seo_description    = 'Трансферная сделка на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'трансферная сделка';

include(__DIR__ . '/view/layout/main.php');