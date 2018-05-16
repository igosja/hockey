<?php

include(__DIR__ . '/include/include.php');

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

if ($data = f_igosja_request_get('data'))
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

$where = "`transfer_ready`=0";

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
    $where = $where . " AND `player_country_id`=$country_id";
}

if ($position_id)
{
    $where = $where . " AND `player_id` IN
                        (
                            SELECT `playerposition_player_id`
                            FROM `playerposition`
                            WHERE `playerposition_position_id`=$position_id
                        )";
}

if ($power_max)
{
    $where = $where . " AND `player_power_nominal`<=$power_max";
}

if ($power_min)
{
    $where = $where . " AND `player_power_nominal`>=$power_min";
}

if ($price_max)
{
    $where = $where . " AND `transfer_price_seller`<=$price_max";
}

if ($price_min)
{
    $where = $where . " AND `transfer_price_seller`>=$price_min";
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

if (!$page = (int) f_igosja_request_get('page'))
{
    $page = 1;
}

$limit  = 50;
$offset = ($page - 1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `city_name`,
               `name_name`,
               `pl_country`.`country_id` AS `pl_country_id`,
               `pl_country`.`country_name` AS `pl_country_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`,
               `t_country`.`country_name` AS `t_country_name`,
               `team_id`,
               `team_name`,
               `transfer_date`,
               `transfer_price_seller`
        FROM `transfer`
        LEFT JOIN `player`
        ON `transfer_player_id`=`player_id`
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
        ORDER BY `transfer_id` ASC
        LIMIT $offset, $limit";

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

    $transfer_sql = $prepare->get_result();

    $prepare->close();
}
else
{
    $transfer_sql = f_igosja_mysqli_query($sql);
}

$count_transfer = $transfer_sql->num_rows;
$transfer_array = $transfer_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql);
$total = $total->fetch_all(MYSQLI_ASSOC);
$total = $total[0]['count'];

$count_page = ceil($total / $limit);

if (isset($auth_team_id))
{
    $sql = "SELECT `city_name`,
                   `name_name`,
                   `pl_country`.`country_id` AS `pl_country_id`,
                   `pl_country`.`country_name` AS `pl_country_name`,
                   `player_age`,
                   `player_id`,
                   `player_power_nominal`,
                   `surname_name`,
                   `t_country`.`country_name` AS `t_country_name`,
                   `team_id`,
                   `team_name`,
                   `transfer_date`,
                   `transfer_price_seller`
            FROM `transferapplication`
            LEFT JOIN `transfer`
            ON `transferapplication_transfer_id`=`transfer_id`
            LEFT JOIN `player`
            ON `transfer_player_id`=`player_id`
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
            WHERE `transfer_ready`=0
            AND `transferapplication_team_id`=$auth_team_id
            ORDER BY `transfer_id` ASC";
    $transferapplication_sql = f_igosja_mysqli_query($sql);

    $transferapplication_array = $transferapplication_sql->fetch_all(MYSQLI_ASSOC);
}
else
{
    $transferapplication_array = array();
}

$player_id = array();

foreach ($transfer_array as $item)
{
    $player_id[] = $item['player_id'];
}

foreach ($transferapplication_array as $item)
{
    $player_id[] = $item['player_id'];
}

if (count($player_id))
{
    $player_id = implode(', ', $player_id);

    $sql = "SELECT `playerposition_player_id`,
                   `position_name`,
                   `position_short`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id` IN ($player_id)";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_player_id`,
                   `special_name`,
                   `special_short`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id` IN ($player_id)
            ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $playerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
}

$sql = "SELECT `position_id`,
               `position_short`
        FROM `position`
        ORDER BY `position_id` ASC";
$position_sql = f_igosja_mysqli_query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        LEFT JOIN `city`
        ON `country_id`=`city_country_id`
        WHERE `city_country_id` IS NOT NULL
        AND `country_id`!=0
        GROUP BY `country_id`
        ORDER BY `country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = 'Трансфер хоккеистов';
$seo_description    = 'Трансфер хоккеистов на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'трансфер хоккеистов';

include(__DIR__ . '/view/layout/main.php');