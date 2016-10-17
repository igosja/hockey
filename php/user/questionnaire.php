<?php

$num_get = 1;

$sql = "SELECT `country_name`,
               `sex_name`,
               `user_birth_day`,
               `user_birth_month`,
               `user_birth_year`,
               `user_city`,
               `user_country_id`,
               `user_date_login`,
               `user_date_register`,
               `user_email`,
               `user_finance`,
               `user_login`,
               `user_money`,
               `user_name`,
               `user_sex_id`,
               `user_surname`
        FROM `user`
        LEFT JOIN `sex`
        ON `user_sex_id`=`sex_id`
        LEFT JOIN `country`
        ON `user_country_id`=`country_id`
        WHERE `user_id`='$num_get'";
$user_sql = igosja_db_query($sql);

$user_array = $user_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_name` ASC";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

$sql = "SELECT `sex_id`,
               `sex_name`
        FROM `sex`
        ORDER BY `sex_id` ASC";
$sex_sql = igosja_db_query($sql);

$sex_array = $sex_sql->fetch_all(1);