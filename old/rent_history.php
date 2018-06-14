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

$where = "`rent_ready`=1";

if ($age_max)
{
    $where = $where . " AND `rent_age`<='$age_max'";
}

if ($age_min)
{
    $where = $where . " AND `rent_age`>='$age_min'";
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
    $where = $where . " AND `rent_power`<=$power_max";
}

if ($power_min)
{
    $where = $where . " AND `rent_power`>=$power_min";
}

if ($price_max)
{
    $where = $where . " AND `rent_price_buyer`<=$price_max";
}

if ($price_min)
{
    $where = $where . " AND `rent_price_buyer`>=$price_min";
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
               `bteam`.`team_id` AS `bteam_id`,
               `bteam`.`team_name` AS `bteam_name`,
               `name_name`,
               `pl_country`.`country_id` AS `pl_country_id`,
               `pl_country`.`country_name` AS `pl_country_name`,
               `steam`.`team_id` AS `steam_id`,
               `steam`.`team_name` AS `steam_name`,
               `surname_name`,
               `rent_age`,
               `rent_cancel`,
               `rent_id`,
               `rent_power`,
               `rent_price_buyer`
        FROM `rent`
        LEFT JOIN `player`
        ON `rent_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country` AS `pl_country`
        ON `player_country_id`=`pl_country`.`country_id`
        LEFT JOIN `team` AS `bteam`
        ON `rent_team_buyer_id`=`bteam`.`team_id`
        LEFT JOIN `team` AS `steam`
        ON `rent_team_seller_id`=`steam`.`team_id`
        WHERE $where
        ORDER BY `rent_date` DESC
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

    $rent_sql = $prepare->get_result();

    $prepare->close();
}
else
{
    $rent_sql = f_igosja_mysqli_query($sql);
}

$count_rent = $rent_sql->num_rows;
$rent_array = $rent_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql);
$total = $total->fetch_all(MYSQLI_ASSOC);
$total = $total[0]['count'];

$count_page = ceil($total / $limit);

$rent_id = array();

foreach ($rent_array as $item)
{
    $rent_id[] = $item['rent_id'];
}

if (count($rent_id))
{
    $rent_id = implode(', ', $rent_id);

    $sql = "SELECT `rentposition_rent_id` AS `playerposition_player_id`,
                   `position_name`,
                   `position_short`
            FROM `rentposition`
            LEFT JOIN `position`
            ON `rentposition_position_id`=`position_id`
            WHERE `rentposition_rent_id` IN ($rent_id)
            ORDER BY `rentposition_position_id` ASC";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `rentspecial_level` AS `playerspecial_level`,
                   `rentspecial_rent_id` AS `playerspecial_player_id`,
                   `special_name`,
                   `special_short`
            FROM `rentspecial`
            LEFT JOIN `special`
            ON `rentspecial_special_id`=`special_id`
            WHERE `rentspecial_rent_id` IN ($rent_id)
            ORDER BY `rentspecial_level` DESC, `rentspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $playerspecial_array = $playerspecial_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT SUM(`rentvote_rating`) AS `rating`,
                   `rentvote_rent_id`
            FROM `rentvote`
            WHERE `rentvote_rent_id` IN ($rent_id)
            AND `rentvote_rating`>0
            GROUP BY `rentvote_rent_id`";
    $rating_plus_sql = f_igosja_mysqli_query($sql);

    $rating_plus_array = $rating_plus_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT SUM(`rentvote_rating`) AS `rating`,
                   `rentvote_rent_id`
            FROM `rentvote`
            WHERE `rentvote_rent_id` IN ($rent_id)
            AND `rentvote_rating`<0
            GROUP BY `rentvote_rent_id`";
    $rating_minus_sql = f_igosja_mysqli_query($sql);

    $rating_minus_array = $rating_minus_sql->fetch_all(MYSQLI_ASSOC);
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
    $rating_plus_array      = array();
    $rating_minus_array     = array();
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

$seo_title          = 'Аренда хоккеистов';
$seo_description    = 'Аренда хоккеистов на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'аренда хоккеистов';

include(__DIR__ . '/view/layout/main.php');