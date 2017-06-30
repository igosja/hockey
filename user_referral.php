<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_user_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_user_id;
}

include(__DIR__ . '/include/sql/user_view.php');

$sql = "SELECT `user_id`,
               `user_date_login`,
               `user_date_register`,
               `user_login`
        FROM `user`
        WHERE `user_referrer_id`=$num_get
        ORDER BY `user_id` DESC";
$referral_sql = f_igosja_mysqli_query($sql);

$referral_array = $referral_sql->fetch_all(1);

$seo_title          = $user_array[0]['user_login'] . '. Реферальная программа';
$seo_description    = $user_array[0]['user_login'] . '. Реферальная программа на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' реферальная программа';

include(__DIR__ . '/view/layout/main.php');