<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_team_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_team_id;
}

include(__DIR__ . '/include/sql/team_view_left.php');

$buildingbase_array = array();

$sql = "SELECT `buildingbase_building_id`,
               `buildingbase_day`,
               `buildingbase_id`
        FROM `buildingbase`
        WHERE `buildingbase_team_id`=$num_get
        AND `buildingbase_ready`=0";
$buildingbase_sql = f_igosja_mysqli_query($sql);

if ($count_buildingbase = $buildingbase_sql->num_rows)
{
    $buildingbase_array = $buildingbase_sql->fetch_all(MYSQLI_ASSOC);

    $buildingbase_day = $buildingbase_array[0]['buildingbase_day'];

    if (strtotime(date('Y-m-d 12:00:00')) > time())
    {
        $buildingbase_day = $buildingbase_day - 1;
    }

    $buildingbase_day = f_igosja_ufu_date(strtotime('+' . $buildingbase_day . 'days'));
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
               `team_finance`
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

            redirect('/base.php');
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

                    $sql = "SELECT `base_build_speed`,
                                   `base_level`,
                                   `base_price_buy`,
                                   `base_slot_min`
                            FROM `base`
                            WHERE `base_id`=$level
                            LIMIT 1";
                    $baseinfo_sql = f_igosja_mysqli_query($sql);

                    if (0 == $baseinfo_sql->num_rows)
                    {
                        f_igosja_session_front_flash_set('error', 'Вы имеете здание максимального уровня.');

                        redirect('/base.php');
                    }
                    elseif (f_igosja_base_is_training($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В тренировочном центре тренируются игроки.');

                        redirect('/base.php');
                    }
                    elseif (f_igosja_base_is_school($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В спортшколе идет подготовка игрока.');

                        redirect('/base.php');
                    }
                    elseif (f_igosja_base_is_scout($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В скаутцентре идет изучение игроков.');

                        redirect('/base.php');
                    }
                    else
                    {
                        $baseinfo_array = $baseinfo_sql->fetch_all(MYSQLI_ASSOC);

                        if ($baseinfo_array[0]['base_slot_min'] > $base_array[0]['base_slot_used'])
                        {
                            f_igosja_session_front_flash_set('error', 'Минимальное количество занятых слотов должно быть не меньше <span class="strong">' . $baseinfo_array[0]['base_slot_min'] . '</span>.');

                            redirect('/base.php');
                        }
                        elseif ($baseinfo_array[0]['base_price_buy'] > $base_array[0]['team_finance'])
                        {
                            f_igosja_session_front_flash_set('error', 'Для строительства нужно <span class="strong">' . f_igosja_money_format($baseinfo_array[0]['base_price_buy']) . '</span>.');

                            redirect('/base.php');
                        }
                        elseif (!f_igosja_request_get('ok'))
                        {
                            $base_accept = 'Строительство базы <span class="strong">' . $baseinfo_array[0]['base_level']
                                . '</span> уровня будет стоить <span class="strong">' . f_igosja_money_format($baseinfo_array[0]['base_price_buy'])
                                . '</span> и займет <span class="strong">' . $baseinfo_array[0]['base_build_speed']
                                . '</span> ' . f_igosja_count_case($baseinfo_array[0]['base_build_speed'], 'день', 'дня', 'дней') . '.';
                        }
                        else
                        {
                            $buildingbase_day   = $baseinfo_array[0]['base_build_speed'];
                            $buildingbase_price = $baseinfo_array[0]['base_price_buy'];

                            $sql = "INSERT INTO `buildingbase`
                                    SET `buildingbase_building_id`=$building_id,
                                        `buildingbase_constructiontype_id`=$constructiontype_id,
                                        `buildingbase_day`=$buildingbase_day,
                                        `buildingbase_team_id`=$auth_team_id";
                            f_igosja_mysqli_query($sql);

                            $sql = "UPDATE `team`
                                    SET `team_finance`=`team_finance`-$buildingbase_price
                                    WHERE `team_id`=$auth_team_id
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);

                            $finance = array(
                                'finance_building_id' => $building_id,
                                'finance_financetext_id' => FINANCETEXT_OUTCOME_BUILDING_BASE,
                                'finance_level' => $baseinfo_array[0]['base_level'],
                                'finance_team_id' => $auth_team_id,
                                'finance_value' => -$buildingbase_price,
                                'finance_value_after' => $base_array[0]['team_finance'] - $buildingbase_price,
                                'finance_value_before' => $base_array[0]['team_finance'],
                            );
                            f_igosja_finance($finance);

                            f_igosja_session_front_flash_set('success', 'Строительство успешно началось.');

                            redirect('/base.php');
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

                        redirect('/base.php');
                    }
                    elseif (BUILDING_BASETRAINING == $building_id && f_igosja_base_is_training($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В тренировочном центре тренируются игроки.');

                        redirect('/base.php');
                    }
                    elseif (BUILDING_BASESCHOOL == $building_id && f_igosja_base_is_school($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В спортшколе идет подготовка игрока.');

                        redirect('/base.php');
                    }
                    elseif (BUILDING_BASESCOUT == $building_id && f_igosja_base_is_scout($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В скаутцентре идет изучение игроков.');

                        redirect('/base.php');
                    }
                    else
                    {
                        $building_array = $building_sql->fetch_all(MYSQLI_ASSOC);

                        $building_name = $building_array[0]['building_name'];

                        $level = $base_array[0][$building_name . '_id'];
                        $level++;

                        $sql = "SELECT `" . $building_name . "_base_level`,
                                       `" . $building_name . "_build_speed`,
                                       `" . $building_name . "_level`,
                                       `" . $building_name . "_price_buy`
                                FROM `" . $building_name . "`
                                WHERE `" . $building_name . "_id`=$level
                                LIMIT 1";
                        $baseinfo_sql = f_igosja_mysqli_query($sql);

                        if (0 == $baseinfo_sql->num_rows)
                        {
                            f_igosja_session_front_flash_set('error', 'Вы имеете здание максимального уровня.');

                            redirect('/base.php');
                        }
                        else
                        {
                            $baseinfo_array = $baseinfo_sql->fetch_all(MYSQLI_ASSOC);

                            if ($baseinfo_array[0][$building_name . '_base_level'] > $base_array[0]['base_level'])
                            {
                                f_igosja_session_front_flash_set('error', 'Минимальный уровень базы должен быть не меньше <span class="strong">' . $baseinfo_array[0][$building_name . '_base_level'] . '</span>.');

                                redirect('/base.php');
                            }
                            elseif ($base_array[0]['base_slot_max'] <= $base_array[0]['base_slot_used'])
                            {
                                f_igosja_session_front_flash_set('error', 'На базе нет свободных слотов для строительства.');

                                redirect('/base.php');
                            }
                            elseif ($baseinfo_array[0][$building_name . '_price_buy'] > $base_array[0]['team_finance'])
                            {
                                f_igosja_session_front_flash_set('error', 'Для строительства нужно <span class="strong">' . f_igosja_money_format($baseinfo_array[0][$building_name . '_price_buy']) . '</span>.');

                                redirect('/base.php');
                            }
                            elseif (!f_igosja_request_get('ok'))
                            {
                                $base_accept = 'Строительство здания <span class="strong">' . $baseinfo_array[0][$building_name . '_level']
                                    . '</span> уровня будет стоить <span class="strong">' . f_igosja_money_format($baseinfo_array[0][$building_name . '_price_buy'])
                                    . '</span> и займет <span class="strong">' . $baseinfo_array[0][$building_name . '_build_speed']
                                    . '</span> ' . f_igosja_count_case($baseinfo_array[0][$building_name . '_build_speed'], 'день', 'дня', 'дней') . '.';
                            }
                            else
                            {
                                $buildingbase_day   = $baseinfo_array[0][$building_name . '_build_speed'];
                                $buildingbase_price = $baseinfo_array[0][$building_name . '_price_buy'];

                                $sql = "INSERT INTO `buildingbase`
                                        SET `buildingbase_building_id`=$building_id,
                                            `buildingbase_constructiontype_id`=$constructiontype_id,
                                            `buildingbase_day`=$buildingbase_day,
                                            `buildingbase_team_id`=$auth_team_id";
                                f_igosja_mysqli_query($sql);

                                $sql = "UPDATE `team`
                                        SET `team_finance`=`team_finance`-$buildingbase_price
                                        WHERE `team_id`=$auth_team_id
                                        LIMIT 1";
                                f_igosja_mysqli_query($sql);

                                $finance = array(
                                    'finance_building_id' => $building_id,
                                    'finance_financetext_id' => FINANCETEXT_OUTCOME_BUILDING_BASE,
                                    'finance_level' => $baseinfo_array[0][$building_name . '_level'],
                                    'finance_team_id' => $auth_team_id,
                                    'finance_value' => -$buildingbase_price,
                                    'finance_value_after' => $base_array[0]['team_finance'] - $buildingbase_price,
                                    'finance_value_before' => $base_array[0]['team_finance'],
                                );
                                f_igosja_finance($finance);

                                f_igosja_session_front_flash_set('success', 'Строительство успешно началось.');

                                redirect('/base.php');
                            }
                        }
                    }
                }
            }
            else
            {
                if (BUILDING_BASE == $building_id)
                {
                    $level = $base_array[0]['base_id'];

                    $sql = "SELECT `base_price_sell`
                            FROM `base`
                            WHERE `base_id`=$level
                            LIMIT 1";
                    $baseinfo_sql = f_igosja_mysqli_query($sql);

                    if (0 == $baseinfo_sql->num_rows)
                    {
                        $buildingbase_price = 0;
                    }
                    else
                    {
                        $baseinfo_array = $baseinfo_sql->fetch_all(MYSQLI_ASSOC);

                        $buildingbase_price = $baseinfo_array[0]['base_price_sell'];
                    }

                    $level--;

                    $sql = "SELECT `base_build_speed`,
                                   `base_level`,
                                   `base_slot_max`
                            FROM `base`
                            WHERE `base_id`=$level
                            LIMIT 1";
                    $baseinfo_sql = f_igosja_mysqli_query($sql);

                    if (0 == $baseinfo_sql->num_rows)
                    {
                        f_igosja_session_front_flash_set('error', 'Вы имеете здание минимального уровня.');

                        redirect('/base.php');
                    }
                    elseif (f_igosja_base_is_training($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В тренировочном центре тренируются игроки.');

                        redirect('/base.php');
                    }
                    elseif (f_igosja_base_is_school($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В спортшколе идет подготовка игрока.');

                        redirect('/base.php');
                    }
                    elseif (f_igosja_base_is_scout($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В скаутцентре идет изучение игроков.');

                        redirect('/base.php');
                    }
                    else
                    {
                        $baseinfo_array = $baseinfo_sql->fetch_all(MYSQLI_ASSOC);

                        if ($baseinfo_array[0]['base_slot_max'] < $base_array[0]['base_slot_used'])
                        {
                            f_igosja_session_front_flash_set('error', 'Максимальное количество занятых слотов должно быть не больше <span class="strong">' . $baseinfo_array[0]['base_slot_max'] . '</span>.');

                            redirect('/base.php');
                        }
                        elseif (!f_igosja_request_get('ok'))
                        {
                            $base_accept = 'При строительстве базы <span class="strong">' . $baseinfo_array[0]['base_level']
                                . '</span> уровня вы получите компенсацию <span class="strong">' . f_igosja_money_format($buildingbase_price)
                                . '</span>. Это займет <span class="strong">1</span> день.';
                        }
                        else
                        {
                            $buildingbase_day = 1;

                            $sql = "INSERT INTO `buildingbase`
                                    SET `buildingbase_building_id`=$building_id,
                                        `buildingbase_constructiontype_id`=$constructiontype_id,
                                        `buildingbase_day`=$buildingbase_day,
                                        `buildingbase_team_id`=$auth_team_id";
                            f_igosja_mysqli_query($sql);

                            $sql = "UPDATE `team`
                                    SET `team_finance`=`team_finance`+$buildingbase_price
                                    WHERE `team_id`=$auth_team_id
                                    LIMIT 1";
                            f_igosja_mysqli_query($sql);

                            $finance = array(
                                'finance_building_id' => $building_id,
                                'finance_financetext_id' => FINANCETEXT_INCOME_BUILDING_BASE,
                                'finance_level' => $baseinfo_array[0]['base_level'],
                                'finance_team_id' => $auth_team_id,
                                'finance_value' => $buildingbase_price,
                                'finance_value_after' => $base_array[0]['team_finance'] + $buildingbase_price,
                                'finance_value_before' => $base_array[0]['team_finance'],
                            );
                            f_igosja_finance($finance);

                            f_igosja_session_front_flash_set('success', 'Строительство успешно началось.');

                            redirect('/base.php');
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

                        redirect('/base.php');
                    }
                    elseif (BUILDING_BASETRAINING == $building_id && f_igosja_base_is_training($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В тренировочном центре тренируются игроки.');

                        redirect('/base.php');
                    }
                    elseif (BUILDING_BASESCHOOL == $building_id && f_igosja_base_is_school($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В спортшколе идет подготовка игрока.');

                        redirect('/base.php');
                    }
                    elseif (BUILDING_BASESCOUT == $building_id && f_igosja_base_is_scout($num_get))
                    {
                        f_igosja_session_front_flash_set('error', 'В скаутцентре идет изучение игроков.');

                        redirect('/base.php');
                    }
                    else
                    {
                        $building_array = $building_sql->fetch_all(MYSQLI_ASSOC);

                        $building_name = $building_array[0]['building_name'];

                        $level = $base_array[0][$building_name . '_id'];

                        $sql = "SELECT `" . $building_name . "_price_sell`
                                FROM `" . $building_name . "`
                                WHERE `" . $building_name . "_id`=$level
                                LIMIT 1";
                        $baseinfo_sql = f_igosja_mysqli_query($sql);

                        if (0 == $baseinfo_sql->num_rows)
                        {
                            $buildingbase_price = 0;
                        }
                        else
                        {
                            $baseinfo_array = $baseinfo_sql->fetch_all(MYSQLI_ASSOC);

                            $buildingbase_price = $baseinfo_array[0][$building_name . '_price_sell'];
                        }

                        $level--;

                        $sql = "SELECT `" . $building_name . "_base_level`,
                                       `" . $building_name . "_build_speed`,
                                       `" . $building_name . "_level`
                                FROM `" . $building_name . "`
                                WHERE `" . $building_name . "_id`=$level
                                LIMIT 1";
                        $baseinfo_sql = f_igosja_mysqli_query($sql);

                        if (0 == $baseinfo_sql->num_rows)
                        {
                            f_igosja_session_front_flash_set('error', 'Вы имеете здание минимального уровня.');

                            redirect('/base.php');
                        }
                        else
                        {
                            $baseinfo_array = $baseinfo_sql->fetch_all(MYSQLI_ASSOC);

                            if (!f_igosja_request_get('ok'))
                            {
                                $base_accept = 'При строительстве здания <span class="strong">' . $baseinfo_array[0][$building_name . '_level']
                                    . '</span> уровня вы получите компенсацию <span class="strong">' . f_igosja_money_format($buildingbase_price)
                                    . '</span>. Это займет <span class="strong">1</span> день.';
                            }
                            else
                            {
                                $buildingbase_day = 1;

                                $sql = "INSERT INTO `buildingbase`
                                        SET `buildingbase_building_id`=$building_id,
                                            `buildingbase_constructiontype_id`=$constructiontype_id,
                                            `buildingbase_day`=$buildingbase_day,
                                            `buildingbase_team_id`=$auth_team_id";
                                f_igosja_mysqli_query($sql);

                                $sql = "UPDATE `team`
                                        SET `team_finance`=`team_finance`+$buildingbase_price
                                        WHERE `team_id`=$auth_team_id
                                        LIMIT 1";
                                f_igosja_mysqli_query($sql);

                                $finance = array(
                                    'finance_building_id' => $building_id,
                                    'finance_financetext_id' => FINANCETEXT_INCOME_BUILDING_BASE,
                                    'finance_level' => $baseinfo_array[0][$building_name . '_level'],
                                    'finance_team_id' => $auth_team_id,
                                    'finance_value' => $buildingbase_price,
                                    'finance_value_after' => $base_array[0]['team_finance'] + $buildingbase_price,
                                    'finance_value_before' => $base_array[0]['team_finance'],
                                );
                                f_igosja_finance($finance);

                                f_igosja_session_front_flash_set('success', 'Строительство успешно началось.');

                                redirect('/base.php');
                            }
                        }
                    }
                }
            }
        }
    }
}

if ($cancel_get = (int) f_igosja_request_get('cancel'))
{
    $sql = "SELECT `buildingbase_building_id`,
                   `buildingbase_constructiontype_id`
            FROM `buildingbase`
            WHERE `buildingbase_team_id`=$num_get
            AND `buildingbase_ready`=0
            AND `buildingbase_id`=$cancel_get
            LIMIT 1";
    $buildingbase_sql = f_igosja_mysqli_query($sql);

    if (0 == $buildingbase_sql->num_rows)
    {
        f_igosja_session_front_flash_set('error', 'Строительство выбрано неправильно.');
    }

    $sql = "SELECT `finance_level`,
                   `finance_value`
            FROM `finance`
            WHERE `finance_team_id`=$num_get
            AND `finance_financetext_id` IN (" . FINANCETEXT_INCOME_BUILDING_BASE . ", " . FINANCETEXT_OUTCOME_BUILDING_BASE . ")
            ORDER BY `finance_id` DESC
            LIMIT 1";
    $finance_sql = f_igosja_mysqli_query($sql);

    if (0 == $finance_sql->num_rows)
    {
        f_igosja_session_front_flash_set('error', 'Строительство выбрано неправильно.');
    }

    $finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

    $cancel_price = -$finance_array[0]['finance_value'];

    if (1 == f_igosja_request_get('ok'))
    {
        $sql = "DELETE FROM `buildingbase`
                WHERE `buildingbase_id`=$cancel_get
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+$cancel_price
                WHERE `team_id`=$num_get
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        if ($cancel_price > 0)
        {
            $financetext_id = FINANCETEXT_INCOME_BUILDING_BASE;
            $base_level     = $finance_array[0]['finance_level'] + 1;
        }
        else
        {
            $financetext_id = FINANCETEXT_OUTCOME_BUILDING_BASE;
            $base_level     = $finance_array[0]['finance_level'] - 1;
        }

        $finance = array(
            'finance_financetext_id' => $financetext_id,
            'finance_level' => $base_level,
            'finance_team_id' => $num_get,
            'finance_value' => $cancel_price,
            'finance_value_after' => $base_array[0]['team_finance'] + $cancel_price,
            'finance_value_before' => $base_array[0]['team_finance'],
        );
        f_igosja_finance($finance);

        f_igosja_session_front_flash_set('success', 'Строительство успешно отменено.');

        redirect('/base.php');
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
            'href' => '/base.php?cancel=' . $buildingbase_array[0]['buildingbase_id'],
            'text' => 'Отменить строительство',
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
                'href' => '/base.php?building_id=' . BUILDING_BASE . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                'text' => 'Строить',
            );
        }

        if ($base_array[0]['base_level'] > BUILDING_MIN_LEVEL)
        {
            $link_base_array[] = array(
                'href' => '/base.php?building_id=' . BUILDING_BASE . '&constructiontype_id=' . CONSTRUCTION_DESTROY,
                'text' => 'Продать',
            );
        }

        if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASETRAINING == $buildingbase_array[0]['buildingbase_building_id'])
        {
            $link_training_array[] = array(
                'href' => '/base.php?cancel=' . $buildingbase_array[0]['buildingbase_id'],
                'text' => 'Отменить строительство',
            );

            $del_training   = true;
        }
        else
        {
            if ($base_array[0]['basetraining_level'] < BUILDING_MAX_LEVEL)
            {
                $link_training_array[] = array(
                    'href' => '/base.php?building_id=' . BUILDING_BASETRAINING . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                    'text' => 'Строить',
                );
            }

            if ($base_array[0]['basetraining_level'] > BUILDING_MIN_LEVEL)
            {
                $link_training_array[] = array(
                    'href' => '/base.php?building_id=' . BUILDING_BASETRAINING . '&constructiontype_id=' . CONSTRUCTION_DESTROY,
                    'text' => 'Продать',
                );
            }

            if ($base_array[0]['basetraining_level'] > BUILDING_MIN_LEVEL)
            {
                $link_training_array[] = array(
                    'href' => '/training.php',
                    'text' => 'Тренировка',
                );
            }
        }

        if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASEPHISICAL == $buildingbase_array[0]['buildingbase_building_id'])
        {
            $link_phisical_array[] = array(
                'href' => '/base.php?cancel=' . $buildingbase_array[0]['buildingbase_id'],
                'text' => 'Отменить строительство',
            );

            $del_phisical   = true;
        }
        else
        {
            if ($base_array[0]['basephisical_level'] < BUILDING_MAX_LEVEL)
            {
                $link_phisical_array[] = array(
                    'href' => '/base.php?building_id=' . BUILDING_BASEPHISICAL . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                    'text' => 'Строить',
                );
            }

            if ($base_array[0]['basephisical_level'] > BUILDING_MIN_LEVEL)
            {
                $link_phisical_array[] = array(
                    'href' => '/base.php?building_id=' . BUILDING_BASEPHISICAL . '&constructiontype_id=' . CONSTRUCTION_DESTROY,
                    'text' => 'Продать',
                );
            }

            if ($base_array[0]['basephisical_level'] > BUILDING_MIN_LEVEL)
            {
                $link_phisical_array[] = array(
                    'href' => '/phisical.php',
                    'text' => 'Форма',
                );
            }
        }

        if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASESCHOOL == $buildingbase_array[0]['buildingbase_building_id'])
        {
            $link_school_array[] = array(
                'href' => '/base.php?cancel=' . $buildingbase_array[0]['buildingbase_id'],
                'text' => 'Отменить строительство',
            );

            $del_school    = true;
        }
        else
        {
            if ($base_array[0]['baseschool_level'] < BUILDING_MAX_LEVEL)
            {
                $link_school_array[] = array(
                    'href' => '/base.php?building_id=' . BUILDING_BASESCHOOL . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                    'text' => 'Строить',
                );
            }

            if ($base_array[0]['baseschool_level'] > BUILDING_MIN_LEVEL)
            {
                $link_school_array[] = array(
                    'href' => '/base.php?building_id=' . BUILDING_BASESCHOOL . '&constructiontype_id=' . CONSTRUCTION_DESTROY,
                    'text' => 'Продать',
                );
            }

            if ($base_array[0]['baseschool_level'] > BUILDING_MIN_LEVEL)
            {
                $link_school_array[] = array(
                    'href' => '/school.php',
                    'text' => 'Молодежь',
                );
            }
        }

        if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASESCOUT == $buildingbase_array[0]['buildingbase_building_id'])
        {
            $link_scout_array[] = array(
                'href' => '/base.php?cancel=' . $buildingbase_array[0]['buildingbase_id'],
                'text' => 'Отменить строительство',
            );

            $del_scout      = true;
        }
        else
        {
            if ($base_array[0]['baseschool_level'] < BUILDING_MAX_LEVEL)
            {
                $link_scout_array[] = array(
                    'href' => '/base.php?building_id=' . BUILDING_BASESCOUT . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                    'text' => 'Строить',
                );
            }

            if ($base_array[0]['baseschool_level'] > BUILDING_MIN_LEVEL)
            {
                $link_scout_array[] = array(
                    'href' => '/base.php?building_id=' . BUILDING_BASESCOUT . '&constructiontype_id=' . CONSTRUCTION_DESTROY,
                    'text' => 'Продать',
                );
            }

            if ($base_array[0]['baseschool_level'] > BUILDING_MIN_LEVEL)
            {
                $link_scout_array[] = array(
                    'href' => '/scout.php',
                    'text' => 'Изучение',
                );
            }
        }

        if ($count_buildingbase && isset($buildingbase_array[0]['buildingbase_building_id']) && BUILDING_BASEMEDICAL == $buildingbase_array[0]['buildingbase_building_id'])
        {
            $link_medical_array[] = array(
                'href' => '/base.php?cancel=' . $buildingbase_array[0]['buildingbase_id'],
                'text' => 'Отменить строительство',
            );

            $del_medical    = true;
        }
        else
        {
            if ($base_array[0]['basemedical_level'] < BUILDING_MAX_LEVEL)
            {
                $link_medical_array[] = array(
                    'href' => '/base.php?building_id=' . BUILDING_BASEMEDICAL . '&constructiontype_id=' . CONSTRUCTION_BUILD,
                    'text' => 'Строить',
                );
            }

            if ($base_array[0]['basemedical_level'] > BUILDING_MIN_LEVEL)
            {
                $link_medical_array[] = array(
                    'href' => '/base.php?building_id=' . BUILDING_BASEMEDICAL . '&constructiontype_id=' . CONSTRUCTION_DESTROY,
                    'text' => 'Продать',
                );
            }
        }
    }
}

$seo_title          = 'База команды';
$seo_description    = 'Информация о базе команды на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = 'база команды ';

include(__DIR__ . '/view/layout/main.php');