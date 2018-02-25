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
        LEFT JOIN
        (
            SELECT `city_country_id`,
                   `stadium_capacity`,
                   `stadium_name`
            FROM `stadium`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `national`
            ON `city_country_id`=`national_country_id`
            WHERE `national_id`=$num_get
            ORDER BY `stadium_capacity` DESC, `stadium_id` ASC
            LIMIT 1
        ) AS `t2`
        ON `city_country_id`=`country_id`
        WHERE `national_id`=$num_get
        LIMIT 1";
$national_sql = f_igosja_mysqli_query($sql);

if (0 == $national_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$national_array = $national_sql->fetch_all(MYSQLI_ASSOC);