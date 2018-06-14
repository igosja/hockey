<?php

/**
 * @var $num_get integer
 */

$sql = "SELECT `country_name`,
               `sex_name`,
               `user_birth_day`,
               `user_birth_month`,
               `user_birth_year`,
               `user_city`,
               `user_date_login`,
               `user_date_register`,
               `user_date_vip`,
               `user_finance`,
               `user_holiday`,
               `user_id`,
               `user_login`,
               `user_money`,
               `user_name`,
               `user_rating`,
               `user_surname`
        FROM `user`
        LEFT JOIN `sex`
        ON `user_sex_id`=`sex_id`
        LEFT JOIN `country`
        ON `user_country_id`=`country_id`
        WHERE `user_id`=$num_get";
$user_sql = f_igosja_mysqli_query($sql);

if (0 == $user_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$user_array = $user_sql->fetch_all(MYSQLI_ASSOC);