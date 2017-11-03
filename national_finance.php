<?php

/**
 * @var $auth_national_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_national_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_national_id)
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_national_id;
}

include(__DIR__ . '/include/sql/national_view_left.php');
include(__DIR__ . '/include/sql/national_view_right.php');

$sql = "SELECT `finance_date`,
               `finance_value`,
               `finance_value_after`,
               `finance_value_before`,
               `financetext_name`
        FROM `finance`
        LEFT JOIN `financetext`
        ON `finance_financetext_id`=`financetext_id`
        WHERE `finance_national_id`=$num_get
        AND `finance_season_id`=$igosja_season_id
        ORDER BY `finance_id` DESC";
$finance_sql = f_igosja_mysqli_query($sql);

$finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $national_array[0]['country_name'] . '. Финансы команды';
$seo_description    = $national_array[0]['country_name'] . '. Финансы команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $national_array[0]['country_name'] . ' финансы команды';

include(__DIR__ . '/view/layout/main.php');