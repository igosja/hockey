<?php

/**
 * @var $auth_team_id integer
 * @var $class string
 * @var $igosja_season_id integer
 * @var $phisical_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_team_id;

include(__DIR__ . '/include/sql/team_view_left.php');

$sql = "SELECT COUNT(`buildingbase_id`) AS `count`
        FROM `buildingbase`
        WHERE `buildingbase_ready`=0
        AND `buildingbase_team_id`=$auth_team_id
        AND `buildingbase_building_id` IN (" . BUILDING_BASE . ", " . BUILDING_BASEPHISICAL . ")";
$building_sql = f_igosja_mysqli_query($sql);

$building_array = $building_sql->fetch_all(1);

if ($building_array[0]['count'])
{
    $on_building = true;
}
else
{
    $on_building = false;
}

$sql = "SELECT `basephisical_change_count`,
               `basephisical_level`,
               `basephisical_tire_bonus`
        FROM `basephisical`
        LEFT JOIN `team`
        ON `basephisical_id`=`team_basephisical_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$basephisical_sql = f_igosja_mysqli_query($sql);

$basephisical_array = $basephisical_sql->fetch_all(1);

$sql = "SELECT COUNT(`phisicalchange_id`) AS `count`
        FROM `phisicalchange`
        WHERE `phisicalchange_team_id`=$num_get
        AND `phisicalchange_season_id`=$igosja_season_id";
$phisical_used_sql = f_igosja_mysqli_query($sql);

$phisical_used_array = $phisical_used_sql->fetch_all(1);

$phisical_available = $basephisical_array[0]['basephisical_change_count'] - $phisical_used_array[0]['count'];

$sql = "SELECT `phisical_id`,
               `phisical_value`
        FROM `phisical`
        ORDER BY `phisical_id` ASC";
$phisical_sql = f_igosja_mysqli_query($sql);

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
$shedule_sql = f_igosja_mysqli_query($sql);

$count_shedule = $shedule_sql->num_rows;
$shedule_array = $shedule_sql->fetch_all(1);

if ($count_shedule)
{
    $shedule_id = $shedule_array[0]['shedule_id'];
}
else
{
    $shedule_id = 0;
}

$sql = "SELECT `phisicalchange_player_id`,
               `phisicalchange_shedule_id`
        FROM `phisicalchange`
        WHERE `phisicalchange_team_id`=$num_get
        ORDER BY `phisicalchange_id` ASC";
$phisicalchange_sql = f_igosja_mysqli_query($sql);

$phisicalchange_array = $phisicalchange_sql->fetch_all(1);

$change_array = array();

foreach ($phisicalchange_array as $item)
{
    $change_array[$item['phisicalchange_player_id']][$item['phisicalchange_shedule_id']] = 1;
}

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
        WHERE `player_team_id`=$num_get";
$player_sql = f_igosja_mysqli_query($sql);

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

            if (isset($change_array[$player_array[$i]['player_id']][$shedule_array[$j]['shedule_id']]))
            {
                $class = 'phisical-bordered';

                $sql = "SELECT `phisical_opposite`
                        FROM `phisical`
                        WHERE `phisical_id`=$phisical_id
                        LIMIT 1";
                $opposite_sql = f_igosja_mysqli_query($sql);

                $opposite_array = $opposite_sql->fetch_all(1);

                $opposite_id = $opposite_array[0]['phisical_opposite'];
            }
            else
            {
                $class = '';
            }

            $player_phisical_array[] = array(
                'class'             => $class,
                'id'                => $player_array[$i]['player_id'] . '-' . $shedule_array[$j]['shedule_id'],
                'phisical_id'       => $phisical_id,
                'phisical_value'    => $phisical_array[$phisical_id],
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

            if (isset($change_array[$player_array[$i]['player_id']][$shedule_array[$j]['shedule_id']]))
            {
                $class = 'phisical-change-cell phisical-bordered';

                $sql = "SELECT `phisical_opposite`
                        FROM `phisical`
                        WHERE `phisical_id`=$phisical_id
                        LIMIT 1";
                $opposite_sql = f_igosja_mysqli_query($sql);

                $opposite_array = $opposite_sql->fetch_all(1);

                $phisical_id = $opposite_array[0]['phisical_opposite'];
            }
            elseif (in_array($class, array('phisical-change-cell phisical-bordered', 'phisical-change-cell phisical-yellow', 'phisical-bordered')))
            {
                $class = ($on_building ? '' : 'phisical-change-cell') . 'phisical-yellow';
            }
            else
            {
                $class = ($on_building ? '' : 'phisical-change-cell');
            }

            $player_phisical_array[] = array(
                'class'             => $class,
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

$player_id = array();

foreach ($player_array as $item)
{
    $player_id[] = $item['player_id'];
}

if (count($player_id))
{
    $player_id = implode(', ', $player_id);

    $sql = "SELECT `playerposition_player_id`,
                   `position_name`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id` IN ($player_id)
            ORDER BY `playerposition_position_id` ASC";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(1);

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_player_id`,
                   `special_name`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id` IN ($player_id)
            ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $playerspecial_array = $playerspecial_sql->fetch_all(1);
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
}

$seo_title          = $team_array[0]['team_name'] . '. Центр физической подготовки';
$seo_description    = $team_array[0]['team_name'] . '. Центр физической подготовки на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' центр физ. подготовки';

include(__DIR__ . '/view/layout/main.php');