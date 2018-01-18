<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 * @var $team_array array
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

if (0 == $auth_team_id)
{
    redirect('/team_ask.php');
}

$num_get = $auth_team_id;

include(__DIR__ . '/include/sql/team_view_left.php');

$sql = "SELECT COUNT(`buildingbase_id`) AS `count`
        FROM `buildingbase`
        WHERE `buildingbase_ready`=0
        AND `buildingbase_team_id`=$auth_team_id
        AND `buildingbase_building_id` IN (" . BUILDING_BASE . ", " . BUILDING_BASESCHOOL . ")";
$building_sql = f_igosja_mysqli_query($sql);

$building_array = $building_sql->fetch_all(MYSQLI_ASSOC);

if ($building_array[0]['count'])
{
    $on_building = true;
}
else
{
    $on_building = false;
}

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

$baseschool_array = $baseschool_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`school_id`) AS `count`
        FROM `school`
        WHERE `school_team_id`=$num_get
        AND `school_season_id`=$igosja_season_id";
$school_used_sql = f_igosja_mysqli_query($sql);

$school_used_array = $school_used_sql->fetch_all(MYSQLI_ASSOC);

$school_available = $baseschool_array[0]['baseschool_player_count'] - $school_used_array[0]['count'];

if ($data = f_igosja_request_post('data'))
{
    if ($on_building)
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'На базе сейчас идет строительство.';

        refresh();
    }
    elseif (0 == $school_available)
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'У вас нет юниоров для подготовки в спортшколе.';

        refresh();
    }

    $confirm_data = array('position' => array(), 'special' => array(), 'style' => array());

    $sql = "SELECT COUNT(`school_id`) AS `count`
            FROM `school`
            WHERE `school_team_id`=$num_get
            AND `school_ready`=0";
    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);
    $count_check = $check_array[0]['count'];

    if ($count_check)
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Нельзя готовить в спортшколе более одного игрока одновременно.';

        refresh();
    }

    if (isset($data['position_id']))
    {
        $position_id = (int) $data['position_id'];
    }
    else
    {
        $position_id = rand(POSITION_GK, POSITION_RW);
    }

    $sql = "SELECT `position_short`
            FROM `position`
            WHERE `position_id`=$position_id
            LIMIT 1";
    $position_sql = f_igosja_mysqli_query($sql);

    if (0 == $position_sql->num_rows)
    {
        $position_id = rand(POSITION_GK, POSITION_RW);

        $sql = "SELECT `position_short`
                FROM `position`
                WHERE `position_id`=$position_id
                LIMIT 1";
        $position_sql = f_igosja_mysqli_query($sql);
    }

    $position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

    $confirm_data['position'] = array(
        'id'    => $position_id,
        'name'  => $position_array[0]['position_short'],
    );

    if (isset($data['special_id']))
    {
        $special_id = (int) $data['special_id'];
    }
    else
    {
        $special_id = rand(SPECIAL_SPEED, SPECIAL_SHOT);
    }

    $sql = "SELECT `special_name`
            FROM `special`
            WHERE `special_id`=$special_id
            LIMIT 1";
    $special_sql = f_igosja_mysqli_query($sql);

    if (0 == $special_sql->num_rows)
    {
        $special_id = rand(SPECIAL_SPEED, SPECIAL_SHOT);

        $sql = "SELECT `special_name`
                FROM `special`
                WHERE `special_id`=$special_id
                LIMIT 1";
        $special_sql = f_igosja_mysqli_query($sql);
    }

    $special_array = $special_sql->fetch_all(MYSQLI_ASSOC);

    $confirm_data['special'] = array(
        'id'    => $special_id,
        'name'  => $special_array[0]['special_name'],
    );

    if (isset($data['style_id']))
    {
        $style_id = (int) $data['style_id'];
    }
    else
    {
        $style_id = rand(STYLE_POWER, STYLE_TECHNIQUE);
    }

    $sql = "SELECT `style_name`
            FROM `style`
            WHERE `style_id`=$style_id
            LIMIT 1";
    $style_sql = f_igosja_mysqli_query($sql);

    if (0 == $style_sql->num_rows)
    {
        $style_id = rand(STYLE_POWER, STYLE_TECHNIQUE);

        $sql = "SELECT `style_name`
                FROM `style`
                WHERE `style_id`=$style_id
                LIMIT 1";
        $style_sql = f_igosja_mysqli_query($sql);
    }

    $style_array = $style_sql->fetch_all(MYSQLI_ASSOC);

    $confirm_data['style'] = array(
        'id' => $style_id,
        'name' => $style_array[0]['style_name'],
    );

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

$sql = "SELECT `position_short`,
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

$count_school = $school_sql->num_rows;
$school_array = $school_sql->fetch_all(MYSQLI_ASSOC);

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

$player_array = $player_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `position_id`,
               `position_short`
        FROM `position`
        ORDER BY `position_id` ASC";
$position_sql = f_igosja_mysqli_query($sql);

$position_array = $position_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `special_id`,
               `special_name`
        FROM `special`
        ORDER BY `special_id` ASC";
$special_sql = f_igosja_mysqli_query($sql);

$special_array = $special_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `style_id`,
               `style_name`
        FROM `style`
        WHERE `style_id`!=" . STYLE_NORMAL . "
        ORDER BY `style_id` ASC";
$style_sql = f_igosja_mysqli_query($sql);

$style_array = $style_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $team_array[0]['team_name'] . '. Спортивная школа';
$seo_description    = $team_array[0]['team_name'] . '. Спортивная школа на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['team_name'] . ' спортивная школа';

include(__DIR__ . '/view/layout/main.php');