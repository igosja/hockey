<?php

include (__DIR__ . '/include/include.php');

$bind_param         = '';
$bind_param_array   = array();
$age_max            = 0;
$age_min            = 0;
$country_id         = 0;
$name               = '';
$position_id        = 0;
$power_max          = 0;
$power_min          = 0;
$price_min          = 0;
$price_max          = 0;
$surname            = '';

if ($data = f_igosja_get('data'))
{
    $age_max        = (int) $data['age_max'];
    $age_min        = (int) $data['age_min'];
    $country_id     = (int) $data['country_id'];
    $name           = trim($data['name_name']);
    $position_id    = (int) $data['position_id'];
    $power_max      = (int) $data['power_max'];
    $power_min      = (int) $data['power_min'];
    $price_min      = (int) $data['price_min'];
    $price_max      = (int) $data['price_max'];
    $surname        = trim($data['surname_name']);
}

$where = "`player_team_id`!='0'";

if ($age_max)
{
    $where = $where . " AND `player_age`<='$age_max'";
}

if ($age_min)
{
    $where = $where . " AND `player_age`>='$age_min'";
}

if ($country_id)
{
    $where = $where . " AND `player_country_id`='$country_id'";
}

if ($power_max)
{
    $where = $where . " AND `player_power_nominal`<='$power_max'";
}

if ($power_min)
{
    $where = $where . " AND `player_power_nominal`>='$power_min'";
}

if ($price_max)
{
    $where = $where . " AND `player_price`<='$price_max'";
}

if ($price_min)
{
    $where = $where . " AND `player_price`>='$price_min'";
}

if ($price_min)
{
    $where = $where . " AND `player_price`>='$price_min'";
}

if ($name)
{
    $where              = $where . " AND `name_name` LIKE ?";
    $bind_param         = $bind_param . 's';
    $bind_param_array[] = '%' . $name . '%';
}

if ($surname)
{
    $where              = $where . " AND `surname_name` LIKE ?";
    $bind_param         = $bind_param . 's';
    $bind_param_array[] = '%' . $surname . '%';
}

$sql = "SELECT `city_name`,
               `t_country`.`country_name` AS `t_country_name`,
               `name_name`,
               `pl_country`.`country_id` AS `pl_country_id`,
               `pl_country`.`country_name` AS `pl_country_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `player_price`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `pl_country`
        ON `player_country_id`=`pl_country`.`country_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country` AS `t_country`
        ON `city_country_id`=`t_country`.`country_id`
        WHERE $where
        ORDER BY `player_id` ASC";
if (count($bind_param_array))
{
    $prepare = $mysqli->prepare($sql);

    if (1 == count($bind_param_array))
    {
        $prepare->bind_param($bind_param, $bind_param_array[0]);
    }
    else
    {
        $prepare->bind_param($bind_param, $bind_param_array[0], $bind_param_array[1]);
    }

    $prepare->execute();

    $player_sql = $prepare->get_result();

    $prepare->close();
}
else
{
    $player_sql = igosja_db_query($sql);
}

$player_array = $player_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');