<?php

/**
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

if ($season_id > $igosja_season_id)
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`,
               `division_id`,
               `division_name`
        FROM `championship`
        LEFT JOIN `division`
        ON `championship_division_id`=`division_id`
        LEFT JOIN `country`
        ON `championship_country_id`=`country_id`
        WHERE `championship_season_id`=$season_id
        GROUP BY `country_id`, `division_id`
        ORDER BY `country_id` ASC, `division_id` ASC";
$championship_sql = f_igosja_mysqli_query($sql);

$championship_array = $championship_sql->fetch_all(MYSQLI_ASSOC);

$country_id     = 0;
$country_name   = '';
$country_array  = array();
$division_array = array();

foreach ($championship_array as $item)
{
    if ($country_id != $item['country_id'])
    {
        if ($country_id)
        {
            $country_array[] = array(
                'country_id'    => $country_id,
                'country_name'  => $country_name,
                'division'      => $division_array,
            );
        }

        $country_id     = $item['country_id'];
        $country_name   = $item['country_name'];
        $division_array = array();
    }

    $division_array[$item['division_id']] = $item['division_name'];
}

if ($country_id)
{
    $country_array[] = array(
        'country_id'    => $country_id,
        'country_name'  => $country_name,
        'division'      => $division_array,
    );
}

$sql = "SELECT `division_id`
        FROM `division`
        ORDER BY `division_id` ASC";
$division_sql = f_igosja_mysqli_query($sql);

$division_array = $division_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0, $count_country=count($country_array); $i<$count_country; $i++)
{
    foreach ($division_array as $division)
    {
        if (!isset($country_array[$i]['division'][$division['division_id']]))
        {
            $country_array[$i]['division'][$division['division_id']] = '-';
        }
    }
}

$seo_title          = 'Список турниров';
$seo_description    = 'Список турниров на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'список турниров';

include(__DIR__ . '/view/layout/main.php');