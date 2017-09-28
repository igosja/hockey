<?php

/**
 * @var $num_get integer
 */

$sql = "SELECT `country_finance`,
               `country_name`,
               `president`.`user_date_login` AS `president_date_login`,
               `president`.`user_id` AS `president_id`,
               `president`.`user_login` AS `president_login`,
               ROUND(IFNULL(COUNT(`rating_negative`), 0)/IFNULL(COUNT(`rating_total`), 1)*100) AS `rating_negative`,
               ROUND(IFNULL(COUNT(`rating_positive`), 0)/IFNULL(COUNT(`rating_total`), 1)*100) AS `rating_positive`,
               `vice`.`user_date_login` AS `vice_date_login`,
               `vice`.`user_id` AS `vice_id`,
               `vice`.`user_login` AS `vice_login`
        FROM `country`
        LEFT JOIN `user` AS `president`
        ON `country_president_id`=`president`.`user_id`
        LEFT JOIN `user` AS `vice`
        ON `country_vice_id`=`vice`.`user_id`
        LEFT JOIN
        (
            SELECT `city_country_id` AS `rating_positive_country_id`,
                   IFNULL(COUNT(`team_id`), 0) AS `rating_positive`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`stadium_id`
            WHERE `city_country_id`=$num_get
            AND `team_user_id`!=0
            AND `team_vote_president`=" . VOTERATING_POSITIVE. "
        ) AS `t1`
        ON `rating_positive_country_id`=`country_id`
        LEFT JOIN
        (
            SELECT `city_country_id` AS `rating_negative_country_id`,
                   IFNULL(COUNT(`team_id`), 0) AS `rating_negative`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`stadium_id`
            WHERE `city_country_id`=$num_get
            AND `team_user_id`!=0
            AND `team_vote_president`=" . VOTERATING_NEGATIVE. "
        ) AS `t2`
        ON `rating_negative_country_id`=`country_id`
        LEFT JOIN
        (
            SELECT `city_country_id` AS `rating_total_country_id`,
                   IFNULL(COUNT(`team_id`), 0) AS `rating_total`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`stadium_id`
            WHERE `city_country_id`=$num_get
            AND `team_user_id`!=0
        ) AS `t3`
        ON `rating_total_country_id`=`country_id`
        WHERE `country_id`=$num_get
        LIMIT 1";
$country_sql = f_igosja_mysqli_query($sql);

if (0 == $country_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$country_array = $country_sql->fetch_all(1);