<?php

/**
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/country_view.php');

$sql = "SELECT `leaguedistribution_group`,
               `leaguedistribution_qualification_3`,
               `leaguedistribution_qualification_2`,
               `leaguedistribution_qualification_1`,
               `leaguedistribution_season_id`
        FROM `leaguedistribution`
        WHERE `leaguedistribution_country_id`=$num_get
        ORDER BY `leaguedistribution_season_id` DESC";
$leaguedistribution_sql = f_igosja_mysqli_query($sql);

$leaguedistribution_array = $leaguedistribution_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $country_array[0]['country_name'] . '. Лига чемпионов';
$seo_description    = $country_array[0]['country_name'] . '. Лига чемпионов на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' лига чемпионов';

include(__DIR__ . '/view/layout/main.php');