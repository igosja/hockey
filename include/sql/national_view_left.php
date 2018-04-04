<?php

/**
 * @var $igosja_season_id integer
 * @var $num_get integer
 */

$sql = "SELECT `country_id`,
               `country_name`,
               `division_id`,
               `division_name`,
               `national_finance`,
               `nationaltype_name`,
               `stadium_capacity`,
               `stadium_name`,
               `coach`.`user_date_vip` AS `user_date_vip`,
               `coach`.`user_id` AS `user_id`,
               `coach`.`user_login` AS `user_login`,
               `coach`.`user_name` AS `user_name`,
               `coach`.`user_surname` AS `user_surname`,
               `vice`.`user_date_vip` AS `vice_user_date_vip`,
               `vice`.`user_id` AS `vice_user_id`,
               `vice`.`user_login` AS `vice_user_login`,
               `vice`.`user_name` AS `vice_user_name`,
               `vice`.`user_surname` AS `vice_user_surname`,
               `worldcup_place`
        FROM `national`
        LEFT JOIN `user` AS `coach`
        ON `national_user_id`=`coach`.`user_id`
        LEFT JOIN `user` AS `vice`
        ON `national_vice_id`=`vice`.`user_id`
        LEFT JOIN `country`
        ON `national_country_id`=`country_id`
        LEFT JOIN `nationaltype`
        ON `national_nationaltype_id`=`nationaltype_id`
        LEFT JOIN
        (
            SELECT `worldcup_place`,
                   `worldcup_national_id`,
                   `division_id`,
                   `division_name`
            FROM `worldcup`
            LEFT JOIN `division`
            ON `worldcup_division_id`=`division_id`
            WHERE `worldcup_national_id`=$num_get
            AND `worldcup_season_id`=$igosja_season_id
        ) AS `t1`
        ON `national_id`=`worldcup_national_id`
        LEFT JOIN `stadium`
        ON `national_stadium_id`=`stadium_id`
        WHERE `national_id`=$num_get
        LIMIT 1";
$national_sql = f_igosja_mysqli_query($sql);

if (0 == $national_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

$country_id = $national_array[0]['country_id'];

$sql = "SELECT COUNT(`team_id`) AS `total`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `city_country_id`=$country_id
        AND `team_user_id`!=0
        AND `team_vote_national`=" . VOTERATING_POSITIVE;
$rating_positive_sql = f_igosja_mysqli_query($sql);

$rating_positive_array = $rating_positive_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`team_id`) AS `total`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `city_country_id`=$country_id
        AND `team_user_id`!=0
        AND `team_vote_national`=" . VOTERATING_NEGATIVE;
$rating_negative_sql = f_igosja_mysqli_query($sql);

$rating_negative_array = $rating_negative_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT IF(COUNT(`team_id`)=0, 1, COUNT(`team_id`)) AS `total`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        WHERE `city_country_id`=$country_id
        AND `team_user_id`!=0";
$rating_total_sql = f_igosja_mysqli_query($sql);

$rating_total_array = $rating_total_sql->fetch_all(MYSQLI_ASSOC);

$rating_positive    = round($rating_positive_array[0]['total'] / $rating_total_array[0]['total'] * 100);
$rating_negative    = round($rating_negative_array[0]['total'] / $rating_total_array[0]['total'] * 100);
$rating_neutral     = 100 - $rating_positive - $rating_negative;