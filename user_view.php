<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = f_igosja_get('num'))
{
    if (!isset($auth_user_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_user_id;
}

$sql = "SELECT `country_name`,
               `sex_name`,
               `user_birth_day`,
               `user_birth_month`,
               `user_birth_year`,
               `user_city`,
               `user_date_login`,
               `user_date_register`,
               `user_finance`,
               `user_login`,
               `user_money`
        FROM `user`
        LEFT JOIN `sex`
        ON `user_sex_id`=`sex_id`
        LEFT JOIN `country`
        ON `user_country_id`=`country_id`
        WHERE `user_id`='$num_get'";
$user_sql = igosja_db_query($sql);

$user_array = $user_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');