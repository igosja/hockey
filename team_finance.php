<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_team_id))
    {
        redirect('/wrong_page.php');
    }

    if (0 == $auth_team_id)
    {
        redirect('/team_ask.php');
    }

    $num_get = $auth_team_id;
}

include(__DIR__ . '/include/sql/team_view_left.php');
include(__DIR__ . '/include/sql/team_view_right.php');

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

$sql = "SELECT `finance_building_id`,
               `finance_capacity`,
               `finance_date`,
               `finance_level`,
               `finance_value`,
               `finance_value_after`,
               `finance_value_before`,
               `financetext_name`
        FROM `finance`
        LEFT JOIN `financetext`
        ON `finance_financetext_id`=`financetext_id`
        WHERE `finance_team_id`=$num_get
        AND `finance_season_id`=$season_id
        ORDER BY `finance_id` DESC";
$finance_sql = f_igosja_mysqli_query($sql);

$count_finance = $finance_sql->num_rows;
$finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

for ($i=0; $i<$count_finance; $i++)
{
    $text = $finance_array[$i]['financetext_name'];
    $text = str_replace(
        '{level}',
        $finance_array[$i]['finance_level'],
        $text
    );
    $text = str_replace(
        '{capacity}',
        $finance_array[$i]['finance_capacity'],
        $text
    );
    $building = '';
    if (BUILDING_BASE == $finance_array[$i]['finance_building_id']) {
        $building = 'база';
    } elseif (BUILDING_BASEMEDICAL == $finance_array[$i]['finance_building_id']) {
        $building = 'медцентр';
    } elseif (BUILDING_BASEPHISICAL == $finance_array[$i]['finance_building_id']) {
        $building = 'центр физподготовки';
    } elseif (BUILDING_BASESCHOOL == $finance_array[$i]['finance_building_id']) {
        $building = 'спортшкола';
    } elseif (BUILDING_BASESCOUT == $finance_array[$i]['finance_building_id']) {
        $building = 'скаут-центр';
    } elseif (BUILDING_BASETRAINING == $finance_array[$i]['finance_building_id']) {
        $building = 'тренировочный центр';
    }
    $text = str_replace(
        '{building}',
        $building,
        $text
    );

    $finance_array[$i]['financetext_name'] = $text;
}

$seo_title          = $team_array[0]['team_name'] . '. Финансы команды';
$seo_description    = $team_array[0]['team_name'] . '. Финансы команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' финансы команды';

include(__DIR__ . '/view/layout/main.php');