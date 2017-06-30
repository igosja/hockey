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

$sql = "SELECT `finance_date`,
               `finance_value`,
               `finance_value_after`,
               `finance_value_before`,
               `financetext_name`
        FROM `finance`
        LEFT JOIN `financetext`
        ON `finance_financetext_id`=`financetext_id`
        WHERE `finance_user_id`=$num_get
        AND `finance_season_id`=$igosja_season_id
        ORDER BY `finance_id` DESC";
$finance_sql = f_igosja_mysqli_query($sql);

$finance_array = $finance_sql->fetch_all(1);

$seo_title          = $user_array[0]['user_login'] . '. Финансы менеджера';
$seo_description    = $user_array[0]['user_login'] . '. Финансы менеджера на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $user_array[0]['user_login'] . ' финансы менеджера';

include(__DIR__ . '/view/layout/main.php');