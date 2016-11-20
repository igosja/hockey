<?php

include (__DIR__ . '/include/include.php');

$auth_team_id = 25;

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

if (0 == $auth_team_id)
{
    redirect('/team_ask.php');
}

$num_get = $auth_team_id;

$sql = "SELECT `phisical_id`,
               `phisical_value`
        FROM `phisical`
        ORDER BY `phisical_id` ASC";
$phisical_sql = igosja_db_query($sql);

$phisical_sql = $phisical_sql->fetch_all(1);

$phisical_array = array();

foreach ($phisical_sql as $item)
{
    $phisical_array[$item['phisical_id']] = $item['phisical_value'];
}

$sql = "SELECT `shedule_date`,
               `shedule_id`
        FROM `shedule`
        WHERE `shedule_date`>UNIX_TIMESTAMP()
        AND `shedule_tournamenttype_id`!='" . TOURNAMENTTYPE_CONFERENCE . "'
        ORDER BY `shedule_id` ASC";
$shedule_sql = igosja_db_query($sql);

$count_shedule = $shedule_sql->num_rows;
$shedule_array = $shedule_sql->fetch_all(1);

$sql = "SELECT `name_name`,
               `phisical_id`,
               `phisical_value`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `phisical`
        ON `player_phisical_id`=`phisical_id`
        WHERE `player_team_id`='$num_get'";
$player_sql = igosja_db_query($sql);

$count_player = $player_sql->num_rows;
$player_array = $player_sql->fetch_all(1);

for ($i=0; $i<$count_player; $i++)
{
    $player_phisical_array = array();

    for ($j=0; $j<$count_shedule; $j++)
    {
        if (0 == $j)
        {
            $phisical_id = $player_array[$i]['phisical_id'];

            $player_phisical_array[] = array(
                'class'             => '',
                'id'                => $player_array[$i]['player_id'] . '-' . $shedule_array[$j]['shedule_id'],
                'phisical_id'       => $phisical_id,
                'phisical_value'    => $player_array[$i]['phisical_value'],
                'player_id'         => $player_array[$i]['player_id'],
                'shedule_id'        => $shedule_array[$j]['shedule_id'],
            );
        }
        else
        {
            $phisical_id++;

            if (20 < $phisical_id)
            {
                $phisical_id = $phisical_id - 20;
            }

            $player_phisical_array[] = array(
                'class'             => 'phisical-change-cell',
                'id'                => $player_array[$i]['player_id'] . '-' . $shedule_array[$j]['shedule_id'],
                'phisical_id'       => $phisical_id,
                'phisical_value'    => $phisical_array[$phisical_id],
                'player_id'         => $player_array[$i]['player_id'],
                'shedule_id'        => $shedule_array[$j]['shedule_id'],
            );
        }
    }

    $player_array[$i]['phisical_array'] = $player_phisical_array;
}

include (__DIR__ . '/view/layout/main.php');