<?php

include (__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_team_id;

include (__DIR__ . '/include/sql/team_view_left.php');

$sql = "SELECT `basetraining_level`,
               `basetraining_position_count`,
               `basetraining_position_price`,
               `basetraining_power_count`,
               `basetraining_power_price`,
               `basetraining_special_count`,
               `basetraining_special_price`,
               `basetraining_training_speed_max`,
               `basetraining_training_speed_min`,
               `team_finance`
        FROM `team`
        LEFT JOIN `basetraining`
        ON `team_basetraining_id`=`basetraining_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$basetraining_sql = f_igosja_mysqli_query($sql);

$basetraining_array = $basetraining_sql->fetch_all(1);

if ($data = f_igosja_request_post('data'))
{
    $confirm_data = array(
        'power' => array(),
        'position' => array(),
        'special' => array(),
        'price' => 0,
        'error' => '',
    );

    if (isset($data['power']))
    {
        foreach ($data['power'] as $item)
        {
            $player_id = (int) $item;

            $sql = "SELECT `name_name`,
                           `surname_name`
                    FROM `player`
                    LEFT JOIN `name`
                    ON `player_name_id`=`name_id`
                    LEFT JOIN `surname`
                    ON `player_surname_id`=`surname_id`
                    WHERE `player_id`=$player_id
                    AND `player_team_id`=$num_get
                    LIMIT 1";
            $player_sql = f_igosja_mysqli_query($sql);

            if ($player_sql->num_rows)
            {
                $sql = "SELECT COUNT(`training_id`) AS `count`
                        FROM `training`
                        WHERE `training_player_id`=$player_id
                        AND `training_ready`=0";
                $check_sql = f_igosja_mysqli_query($sql);

                $check_array = $check_sql->fetch_all(1);
                $count_check = $check_array[0]['count'];

                if (0 == $count_check)
                {
                    $player_array = $player_sql->fetch_all(1);

                    $confirm_data['power'][] = array(
                        'id' => $item,
                        'name' => $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'],
                    );

                    $confirm_data['price'] = $confirm_data['price'] + $basetraining_array[0]['basetraining_power_price'];
                }
            }
        }
    }

    if (isset($data['position']))
    {
        foreach ($data['position'] as $item)
        {
            if ($item)
            {
                $item_array = explode(':', $item);
                $player_id  = (int) $item_array[0];

                $sql = "SELECT `name_name`,
                               `surname_name`
                        FROM `player`
                        LEFT JOIN `name`
                        ON `player_name_id`=`name_id`
                        LEFT JOIN `surname`
                        ON `player_surname_id`=`surname_id`
                        WHERE `player_id`=$player_id
                        AND `player_team_id`=$num_get
                        LIMIT 1";
                $player_sql = f_igosja_mysqli_query($sql);

                if ($player_sql->num_rows)
                {
                    $sql = "SELECT COUNT(`training_id`) AS `count`
                            FROM `training`
                            WHERE `training_player_id`=$player_id
                            AND `training_ready`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(1);

                    if (0 == $check_array[0]['count'])
                    {
                        $player_array = $player_sql->fetch_all(1);

                        $position_id = (int) $item_array[1];

                        $sql = "SELECT `position_name`
                                FROM `position`
                                WHERE `position_id`=$position_id
                                LIMIT 1";
                        $position_sql = f_igosja_mysqli_query($sql);

                        $position_array = $position_sql->fetch_all(1);

                        $confirm_data['position'][] = array(
                            'id' => $player_id,
                            'name' => $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'],
                            'position' => array(
                                'id' => $position_id,
                                'name' => $position_array[0]['position_name'],
                            ),
                        );

                        $confirm_data['price'] = $confirm_data['price'] + $basetraining_array[0]['basetraining_position_price'];
                    }
                }
            }
        }
    }

    if (isset($data['special']))
    {
        foreach ($data['special'] as $item)
        {
            if ($item)
            {
                $item_array = explode(':', $item);
                $player_id  = (int) $item_array[0];

                $sql = "SELECT `name_name`,
                               `surname_name`
                        FROM `player`
                        LEFT JOIN `name`
                        ON `player_name_id`=`name_id`
                        LEFT JOIN `surname`
                        ON `player_surname_id`=`surname_id`
                        WHERE `player_id`=$player_id
                        AND `player_team_id`=$num_get
                        LIMIT 1";
                $player_sql = f_igosja_mysqli_query($sql);

                if ($player_sql->num_rows)
                {
                    $sql = "SELECT COUNT(`training_id`) AS `count`
                            FROM `training`
                            WHERE `training_player_id`=$player_id
                            AND `training_ready`=0";
                    $check_sql = f_igosja_mysqli_query($sql);

                    $check_array = $check_sql->fetch_all(1);

                    if (0 == $check_array[0]['count'])
                    {
                        $player_array = $player_sql->fetch_all(1);

                        $special_id = (int) $item_array[1];

                        $sql = "SELECT `special_name`
                                FROM `special`
                                WHERE `special_id`=$special_id
                                LIMIT 1";
                        $special_sql = f_igosja_mysqli_query($sql);

                        $special_array = $special_sql->fetch_all(1);

                        $confirm_data['special'][] = array(
                            'id' => $player_id,
                            'name' => $player_array[0]['name_name'] . ' ' . $player_array[0]['surname_name'],
                            'special' => array(
                                'id' => $special_id,
                                'name' => $special_array[0]['special_name'],
                            ),
                        );

                        $confirm_data['price'] = $confirm_data['price'] + $basetraining_array[0]['basetraining_special_price'];
                    }
                }
            }
        }
    }

    if (count($confirm_data['power']) > $basetraining_array[0]['basetraining_power_count'])
    {
        $confirm_data['error'] = 'У вас недостаточно баллов для тренировки';
    }
    elseif (count($confirm_data['position']) > $basetraining_array[0]['basetraining_position_count'])
    {
        $confirm_data['error'] = 'У вас недостаточно совмещений для тренировки';
    }
    elseif (count($confirm_data['special']) > $basetraining_array[0]['basetraining_special_count'])
    {
        $confirm_data['error'] = 'У вас недостаточно спецвозможностей для тренировки';
    }
    elseif ($confirm_data['price'] > $basetraining_array[0]['team_finance'])
    {
        $confirm_data['error'] = 'У вас недостаточно денег для тренировки';
    }

    if (isset($data['ok']))
    {
        $price = $basetraining_array[0]['basetraining_power_price'];

        foreach($confirm_data['power'] as $item)
        {
            $player_id = $item['id'];

            $sql = "INSERT INTO `training`
                    SET `training_player_id`=$player_id,
                        `training_power`=1,
                        `training_season_id`=$igosja_season_id,
                        `training_team_id`=$num_get";
            f_igosja_mysqli_query($sql);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(1);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`-$price
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_TRAINING_POWER,
                'finance_team_id' => $auth_team_id,
                'finance_value' => -$price,
                'finance_value_after' => $team_array[0]['team_finance'] - $price,
                'finance_value_before' => $team_array[0]['team_finance'],
            );
            f_igosja_finance($finance);
        }

        $price = $basetraining_array[0]['basetraining_position_price'];

        foreach($confirm_data['position'] as $item)
        {
            $player_id      = $item['id'];
            $position_id    = $item['position']['id'];

            $sql = "INSERT INTO `training`
                    SET `training_player_id`=$player_id,
                        `training_position_id`=$position_id,
                        `training_season_id`=$igosja_season_id,
                        `training_team_id`=$num_get";
            f_igosja_mysqli_query($sql);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(1);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`-$price
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_TRAINING_POSITION,
                'finance_team_id' => $auth_team_id,
                'finance_value' => -$price,
                'finance_value_after' => $team_array[0]['team_finance'] - $price,
                'finance_value_before' => $team_array[0]['team_finance'],
            );
            f_igosja_finance($finance);
        }

        $price = $basetraining_array[0]['basetraining_special_price'];

        foreach($confirm_data['special'] as $item)
        {
            $player_id  = $item['id'];
            $special_id = $item['special']['id'];

            $sql = "INSERT INTO `training`
                    SET `training_player_id`=$player_id,
                        `training_season_id`=$igosja_season_id,
                        `training_special_id`=$special_id,
                        `training_team_id`=$num_get";
            f_igosja_mysqli_query($sql);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(1);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`-$price
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_financetext_id' => FINANCETEXT_OUTCOME_TRAINING_SPECIAL,
                'finance_team_id' => $auth_team_id,
                'finance_value' => -$price,
                'finance_value_after' => $team_array[0]['team_finance'] - $price,
                'finance_value_before' => $team_array[0]['team_finance'],
            );
            f_igosja_finance($finance);
        }

        $_SESSION['message']['class']   = 'success';
        $_SESSION['message']['text']    = 'Тренировка успешно началась.';

        refresh();
    }
}

$sql = "SELECT `country_id`,
               `country_name`,
               `name_name`,
               `player_age`,
               `player_id`,
               `player_power_nominal`,
               `position_name`,
               `surname_name`,
               `special_name`,
               `training_percent`,
               `training_power`
        FROM `training`
        LEFT JOIN `player`
        ON `training_player_id`=`player_id`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        LEFT JOIN `position`
        ON `training_position_id`=`position_id`
        LEFT JOIN `special`
        ON `training_special_id`=`special_id`
        WHERE `training_season_id`=$igosja_season_id
        AND `training_ready`=0
        AND `training_team_id`=$num_get
        ORDER BY `training_id` ASC";
$training_sql = f_igosja_mysqli_query($sql);

$training_array = $training_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`,
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
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        WHERE `player_team_id`=$num_get
        ORDER BY `player_id` ASC";
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

include (__DIR__ . '/view/layout/main.php');