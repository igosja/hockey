<?php

/**
 * @var $auth_team_id integer
 * @var $igosja_season_id integer
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

$num_get = $auth_team_id;

include(__DIR__ . '/include/sql/team_view_left.php');

$sql = "SELECT COUNT(`buildingbase_id`) AS `count`
        FROM `buildingbase`
        WHERE `buildingbase_ready`=0
        AND `buildingbase_team_id`=$auth_team_id
        AND `buildingbase_building_id` IN (" . BUILDING_BASE . ", " . BUILDING_BASETRAINING . ")";
$building_sql = f_igosja_mysqli_query($sql);

$building_array = $building_sql->fetch_all(1);

if ($building_array[0]['count'])
{
    $on_building = true;
}
else
{
    $on_building = false;
}

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

$sql = "SELECT COUNT(`training_id`) AS `count`
        FROM `training`
        WHERE `training_team_id`=$num_get
        AND `training_season_id`=$igosja_season_id
        AND `training_power`!=0";
$training_used_power_sql = f_igosja_mysqli_query($sql);

$training_used_power_array = $training_used_power_sql->fetch_all(1);

$training_available_power = $basetraining_array[0]['basetraining_power_count'] - $training_used_power_array[0]['count'];

$sql = "SELECT COUNT(`training_id`) AS `count`
        FROM `training`
        WHERE `training_team_id`=$num_get
        AND `training_season_id`=$igosja_season_id
        AND `training_special_id`!=0";
$training_used_special_sql = f_igosja_mysqli_query($sql);

$training_used_special_array = $training_used_special_sql->fetch_all(1);

$training_available_special = $basetraining_array[0]['basetraining_special_count'] - $training_used_special_array[0]['count'];

$sql = "SELECT COUNT(`training_id`) AS `count`
        FROM `training`
        WHERE `training_team_id`=$num_get
        AND `training_season_id`=$igosja_season_id
        AND `training_position_id`!=0";
$training_used_position_sql = f_igosja_mysqli_query($sql);

$training_used_position_array = $training_used_position_sql->fetch_all(1);

$training_available_position = $basetraining_array[0]['basetraining_position_count'] - $training_used_position_array[0]['count'];

if ($data = f_igosja_request_post('data'))
{
    $confirm_data = array(
        'power' => array(),
        'position' => array(),
        'special' => array(),
        'price' => 0,
    );

    $player_id_array = array();

    if (isset($data['power']))
    {
        foreach ($data['power'] as $item)
        {
            $player_id = (int) $item;

            $player_id_array[] = $player_id;

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
                else
                {
                    $_SESSION['message']['class']   = 'error';
                    $_SESSION['message']['text']    = 'Одному игроку нельзя назначить несколько тренировок одновременно.';

                    refresh();
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

                $player_id_array[] = $player_id;

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
                    else
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Одному игроку нельзя назначить несколько тренировок одновременно.';

                        refresh();
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

                $player_id_array[] = $player_id;

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
                    else
                    {
                        $_SESSION['message']['class']   = 'error';
                        $_SESSION['message']['text']    = 'Одному игроку нельзя назначить несколько тренировок одновременно.';

                        refresh();
                    }
                }
            }
        }
    }

    if ($on_building)
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'На базе сейчас идет строительство.';

        refresh();
    }
    elseif (count($confirm_data['power']) > $training_available_power)
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'У вас недостаточно баллов для тренировки.';

        refresh();
    }
    elseif (count($confirm_data['position']) > $training_available_position)
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'У вас недостаточно совмещений для тренировки.';

        refresh();
    }
    elseif (count($confirm_data['special']) > $training_available_special)
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'У вас недостаточно спецвозможностей для тренировки.';

        refresh();
    }
    elseif (count($player_id_array) != count(array_unique($player_id_array)))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Одному игроку нельзя назначить несколько тренировок одновременно.';

        refresh();
    }
    elseif ($confirm_data['price'] > $basetraining_array[0]['team_finance'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'У вас недостаточно денег для тренировки.';

        refresh();
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

$player_id = array();

foreach ($player_array as $item)
{
    $player_id[] = $item['player_id'];
}

if (count($player_id))
{
    $player_id = implode(', ', $player_id);

    $sql = "SELECT `playerposition_player_id`,
                   `position_name`
            FROM `playerposition`
            LEFT JOIN `position`
            ON `playerposition_position_id`=`position_id`
            WHERE `playerposition_player_id` IN ($player_id)
            ORDER BY `playerposition_position_id` ASC";
    $playerposition_sql = f_igosja_mysqli_query($sql);

    $playerposition_array = $playerposition_sql->fetch_all(1);

    $sql = "SELECT `playerspecial_level`,
                   `playerspecial_player_id`,
                   `special_name`
            FROM `playerspecial`
            LEFT JOIN `special`
            ON `playerspecial_special_id`=`special_id`
            WHERE `playerspecial_player_id` IN ($player_id)
            ORDER BY `playerspecial_level` DESC, `playerspecial_special_id` ASC";
    $playerspecial_sql = f_igosja_mysqli_query($sql);

    $playerspecial_array = $playerspecial_sql->fetch_all(1);
}
else
{
    $playerposition_array   = array();
    $playerspecial_array    = array();
}

include(__DIR__ . '/view/layout/main.php');