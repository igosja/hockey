<?php

/**
 * @var $auth_country_id integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (!$auth_country_id)
{
    redirect('/team_ask.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

if ($num_get != $auth_country_id)
{
    redirect('/wrong_page.php');
}

if (!$type_get = (int) f_igosja_request_get('type'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/country_view.php');

$sql = "SELECT COUNT(`national_id`) AS `check`
        FROM `national`
        WHERE `national_country_id`=$num_get
        AND `national_nationaltype_id`=$type_get
        AND `national_user_id`=0
        LIMIT 1";
$check_sql = f_igosja_mysqli_query($sql);

$chech_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $chech_array[0]['check'])
{
    redirect('/wrong_page.php');
}

$sql = "SELECT COUNT(`electionnational_id`) AS `check`
        FROM `electionnational`
        WHERE `electionnational_country_id`=$num_get
        AND `electionnational_electionstatus_id`=" . ELECTIONSTATUS_OPEN . "
        AND `electionnational_nationaltype_id`=$type_get";
$check_sql = f_igosja_mysqli_query($sql);

$chech_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if ($chech_array[0]['check'])
{
    redirect('/national_vote.php?num=' . $num_get . '&type=' . $type_get);
}

$sql = "SELECT COUNT(`national_id`) AS `check`
        FROM `national`
        WHERE `national_user_id`=$auth_user_id";
$check_sql = f_igosja_mysqli_query($sql);

$check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

if (0 != $check_array[0]['check'])
{
    f_igosja_session_front_flash_set('error', 'Можно быть тренером только в одной сборной.');

    redirect('/team_view.php');
}

$sql = "SELECT `electionnational_id`
        FROM `electionnational`
        WHERE `electionnational_country_id`=$num_get
        AND `electionnational_electionstatus_id`=" . ELECTIONSTATUS_CANDIDATES . "
        AND `electionnational_nationaltype_id`=$type_get
        LIMIT 1";
$electionnational_sql = f_igosja_mysqli_query($sql);

if ($electionnational_sql->num_rows)
{
    $electionnational_array = $electionnational_sql->fetch_all(MYSQLI_ASSOC);

    $electionnational_id = $electionnational_array[0]['electionnational_id'];
}
else
{
    $sql = "INSERT INTO `electionnational`
            SET `electionnational_country_id`=$num_get,
                `electionnational_date`=UNIX_TIMESTAMP(),
                `electionnational_nationaltype_id`=$type_get";
    f_igosja_mysqli_query($sql);

    $electionnational_id = $mysqli->insert_id;
}

if (NATIONALTYPE_MAIN == $type_get)
{
    $max_age = 39;
}
elseif (NATIONALTYPE_21 == $type_get)
{
    $max_age = 21;
}
else
{
    $max_age = 19;
}

if ($data = f_igosja_request_post('data'))
{
    $application_player_id = array();

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
            $error_array[] = 'В заявке должно быть ' . $count_player . ' ' . $position_short_2;
        }
        else
        {
            foreach ($data[$array_key] as $item)
            {
                $player_id = (int) $item;

                $application_player_id[] = $player_id;

                $sql = "SELECT COUNT(`player_id`) AS `count`
                        FROM `player`
                        WHERE `player_id`=$player_id
                        AND `player_position_id`=$position
                        AND `player_country_id`=$num_get
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

    $text = trim($data['text']);

    if (empty($text))
    {
        $error_array[] = 'Добавьте текст программы';
    }

    if (!isset($error_array))
    {
        $sql = "SELECT `electionnationalapplication_id`
                FROM `electionnationalapplication`
                WHERE `electionnationalapplication_user_id`=$auth_user_id
                AND `electionnationalapplication_electionnational_id`=$electionnational_id";
        $electionnationalapplication_sql = f_igosja_mysqli_query($sql);

        if ($electionnationalapplication_sql->num_rows)
        {
            $electionnationalapplication_array = $electionnationalapplication_sql->fetch_all(MYSQLI_ASSOC);

            $electionnationalapplication_id = $electionnationalapplication_array[0]['electionnationalapplication_id'];

            $sql = "UPDATE `electionnationalapplication`
                    SET `electionnationalapplication_text`=?
                    WHERE `electionnationalapplication_id`=$electionnationalapplication_id
                    LIMIT 1";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();

            $sql = "DELETE FROM `electionnationalapplicationplayer`
                    WHERE `electionnationalapplicationplayer_electionnationalapplication_id`=$electionnational_id";
            f_igosja_mysqli_query($sql);
        }
        else
        {
            $sql = "INSERT INTO `electionnationalapplication`
                    SET `electionnationalapplication_date`=UNIX_TIMESTAMP(),
                        `electionnationalapplication_electionnational_id`=$electionnational_id,
                        `electionnationalapplication_text`=?,
                        `electionnationalapplication_user_id`=$auth_user_id";
            $prepare = $mysqli->prepare($sql);
            $prepare->bind_param('s', $text);
            $prepare->execute();

            $electionnationalapplication_id = $mysqli->insert_id;
        }

        $values = array();

        foreach ($application_player_id as $item)
        {
            $values[] = '(' . $electionnationalapplication_id . ', ' . $item . ')';
        }

        $values = implode(',', $values);

        $sql = "INSERT INTO `electionnationalapplicationplayer`
                (
                    `electionnationalapplicationplayer_electionnationalapplication_id`,
                    `electionnationalapplicationplayer_player_id`
                )
                VALUES $values;";
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
        AND `player_country_id`=$num_get
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 10";
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
        AND `player_country_id`=$num_get
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 25";
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
        AND `player_country_id`=$num_get
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 25";
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
        AND `player_country_id`=$num_get
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 25";
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
        AND `player_country_id`=$num_get
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 25";
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
        AND `player_country_id`=$num_get
        AND `player_age`<=$max_age
        AND `player_team_id`!=0
        ORDER BY `player_power_nominal_s` DESC, `player_id` ASC
        LIMIT 25";
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

$applicationplayer_array = array();

$sql = "SELECT `electionnationalapplication_id`,
               `electionnationalapplication_text`
        FROM `electionnationalapplication`
        WHERE `electionnationalapplication_electionnational_id`=$electionnational_id
        AND `electionnationalapplication_user_id`=$auth_user_id
        LIMIT 1";
$electionnationalapplication_sql = f_igosja_mysqli_query($sql);

$electionnationalapplication_array = $electionnationalapplication_sql->fetch_all(MYSQLI_ASSOC);

if ($electionnationalapplication_sql->num_rows)
{
    $electionnationalapplication_id = $electionnationalapplication_array[0]['electionnationalapplication_id'];

    $sql = "SELECT `electionnationalapplicationplayer_player_id`
            FROM `electionnationalapplicationplayer`
            WHERE `electionnationalapplicationplayer_electionnationalapplication_id`=$electionnationalapplication_id";
    $electionnationalapplicationplayer_sql = f_igosja_mysqli_query($sql);

    $electionnationalapplicationplayer_array = $electionnationalapplicationplayer_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($electionnationalapplicationplayer_array as $item)
    {
        $applicationplayer_array[] = $item['electionnationalapplicationplayer_player_id'];
    }
}

$seo_title          = 'Подача заявки на управление сборной';
$seo_description    = 'Подача заявки на управление сборной на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'подача заявки на управление сборной';

include(__DIR__ . '/view/layout/main.php');