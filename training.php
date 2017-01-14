<?php

include (__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    $confirm_data = array('power' => array());

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
                    AND `player_team_id`=$auth_team_id
                    LIMIT 1";
            $player_sql = f_igosja_mysqli_query($sql);

            if ($player_sql->num_rows)
            {
                $sql = "SELECT COUNT(`training_id`) AS `count`
                        FROM `training`
                        WHERE `training_player_id`=$player_id";
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
                }
            }
        }
    }

    if (isset($data['ok']))
    {
        $price = 100000;

        foreach($confirm_data['power'] as $item)
        {
            $player_id = $item['id'];

            $sql = "INSERT INTO `training`
                    SET `training_player_id`=$player_id,
                        `training_power`=1";
            f_igosja_mysqli_query($sql);

            $sql = "SELECT `team_finance`
                    FROM `team`
                    WHERE `team_id`=$auth_team_id
                    LIMIT 1";
            $team_sql = f_igosja_mysqli_query($sql);

            $team_array = $team_sql->fetch_all(1);

            $sql = "UPDATE `team`
                    SET `team_fanance`=`team_finance`-$price
                    WHERE `team_id`=$auth_team_id
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
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `country`
        ON `player_country_id`=`country_id`
        WHERE `player_team_id`=$auth_team_id
        ORDER BY `player_id` ASC";
$player_sql = f_igosja_mysqli_query($sql);

$player_array = $player_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');