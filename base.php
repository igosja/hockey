<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_team_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_team_id;
}

include (__DIR__ . '/include/sql/team_view_left.php');

$sql = "SELECT COUNT(`buildingbase_id`) AS `count`
        FROM `buildingbase`
        WHERE `buildingbase_team_id`=$num_get";
$buildingbase_sql = f_igosja_mysqli_query($sql);

$buildingbase_array = $buildingbase_sql->fetch_all(1);
$count_buildingbase = $buildingbase_array[0]['count'];

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
               `basephisical_tire_bobus`,
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
        WHERE `team_id`=$num_get";
$base_sql = f_igosja_mysqli_query($sql);

$base_array = $base_sql->fetch_all(1);

if (isset($auth_team_id) && $auth_team_id == $num_get)
{
    if ($building_id = (int) f_igosja_request_get('building_id'))
    {
        if ($count_buildingbase)
        {
            $base_error = 'На базе уже идет строительство.';
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
                        $base_error = 'Вы имеете здание максимального уровня.';
                    }
                    else
                    {
                        $baseinfo_array = $baseinfo_sql->fetch_all(1);

                        if ($baseinfo_array[0]['base_slot_min'] > $base_array[0]['base_slot_used'])
                        {
                            $base_error = 'Минимальное количество занятых слотов должно быть не меньше ' . $baseinfo_array[0]['base_slot_min'] . '.';
                        }
                        elseif ($baseinfo_array[0]['base_price_buy'] > $base_array[0]['team_finance'])
                        {
                            $base_error = 'Для строительства нужно ' . f_igosja_money($baseinfo_array[0]['base_price_buy']) . '.';
                        }
                        elseif (!f_igosja_request_get('ok'))
                        {
                            $base_accept = 'Строительство базы ' . $baseinfo_array[0]['base_level']
                                         . ' уровня будет стоить ' . f_igosja_money($baseinfo_array[0]['base_price_buy'])
                                         . ' и займет ' . $baseinfo_array[0]['base_build_speed']
                                         . ' дней типа B';
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

                            $_SESSION['message']['class']   = 'success';
                            $_SESSION['message']['text']    = 'Строительство успешно началось.';

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
                        $base_error = 'Тип строения выбран не правильно.';
                    }
                    else
                    {
                        $building_array = $building_sql->fetch_all(1);

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
                            $base_error = 'Вы имеете здание максимального уровня.';
                        }
                        else
                        {
                            $baseinfo_array = $baseinfo_sql->fetch_all(1);

                            if ($baseinfo_array[0][$building_name . '_base_level'] > $base_array[0]['base_level'])
                            {
                                $base_error = 'Минимальный уровень базы должен быть не меньше ' . $baseinfo_array[0][$building_name . '_base_level'] . '.';
                            }
                            elseif ($baseinfo_array[0][$building_name . '_price_buy'] > $base_array[0]['team_finance'])
                            {
                                $base_error = 'Для строительства нужно ' . f_igosja_money($baseinfo_array[0][$building_name . '_price_buy']) . '.';
                            }
                            elseif (!f_igosja_request_get('ok'))
                            {
                                $base_accept = 'Строительство здания ' . $baseinfo_array[0][$building_name . '_level']
                                         . ' уровня будет стоить ' . f_igosja_money($baseinfo_array[0][$building_name . '_price_buy'])
                                         . ' и займет ' . $baseinfo_array[0][$building_name . '_build_speed']
                                         . ' дней типа B';
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

                                $_SESSION['message']['class']   = 'success';
                                $_SESSION['message']['text']    = 'Строительство успешно началось.';

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
                        $baseinfo_array = $baseinfo_sql->fetch_all(1);

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
                        $base_error = 'Вы имеете здание минимального уровня.';
                    }
                    else
                    {
                        $baseinfo_array = $baseinfo_sql->fetch_all(1);

                        if ($baseinfo_array[0]['base_slot_max'] < $base_array[0]['base_slot_used'])
                        {
                            $base_error = 'Максимальное количество занятых слотов должно быть не больше ' . $baseinfo_array[0]['base_slot_max'] . '.';
                        }
                        elseif (!f_igosja_request_get('ok'))
                        {
                            $base_accept = 'При строительстве базы ' . $baseinfo_array[0]['base_level']
                                         . ' уровня вы получите компенсацию ' . f_igosja_money($buildingbase_price)
                                         . '. Это займет 1 день типа B';
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

                            $_SESSION['message']['class']   = 'success';
                            $_SESSION['message']['text']    = 'Строительство успешно началось.';

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
                        $base_error = 'Тип строения выбран не правильно.';
                    }
                    else
                    {
                        $building_array = $building_sql->fetch_all(1);

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
                            $baseinfo_array = $baseinfo_sql->fetch_all(1);

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
                            $base_error = 'Вы имеете здание минимального уровня.';
                        }
                        else
                        {
                            $baseinfo_array = $baseinfo_sql->fetch_all(1);

                            if (!f_igosja_request_get('ok'))
                            {
                                $base_accept = 'При строительстве здания ' . $baseinfo_array[0][$building_name . '_level']
                                         . ' уровня вы получите компенсацию ' . f_igosja_money($baseinfo_array[0][$building_name . '_price_buy'])
                                         . '. Это займет 1 день типа B';
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
                                    'finance_financetext_id' => FINANCETEXT_OUTCOME_BUILDING_BASE,
                                    'finance_level' => $baseinfo_array[0][$building_name . '_level'],
                                    'finance_team_id' => $auth_team_id,
                                    'finance_value' => $buildingbase_price,
                                    'finance_value_after' => $base_array[0]['team_finance'] + $buildingbase_price,
                                    'finance_value_before' => $base_array[0]['team_finance'],
                                );
                                f_igosja_finance($finance);

                                $_SESSION['message']['class']   = 'success';
                                $_SESSION['message']['text']    = 'Строительство успешно началось.';

                                redirect('/base.php');
                            }
                        }
                    }
                }
            }
        }
    }
}

include (__DIR__ . '/view/layout/main.php');