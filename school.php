<?php

include (__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_team_id;

include (__DIR__ . '/include/sql/team_view_left.php');

$sql = "SELECT `baseschool_level`,
               `baseschool_player_count`,
               `baseschool_school_speed`,
               `baseschool_with_special`,
               `baseschool_with_style`
        FROM `baseschool`
        LEFT JOIN `team`
        ON `baseschool_id`=`team_baseschool_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$baseschool_sql = f_igosja_mysqli_query($sql);

$baseschool_array = $baseschool_sql->fetch_all(1);

if ($data = f_igosja_request_post('data'))
{
    $confirm_data = array('position' => array(), 'special' => array(), 'style' => array());

    if (isset($data['position_id']))
    {
        $position_id = (int) $data['position_id'];

        $sql = "SELECT `position_name`
                FROM `position`
                WHERE `position_id`=$position_id
                LIMIT 1";
        $position_sql = f_igosja_mysqli_query($sql);

        if ($position_sql->num_rows)
        {
            $sql = "SELECT COUNT(`school_id`) AS `count`
                    FROM `school`
                    WHERE `school_team_id`=$num_get
                    AND `school_ready`=0";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(1);
            $count_check = $check_array[0]['count'];

            if (0 == $count_check)
            {
                $position_array = $position_sql->fetch_all(1);

                $confirm_data['position'] = array(
                    'id' => $position_id,
                    'name' => $position_array[0]['position_name'],
                );
            }
        }
    }

    if (isset($data['special_id']))
    {
        $special_id = (int) $data['special_id'];

        $sql = "SELECT `special_name`
                FROM `special`
                WHERE `special_id`=$special_id
                LIMIT 1";
        $special_sql = f_igosja_mysqli_query($sql);

        if ($special_sql->num_rows)
        {
            $sql = "SELECT COUNT(`school_id`) AS `count`
                    FROM `school`
                    WHERE `school_team_id`=$num_get
                    AND `school_ready`=0";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(1);
            $count_check = $check_array[0]['count'];

            if (0 == $count_check)
            {
                $special_array = $special_sql->fetch_all(1);

                $confirm_data['special'] = array(
                    'id' => $special_id,
                    'name' => $special_array[0]['special_name'],
                );
            }
        }
    }

    if (isset($data['style_id']))
    {
        $style_id = (int) $data['style_id'];

        $sql = "SELECT `style_name`
                FROM `style`
                WHERE `style_id`=$style_id
                LIMIT 1";
        $style_sql = f_igosja_mysqli_query($sql);

        if ($style_sql->num_rows)
        {
            $sql = "SELECT COUNT(`school_id`) AS `count`
                    FROM `school`
                    WHERE `school_team_id`=$num_get
                    AND `school_ready`=0";
            $check_sql = f_igosja_mysqli_query($sql);

            $check_array = $check_sql->fetch_all(1);
            $count_check = $check_array[0]['count'];

            if (0 == $count_check)
            {
                $style_array = $style_sql->fetch_all(1);

                $confirm_data['style'] = array(
                    'id' => $style_id,
                    'name' => $style_array[0]['style_name'],
                );
            }
        }
    }

    if (isset($data['ok']))
    {
        $position_id    = $confirm_data['position']['id'];
        $special_id     = $confirm_data['special']['id'];
        $style_id       = $confirm_data['style']['id'];
        $day            = $baseschool_array[0]['baseschool_school_speed'];

        $sql = "INSERT INTO `school`
                SET `school_day`=$day,
                    `school_position_id`=$position_id,
                    `school_season_id`=$igosja_season_id,
                    `school_special_id`=$special_id,
                    `school_style_id`=$style_id,
                    `school_team_id`=$num_get";
        f_igosja_mysqli_query($sql);

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Изменения успешно сохранены.';

        refresh();
    }
}

$sql = "SELECT `position_name`,
               `school_day`,
               `special_name`,
               `style_name`
        FROM `school`
        LEFT JOIN `position`
        ON `school_position_id`=`position_id`
        LEFT JOIN `special`
        ON `school_special_id`=`special_id`
        LEFT JOIN `style`
        ON `school_style_id`=`style_id`
        WHERE `school_ready`=0
        AND `school_team_id`=$num_get
        LIMIT 1";
$school_sql = f_igosja_mysqli_query($sql);

$school_array = $school_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$player_sql = f_igosja_mysqli_query($sql);

$player_array = $player_sql->fetch_all(1);

$sql = "SELECT `position_id`,
               `position_name`
        FROM `position`
        ORDER BY `position_id` ASC";
$position_sql = f_igosja_mysqli_query($sql);

$position_array = $position_sql->fetch_all(1);

$sql = "SELECT `special_id`,
               `special_name`
        FROM `special`
        ORDER BY `special_id` ASC";
$special_sql = f_igosja_mysqli_query($sql);

$special_array = $special_sql->fetch_all(1);

$sql = "SELECT `style_id`,
               `style_name`
        FROM `style`
        WHERE `style_id`!=" . STYLE_NORMAL . "
        ORDER BY `style_id` ASC";
$style_sql = f_igosja_mysqli_query($sql);

$style_array = $style_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');