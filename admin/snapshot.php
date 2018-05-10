<?php

/**
 * @var $igosja_season_id
 */
include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $num_get = 1;
}

if ($season_id = (int) f_igosja_request_get('season_id'))
{
    $season_id = $igosja_season_id;
}

if (1 == $num_get)
{
    $select = '`snapshot_base`';
}
elseif (2 == $num_get)
{
    $select = '`snapshot_base_total`';
}
elseif (3 == $num_get)
{
    $select = '`snapshot_basemedical`';
}
elseif (4 == $num_get)
{
    $select = '`snapshot_basephisical`';
}
elseif (5 == $num_get)
{
    $select = '`snapshot_baseschool`';
}
elseif (6 == $num_get)
{
    $select = '`snapshot_basescout`';
}
elseif (7 == $num_get)
{
    $select = '`snapshot_basetraining`';
}
elseif (8 == $num_get)
{
    $select = '`snapshot_country`';
}
elseif (9 == $num_get)
{
    $select = '`snapshot_manager`';
}
elseif (10 == $num_get)
{
    $select = '`snapshot_manager_vip_percent`';
}
elseif (11 == $num_get)
{
    $select = '`snapshot_manager_with_team`';
}
elseif (12 == $num_get)
{
    $select = '`snapshot_player`';
}
elseif (13 == $num_get)
{
    $select = '`snapshot_player_age`';
}
elseif (14 == $num_get)
{
    $select = '`snapshot_player_c`';
}
elseif (15 == $num_get)
{
    $select = '`snapshot_player_gk`';
}
elseif (16 == $num_get)
{
    $select = '`snapshot_player_in_team`';
}
elseif (17 == $num_get)
{
    $select = '`snapshot_player_ld`';
}
elseif (18 == $num_get)
{
    $select = '`snapshot_player_lw`';
}
elseif (19 == $num_get)
{
    $select = '`snapshot_player_rd`';
}
elseif (20 == $num_get)
{
    $select = '`snapshot_player_rw`';
}
elseif (21 == $num_get)
{
    $select = '`snapshot_player_power`';
}
elseif (22 == $num_get)
{
    $select = '`snapshot_player_special_percent_no`';
}
elseif (23 == $num_get)
{
    $select = '`snapshot_player_special_percent_one`';
}
elseif (24 == $num_get)
{
    $select = '`snapshot_player_special_percent_two`';
}
elseif (25 == $num_get)
{
    $select = '`snapshot_player_special_percent_three`';
}
elseif (26 == $num_get)
{
    $select = '`snapshot_player_special_percent_four`';
}
elseif (27 == $num_get)
{
    $select = '`snapshot_player_special_percent_athletic`';
}
elseif (28 == $num_get)
{
    $select = '`snapshot_player_special_percent_combine`';
}
elseif (29 == $num_get)
{
    $select = '`snapshot_player_special_percent_idol`';
}
elseif (30 == $num_get)
{
    $select = '`snapshot_player_special_percent_leader`';
}
elseif (31 == $num_get)
{
    $select = '`snapshot_player_special_percent_power`';
}
elseif (32 == $num_get)
{
    $select = '`snapshot_player_special_percent_reaction`';
}
elseif (33 == $num_get)
{
    $select = '`snapshot_player_special_percent_shot`';
}
elseif (34 == $num_get)
{
    $select = '`snapshot_player_special_percent_speed`';
}
elseif (35 == $num_get)
{
    $select = '`snapshot_player_special_percent_tackle`';
}
elseif (36 == $num_get)
{
    $select = '`snapshot_player_with_position_percent`';
}
elseif (37 == $num_get)
{
    $select = '`snapshot_team`';
}
elseif (38 == $num_get)
{
    $select = '`snapshot_team_finance`';
}
elseif (39 == $num_get)
{
    $select = '`snapshot_team_to_manager`';
}
elseif (40 == $num_get)
{
    $select = '`snapshot_stadium`';
}

$date_array     = array();
$value_array    = array();

$sql = "SELECT FROM_UNIXTIME(`snapshot_date`, '%d %m %Y') AS `date`,
               $select AS `total`
        FROM `snapshot`
        WHERE `snapshot_season_id`=$season_id
        ORDER BY `snapshot_id` ASC";
$snapshot_sql = f_igosja_mysqli_query($sql);

$snapshot_array = $snapshot_sql->fetch_all(MYSQLI_ASSOC);

foreach ($snapshot_array as $item)
{
    $date_array[]   = $item['date'];
    $value_array[]  = $item['total'];
}

$snapshot_categories    = '"' . implode('","', $date_array) . '"';
$snapshot_data          = implode(',', $value_array);

include(__DIR__ . '/view/layout/main.php');