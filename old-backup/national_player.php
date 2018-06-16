<?php

/**
 * @var $auth_country_id integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_national_id))
{
    redirect('/wrong_page.php');
}

if (0 == $auth_national_id)
{
    redirect('/wrong_page.php');
}

$num_get = $auth_national_id;

include(__DIR__ . '/include/sql/national_view_left.php');
include(__DIR__ . '/include/sql/national_view_right.php');

$country_id = $national_array[0]['country_id'];
$max_age    = 39;

if ($data = f_igosja_request_post('data'))
{
    $substitule_player_id = array();

    for ($position=POSITION_GK; $position<=POSITION_RW; $position++)
    {
        if (POSITION_GK == $position)
        {
            $array_key          = 'gk';
            $count_player       = 2;
            $position_short_1    = 'вратарей';
            $position_short_2    = 'вратаря';
            $position_short_3    = 'Вратари';
        }
        elseif (POSITION_LD == $position)
        {
            $array_key          = 'ld';
            $count_player       = 5;
            $position_short_1    = 'левых защитников';
            $position_short_2    = 'левых защитников';
            $position_short_3    = 'Левые защитники';
        }
        elseif (POSITION_RD == $position)
        {
            $array_key          = 'rd';
            $count_player       = 5;
            $position_short_1    = 'правых защитников';
            $position_short_2    = 'правых защитников';
            $position_short_3    = 'Правые защитники';
        }
        elseif (POSITION_LW == $position)
        {
            $array_key          = 'lw';
            $count_player       = 5;
            $position_short_1    = 'левых нападающих';
            $position_short_2    = 'левых нападающих';
            $position_short_3    = 'Левые нападающие';
        }
        elseif (POSITION_C == $position)
        {
            $array_key          = 'c';
            $count_player       = 5;
            $position_short_1    = 'центральных нападающих';
            $position_short_2    = 'центральных нападающих';
            $position_short_3    = 'Центральные нападающие';
        }
        else
        {
            $array_key          = 'rw';
            $count_player       = 5;
            $position_short_1    = 'правых нападающих';
            $position_short_2    = 'правых нападающих';
            $position_short_3    = 'Правые нападающие';
        }

        if (!isset($data[$array_key]))
        {
            $error_array[] = 'Нужно выбрать ' . $position_short_1;
        }
        elseif ($count_player != count($data[$array_key]))
        {
            $error_array[] = 'В команде должно быть ' . $count_player . ' ' . $position_short_2;
        }
        else
        {
            foreach ($data[$array_key] as $item)
            {
                $player_id = (int) $item;

                $substitule_player_id[] = $player_id;

                $sql = "SELECT COUNT(`player_id`) AS `count`
                        FROM `player`
                        WHERE `player_id`=$player_id
                        AND `player_position_id`=$position
                        AND `player_country_id`=$country_id
                        AND `player_team_id`!=0
                        AND `player_age`<=$max_age";
                $check_sql = f_igosja_mysqli_query($sql);

                $chech_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                if (0 == $chech_array[0]['count'])
                {
                    $error_array[] = $position_short_3 . ' выбраны неправильно';
                }
            }
        }
    }

    if (!isset($error_array))
    {
        $sql = "UPDATE `player`
                SET `player_national_id`=0
                WHERE `player_national_id`=$num_get";
        f_igosja_mysqli_query($sql);

        $player_id = array();

        foreach ($substitule_player_id as $item)
        {
            $player_id[] = $item;
        }

        $player_id = implode(',', $player_id);

        $sql = "UPDATE `player`
                SET `player_national_id`=$num_get
                WHERE `player_id` IN ($player_id);";
        f_igosja_mysqli_query($sql);

        f_igosja_session_front_flash_set('success', 'Изменения успшено сохранены.');

        refresh();
    }
}

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `team_id`,
               `team_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `player_position_id`=" . POSITION_GK . "
        AND `player_country_id`=$country_id
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 20";
$gk_sql = f_igosja_mysqli_query($sql);

$gk_array = $gk_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `team_id`,
               `team_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `player_position_id`=" . POSITION_LD . "
        AND `player_country_id`=$country_id
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 50";
$ld_sql = f_igosja_mysqli_query($sql);

$ld_array = $ld_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `team_id`,
               `team_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `player_position_id`=" . POSITION_RD . "
        AND `player_country_id`=$country_id
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 50";
$rd_sql = f_igosja_mysqli_query($sql);

$rd_array = $rd_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `team_id`,
               `team_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `player_position_id`=" . POSITION_LW . "
        AND `player_country_id`=$country_id
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 50";
$lw_sql = f_igosja_mysqli_query($sql);

$lw_array = $lw_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `team_id`,
               `team_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `player_position_id`=" . POSITION_C . "
        AND `player_country_id`=$country_id
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 50";
$c_sql = f_igosja_mysqli_query($sql);

$c_array = $c_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `city_name`,
               `country_id`,
               `country_name`,
               `team_id`,
               `team_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `team`
        ON `player_team_id`=`team_id`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `player_position_id`=" . POSITION_RW . "
        AND `player_country_id`=$country_id
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 50";
$rw_sql = f_igosja_mysqli_query($sql);

$rw_array = $rw_sql->fetch_all(MYSQLI_ASSOC);

$player_id = array();

foreach ($gk_array as $item)
{
    $player_id[] = $item['player_id'];
}

foreach ($ld_array as $item)
{
    $player_id[] = $item['player_id'];
}

foreach ($rd_array as $item)
{
    $player_id[] = $item['player_id'];
}

foreach ($lw_array as $item)
{
    $player_id[] = $item['player_id'];
}

foreach ($c_array as $item)
{
    $player_id[] = $item['player_id'];
}

foreach ($rw_array as $item)
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

$nationalplayer_array = array();

$sql = "SELECT `player_id`
        FROM `player`
        WHERE `player_national_id`=$num_get";
$player_sql = f_igosja_mysqli_query($sql);

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

foreach ($player_array as $item)
{
    $nationalplayer_array[] = $item['player_id'];
}

$seo_title          = 'Изменение состава сборной';
$seo_description    = 'Изменение состава сборной на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'изменение состава сборной';

include(__DIR__ . '/view/layout/main.php');