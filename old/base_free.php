<?php

/**
 * @var $auth_team_id integer
 * @var $auth_user_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_team_id;

include(__DIR__ . '/include/sql/team_view_left.php');

$buildingbase_array = array();

$sql = "SELECT `buildingbase_building_id`,
               `buildingbase_id`
        FROM `buildingbase`
        WHERE `buildingbase_team_id`=$num_get
        AND `buildingbase_ready`=0";
$buildingbase_sql = f_igosja_mysqli_query($sql);

$count_buildingbase = $buildingbase_sql->num_rows;

if ($count_buildingbase)
{
    $buildingbase_array = $buildingbase_sql->fetch_all(MYSQLI_ASSOC);
}

$sql = "SELECT `base_id`,
               `base_level`,
               `base_maintenance_base`+
               (`basemedical_level`+
               `basephisical_level`+
               `baseschool_level`+
               `basescout_level`+
               `basetraining_level`)*
               `base_maintenance_slot` AS `base_maintenance`,
               `base_price_buy`,
               `base_slot_max`,
               `base_slot_min`,
               `basemedical_level`+
               `basephisical_level`+
               `baseschool_level`+
               `basescout_level`+
               `basetraining_level` AS `base_slot_used`,
               `basemedical_id`,
               `basemedical_level`,
               `basemedical_tire`,
               `basephisical_change_count`,
               `basephisical_id`,
               `basephisical_level`,
               `basephisical_tire_bonus`,
               `baseschool_id`,
               `baseschool_level`,
               `baseschool_player_count`,
               `basescout_id`,
               `basescout_level`,
               `basescout_my_style_count`,
               `basetraining_id`,
               `basetraining_level`,
               `basetraining_position_count`,
               `basetraining_power_count`,
               `basetraining_special_count`,
               `basetraining_training_speed_max`,
               `basetraining_training_speed_min`,
               `team_finance`,
               `team_free_base`
        FROM `team`
        LEFT JOIN `base`
        ON `team_base_id`=`base_id`
        LEFT JOIN `basemedical`
        ON `team_basemedical_id`=`basemedical_id`
        LEFT JOIN `basephisical`
        ON `team_basephisical_id`=`basephisical_id`
        LEFT JOIN `baseschool`
        ON `team_baseschool_id`=`baseschool_id`
        LEFT JOIN `basescout`
        ON `team_basescout_id`=`basescout_id`
        LEFT JOIN `basetraining`
        ON `team_basetraining_id`=`basetraining_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$base_sql = f_igosja_mysqli_query($sql);

$base_array = $base_sql->fetch_all(MYSQLI_ASSOC);

if (isset($auth_team_id) && $auth_team_id == $num_get)
{
    if ($building_id = (int) f_igosja_request_get('building_id'))
    {
        if ($count_buildingbase)
        {
            f_igosja_session_front_flash_set('error', 'На базе уже идет строительство.');

            redirect('/base_free.php');
        }
        else
        {
            if (!$constructiontype_id = (int) f_igosja_request_get('constructiontype_id'))
            {
                $constructiontype_id = CONSTRUCTION_BUILD;
            }

            if (CONSTRUCTION_BUILD == $constructiontype_id)
            {
                if (BUILDING_BASE == $building_id)
                {
                    $level = $base_array[0]['base_id'];
                    $level++;

                    $sql = "SELECT `base_level`,
                                   `base_slot_min`
                            FROM `base`
                            WHERE `base_id`=$level
                            LIMIT 1";
                    $baseinfo_sql = f_igosja_mysqli_query($sql);

                    if (0 == $baseinfo_sql->num_rows)
                    {
                        f_igosja_session_front_flash_set('error', 'Вы имеете здание максимального уровня.');

                        redirect('/base_free.php');
                    }
                    elseif (f_igosja_base_is_training($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В тренировочном центре тренируются игроки.');

                        redirect('/base_free.php');
                    }
                    elseif (f_igosja_base_is_school($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В спортшколе идет подготовка игрока.');

                        redirect('/base_free.php');
                    }
                    elseif (f_igosja_base_is_scout($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В скаутцентре идет изучение игроков.');

                        redirect('/base_free.php');
                    }
                    else
                    {
                        $baseinfo_array = $baseinfo_sql->fetch_all(MYSQLI_ASSOC);

                        if ($baseinfo_array[0]['base_slot_min'] > $base_array[0]['base_slot_used'])
                        {
                            f_igosja_session_front_flash_set('error', 'Минимальное количество занятых слотов должно быть не меньше <span class="strong">' . $baseinfo_array[0]['base_slot_min'] . '</span>.');

                            redirect('/base_free.php');
                        }
                        elseif (0 == $base_array[0]['team_free_base'])
                        {
                            f_igosja_session_front_flash_set('error', 'У вас нет бесплатных улучшений базы.');

                            redirect('/base_free.php');
                        }
                        elseif (!f_igosja_request_get('ok'))
                        {
                            $base_accept = 'Улучшение базы <span class="strong">' . $baseinfo_array[0]['base_level']
                                         . '</span> уровня произойдет мгновенно.';
                        }
                        else
                        {
                            $log = array(
                                'history_building_id' => $building_id,
                                'history_historytext_id' => HISTORYTEXT_BUILDING_UP,
                                'history_team_id' => $auth_team_id,
                                'history_value' => $baseinfo_array[0]['base_level'],
                            );
                            f_igosja_history($log);

                            $sql = "UPDATE `team`
                                    SET `team_base_id`=`team_base_id`+1,
                                        `team_free_base`=`team_free_base`-1
                                    WHERE `team_id`=$auth_team_id
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);

                            f_igosja_session_front_flash_set('success', 'Строительство прошло успешно.');

                            redirect('/base_free.php');
                        }
                    }
                }
                else
                {
                    $sql = "SELECT `building_name`
                            FROM `building`
                            WHERE `building_id`=$building_id
                            LIMIT 1";
                    $building_sql = f_igosja_mysqli_query($sql);

                    if (0 == $building_sql->num_rows)
                    {
                        f_igosja_session_front_flash_set('error', 'Тип строения выбран неправильно.');

                        redirect('/base_free.php');
                    }
                    elseif (BUILDING_BASETRAINING == $building_id && f_igosja_base_is_training($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В тренировочном центре тренируются игроки.');

                        redirect('/base_free.php');
                    }
                    elseif (BUILDING_BASESCHOOL == $building_id && f_igosja_base_is_school($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В спортшколе идет подготовка игрока.');

                        redirect('/base_free.php');
                    }
                    elseif (BUILDING_BASESCOUT == $building_id && f_igosja_base_is_scout($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В скаутцентре идет изучение игроков.');

                        redirect('/base_free.php');
                    }
                    else
                    {
                        $building_array = $building_sql->fetch_all(MYSQLI_ASSOC);

                        $building_name = $building_array[0]['building_name'];

                        $level = $base_array[0][$building_name . '_id'];
                        $level++;

                        $sql = "SELECT `" . $building_name . "_base_level`,
                                       `" . $building_name . "_level`
                                FROM `" . $building_name . "`
                                WHERE `" . $building_name . "_id`=$level
                                LIMIT 1";
                        $baseinfo_sql = f_igosja_mysqli_query($sql);

                        if (0 == $baseinfo_sql->num_rows)
                        {
                            f_igosja_session_front_flash_set('error', 'Вы имеете здание максимального уровня.');

                            redirect('/base_free.php');
                        }
                        else
                        {
                            $baseinfo_array = $baseinfo_sql->fetch_all(MYSQLI_ASSOC);

                            if ($baseinfo_array[0][$building_name . '_base_level'] > $base_array[0]['base_level'])
                            {
                                f_igosja_session_front_flash_set('error', 'Минимальный уровень базы должен быть не меньше <span class="strong">' . $baseinfo_array[0][$building_name . '_base_level'] . '</span>.');

                                redirect('/base_free.php');
                            }
                            elseif ($base_array[0]['base_slot_max'] <= $base_array[0]['base_slot_used'])
                            {
                                f_igosja_session_front_flash_set('error', 'На базе нет свободных слотов для строительства.');

                                redirect('/base_free.php');
                            }
                            elseif (0 == $base_array[0]['team_free_base'])
                            {
                                f_igosja_session_front_flash_set('error', 'У вас нет бесплатных улучшений базы.');

                                redirect('/base_free.php');
                            }
                            elseif (!f_igosja_request_get('ok'))
                            {
                                $base_accept = 'Улучшение здания <span class="strong">' . $baseinfo_array[0][$building_name . '_level'] . '</span> уровня произойдет мгновенно.';
                            }
                            else
                            {
                                $log = array(
                                    'history_building_id' => $building_id,
                                    'history_historytext_id' => HISTORYTEXT_BUILDING_UP,
                                    'history_team_id' => $auth_team_id,
                                    'history_value' => $baseinfo_array[0][$building_name . '_level'],
                                );
                                f_igosja_history($log);

                                $sql = "UPDATE `team`
                                        SET `team_" . $building_name . "_id`=`team_" . $building_name . "_id`+1,
                                            `team_free_base`=`team_free_base`-1
                                        WHERE `team_id`=$auth_team_id
                                        LIMIT 1";
                                f_igosja_mysqli_query($sql);

                                f_igosja_session_front_flash_set('success', 'Строительство прошло успешно.');

                                redirect('/base_free.php');
                            }
                        }
                    }
                }
            }
        }
    }
}

$sql = "SELECT COUNT(`training_id`) AS `count`
        FROM `training`
        WHERE `training_team_id`=$num_get
        AND `training_season_id`=$igosja_season_id
        AND `training_power`!=0";
$training_used_power_sql = f_igosja_mysqli_query($sql);

$training_used_power_array = $training_used_power_sql->fetch_all(MYSQLI_ASSOC);

$training_available_power = $base_array[0]['basetraining_power_count'] - $training_used_power_array[0]['count'];

$sql = "SELECT COUNT(`training_id`) AS `count`
        FROM `training`
        WHERE `training_team_id`=$num_get
        AND `training_season_id`=$igosja_season_id
        AND `training_special_id`!=0";
$training_used_special_sql = f_igosja_mysqli_query($sql);

$training_used_special_array = $training_used_special_sql->fetch_all(MYSQLI_ASSOC);

$training_available_special = $base_array[0]['basetraining_special_count'] - $training_used_special_array[0]['count'];

$sql = "SELECT COUNT(`training_id`) AS `count`
        FROM `training`
        WHERE `training_team_id`=$num_get
        AND `training_season_id`=$igosja_season_id
        AND `training_position_id`!=0";
$training_used_position_sql = f_igosja_mysqli_query($sql);

$training_used_position_array = $training_used_position_sql->fetch_all(MYSQLI_ASSOC);

$training_available_position = $base_array[0]['basetraining_position_count'] - $training_used_position_array[0]['count'];

$sql = "SELECT COUNT(`phisicalchange_id`) AS `count`
        FROM `phisicalchange`
        WHERE `phisicalchange_team_id`=$num_get
        AND `phisicalchange_season_id`=$igosja_season_id
        AND `phisicalchange_schedule_id`<=
        (
            SELECT `schedule_id`
            FROM `schedule`
            WHERE `schedule_date`<UNIX_TIMESTAMP()
            AND `schedule_season_id`=$igosja_season_id
            ORDER BY `schedule_date` DESC
            LIMIT 1
        )";
$phisical_used_sql = f_igosja_mysqli_query($sql);

$phisical_used_array = $phisical_used_sql->fetch_all(MYSQLI_ASSOC);

$phisical_available = $base_array[0]['basephisical_change_count'] - $phisical_used_array[0]['count'];

$sql = "SELECT COUNT(`phisicalchange_id`) AS `count`
        FROM `phisicalchange`
        WHERE `phisicalchange_team_id`=$num_get
        AND `phisicalchange_season_id`=$igosja_season_id
        AND `phisicalchange_schedule_id`>
        (
            SELECT `schedule_id`
            FROM `schedule`
            WHERE `schedule_date`<UNIX_TIMESTAMP()
            AND `schedule_season_id`=$igosja_season_id
            ORDER BY `schedule_date` DESC
            LIMIT 1
        )";
$phisical_plan_sql = f_igosja_mysqli_query($sql);

$phisical_plan_array = $phisical_plan_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT COUNT(`school_id`) AS `count`
        FROM `school`
        WHERE `school_team_id`=$num_get
        AND `school_season_id`=$igosja_season_id";
$school_used_sql = f_igosja_mysqli_query($sql);

$school_used_array = $school_used_sql->fetch_all(MYSQLI_ASSOC);

$school_available = $base_array[0]['baseschool_player_count'] - $school_used_array[0]['count'];

$sql = "SELECT COUNT(`scout_id`) AS `count`
        FROM `scout`
        WHERE `scout_team_id`=$num_get
        AND `scout_season_id`=$igosja_season_id";
$scout_used_sql = f_igosja_mysqli_query($sql);

$scout_used_array = $scout_used_sql->fetch_all(MYSQLI_ASSOC);

$scout_available = $base_array[0]['basescout_my_style_count'] - $scout_used_array[0]['count'];

$img = '/img/base/';

if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASE == $buildingbase_array[0]['buildingbase_building_id'])
{
    $img_base = $img . 'building.png';
}
else
{
    $img_base = $img . 'base.png';
}

if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASETRAINING == $buildingbase_array[0]['buildingbase_building_id'])
{
    $img_training = $img . 'building.png';
}
else
{
    $img_training = $img . 'training.png';
}

if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASEMEDICAL == $buildingbase_array[0]['buildingbase_building_id'])
{
    $img_medical = $img . 'building.png';
}
else
{
    $img_medical = $img . 'medical.png';
}

if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASEPHISICAL == $buildingbase_array[0]['buildingbase_building_id'])
{
    $img_phisical = $img . 'building.png';
}
else
{
    $img_phisical = $img . 'phisical.png';
}

if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASESCHOOL == $buildingbase_array[0]['buildingbase_building_id'])
{
    $img_school = $img . 'building.png';
}
else
{
    $img_school = $img . 'school.png';
}

if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASESCOUT == $buildingbase_array[0]['buildingbase_building_id'])
{
    $img_scout = $img . 'building.png';
}
else
{
    $img_scout = $img . 'scout.png';
}

unset($img);

$link_base_array        = array();
$link_training_array    = array();
$link_medical_array     = array();
$link_phisical_array    = array();
$link_school_array      = array();
$link_scout_array       = array();

$del_base       = false;
$del_medical    = false;
$del_phisical   = false;
$del_school     = false;
$del_scout      = false;
$del_training   = false;

if (isset($auth_team_id) && $auth_team_id == $num_get)
{
    if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASE == $buildingbase_array[0]['buildingbase_building_id'])
    {
        $link_base_array[] = array(
            'href' => 'javascript:',
            'text' => 'Идет строительство',
        );

        $link_training_array[] = array(
            'href' => 'javascript:',
            'text' => 'Идет строительство',
        );

        $link_medical_array[] = array(
            'href' => 'javascript:',
            'text' => 'Идет строительство',
        );

        $link_phisical_array[] = array(
            'href' => 'javascript:',
            'text' => 'Идет строительство',
        );

        $link_school_array[] = array(
            'href' => 'javascript:',
            'text' => 'Идет строительство',
        );

        $link_scout_array[] = array(
            'href' => 'javascript:',
            'text' => 'Идет строительство',
        );

        $del_base       = true;
        $del_medical    = true;
        $del_phisical   = true;
        $del_school     = true;
        $del_scout      = true;
        $del_training   = true;
    }
    else
    {
        if ($base_array[0]['base_level'] < BUILDING_MAX_LEVEL)
        {
            $link_base_array[] = array(
                'href' => '/base_free.php?building_id=' . BUILDING_BASE . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                'text' => 'Строить',
            );
        }

        if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASETRAINING == $buildingbase_array[0]['buildingbase_building_id'])
        {
            $link_training_array[] = array(
                'href' => 'javascript:',
                'text' => 'Идет строительство',
            );

            $del_training   = true;
        }
        else
        {
            if ($base_array[0]['basetraining_level'] < BUILDING_MAX_LEVEL)
            {
                $link_training_array[] = array(
                    'href' => '/base_free.php?building_id=' . BUILDING_BASETRAINING . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                    'text' => 'Строить',
                );
            }
        }

        if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASEPHISICAL == $buildingbase_array[0]['buildingbase_building_id'])
        {
            $link_phisical_array[] = array(
                'href' => 'javascript:',
                'text' => 'Идет строительство',
            );

            $del_phisical   = true;
        }
        else
        {
            if ($base_array[0]['basephisical_level'] < BUILDING_MAX_LEVEL)
            {
                $link_phisical_array[] = array(
                    'href' => '/base_free.php?building_id=' . BUILDING_BASEPHISICAL . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                    'text' => 'Строить',
                );
            }
        }

        if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASESCHOOL == $buildingbase_array[0]['buildingbase_building_id'])
        {
            $link_school_array[] = array(
                'href' => 'javascript:',
                'text' => 'Идет строительство',
            );

            $del_medical    = true;
        }
        else
        {
            if ($base_array[0]['baseschool_level'] < BUILDING_MAX_LEVEL)
            {
                $link_school_array[] = array(
                    'href' => '/base_free.php?building_id=' . BUILDING_BASESCHOOL . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                    'text' => 'Строить',
                );
            }
        }

        if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASESCOUT == $buildingbase_array[0]['buildingbase_building_id'])
        {
            $link_scout_array[] = array(
                'href' => 'javascript:',
                'text' => 'Идет строительство',
            );

            $del_scout      = true;
        }
        else
        {
            if ($base_array[0]['baseschool_level'] < BUILDING_MAX_LEVEL)
            {
                $link_scout_array[] = array(
                    'href' => '/base_free.php?building_id=' . BUILDING_BASESCOUT . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                    'text' => 'Строить',
                );
            }
        }

        if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASEMEDICAL == $buildingbase_array[0]['buildingbase_building_id'])
        {
            $link_medical_array[] = array(
                'href' => 'javascript:',
                'text' => 'Идет строительство',
            );

            $del_medical    = true;
        }
        else
        {
            if ($base_array[0]['basemedical_level'] < BUILDING_MAX_LEVEL)
            {
                $link_medical_array[] = array(
                    'href' => '/base_free.php?building_id=' . BUILDING_BASEMEDICAL . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                    'text' => 'Строить',
                );
            }
        }
    }
}

$seo_title          = 'База команды';
$seo_description    = 'Информация о базе команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'база команды ';

include(__DIR__ . '/view/layout/main.php');