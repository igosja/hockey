<?php

/**
 * @var $auth_user_id
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_user_id;

include(__DIR__ . '/include/sql/user_view.php');

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               MIN(IF(`message_user_id_to`=$auth_user_id, `message_read`, 1)) AS `message_read`,
               `team_id`,
               `team_name`,
               `user_date_login`,
               `user_id`,
               `user_login`,
               `user_rating`
        FROM `message`
        LEFT JOIN `user`
        ON IF (`message_user_id_from`=$auth_user_id, `message_user_id_to`, `message_user_id_from`)=`user_id`
        LEFT JOIN `team`
        ON `user_id`=`team_user_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE (`message_user_id_from`=$auth_user_id
        OR `message_user_id_to`=$auth_user_id)
        AND `message_support_to`=0
        AND `message_support_from`=0
        GROUP BY `user_id`
        ORDER BY MIN(IF(`message_user_id_to`=$auth_user_id, `message_read`, 1)) ASC, MAX(`message_id`) DESC";
$message_sql = f_igosja_mysqli_query($sql);

$message_array = $message_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Личная переписка';
$seo_description    = 'Личная переписка на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'личная переписка';

include(__DIR__ . '/view/layout/main.php');