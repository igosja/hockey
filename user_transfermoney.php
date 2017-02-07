<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    if (!isset($auth_user_id))
    {
        redirect('/wrong_page.php');
    }

    $num_get = $auth_user_id;
}

include (__DIR__ . '/include/sql/user_view.php');

if ($data = f_igosja_request_post('data'))
{
    if ((!isset($data['team_id']) || 0 == $data['team_id']) && (!isset($data['country_id']) || 0 == $data['country_id']))
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Нужно выбрать команду или федерацию.';

        refresh();
    }

    if (!isset($data['sum']) || 0 == $data['sum'] || 0 > $data['sum'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Нужно ввести суму.';

        refresh();
    }

    if (!isset($data['comment']) || !$data['comment'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Нужно ввести комментарий.';

        refresh();
    }

    if ($data['sum'] > $user_array[0]['user_finance'])
    {
        $_SESSION['message']['class']   = 'error';
        $_SESSION['message']['text']    = 'Недостаточно денег на счету.';

        refresh();
    }

    $sum = $data['sum'];

    if (isset($data['team_id']) && $data['team_id'])
    {
        $team_id = (int)$data['team_id'];

        $sql = "SELECT `team_finance`
                FROM `team`
                WHERE `team_id`=$team_id
                LIMIT 1";
        $team_sql = f_igosja_mysqli_query($sql);

        if (0 == $team_sql->num_rows)
        {
            $_SESSION['message']['class']   = 'error';
            $_SESSION['message']['text']    = 'Команда выбрана неправильно.';

            refresh();
        }

        $team_array = $team_sql->fetch_all(1);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+$sum
                WHERE `team_id`=$team_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $data = [
            'finance_financetext_id' => FINANCETEXT_USER_TRANSFER,
            'finance_team_id' => $team_id,
            'finance_value' => $data['sum'],
            'finance_value_after' => $team_array[0]['team_finance'] + $data['sum'],
            'finance_value_before' => $team_array[0]['team_finance'],
        ];
        f_igosja_finance($data);
    }
    elseif (isset($data['country_id']) && $data['country_id'])
    {
        $country_id = (int)$data['country_id'];

        $sql = "SELECT `country_finance`
                FROM `country`
                WHERE `country_id`=$country_id
                LIMIT 1";
        $country_sql = f_igosja_mysqli_query($sql);

        if (0 == $country_sql->num_rows)
        {
            $_SESSION['message']['class']   = 'error';
            $_SESSION['message']['text']    = 'Федерация выбрана неправильно.';

            refresh();
        }

        $country_array = $country_sql->fetch_all(1);

        $sql = "UPDATE `country`
                SET `country_finance`=`country_finance`+$sum
                WHERE `country_id`=$country_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $data = [
            'finance_country_id' => $country_id,
            'finance_financetext_id' => FINANCETEXT_USER_TRANSFER,
            'finance_value' => $data['sum'],
            'finance_value_after' => $country_array[0]['country_finance'] + $data['sum'],
            'finance_value_before' => $country_array[0]['country_finance'],
        ];
        f_igosja_finance($data);
    }

    $sql = "UPDATE `user`
            SET `user_finance`=`user_finance`-$sum
            WHERE `user_id`=$auth_user_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $data = [
        'finance_financetext_id' => FINANCETEXT_USER_TRANSFER,
        'finance_user_id' => $auth_user_id,
        'finance_value' => -$sum,
        'finance_value_after' => $user_array[0]['user_finance'] - $sum,
        'finance_value_before' => $user_array[0]['user_finance'],
    ];
    f_igosja_finance($data);

    $_SESSION['message']['class']   = 'success';
    $_SESSION['message']['text']    = 'Деньги успешно переведены.';

    refresh();
}

$sql = "SELECT `city_name`,
               `country_name`,
               `team_id`,
               `team_name`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        LEFT JOIN `city`
        ON `stadium_city_id`=`city_id`
        LEFT JOIN `country`
        ON `city_country_id`=`country_id`
        WHERE `team_id`!=0
        ORDER BY `team_name` ASC";
$team_sql = f_igosja_mysqli_query($sql);

$team_array = $team_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        LEFT JOIN `city`
        ON `country_id`=`city_country_id`
        WHERE `country_id`!=0
        AND `city_id` IS NOT NULL
        GROUP BY `country_id`
        ORDER BY `country_name` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');