<?php

/**
 * @var $igosja_season_id integer
 * @var $num_get integer
 */

$sql = "SELECT `country_name`,
               `division_id`,
               `division_name`,
               `national_finance`,
               `nationaltype_name`,
               `stadium_capacity`,
               `stadium_name`,
               `user_date_vip`,
               `user_id`,
               `user_login`,
               `user_name`,
               `user_surname`,
               `worldcup_place`
        FROM `national`
        LEFT JOIN `user`
        ON `national_user_id`=`user_id`
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
            ON `stadium_city_id`
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

$national_array = $national_sql->fetch_all(1);