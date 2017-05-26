<?php

include(__DIR__ . '/include/include.php');

if (!isset($auth_team_id))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `stadium_capacity`,
               `stadium_name`,
               `team_finance`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        WHERE `team_id`=$auth_team_id
        LIMIT 1";
$stadium_sql = f_igosja_mysqli_query($sql);

if (0 == $stadium_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$stadium_array = $stadium_sql->fetch_all(1);

$sql = "SELECT COUNT(`buildingstadium_id`) AS `count`
        FROM `buildingstadium`
        WHERE `buildingstadium_team_id`=$auth_team_id";
$buildingstadium_sql = f_igosja_mysqli_query($sql);

$buildingstadium_array = $buildingstadium_sql->fetch_all(1);
$count_buildingstadium = $buildingstadium_array[0]['count'];

if ($data = f_igosja_request_post('data'))
{
    if (isset($data['new_capacity']))
    {
        $new_capacity = (int) $data['new_capacity'];
    }
    else
    {
        $stadium_error = 'Новая вместимость должна быть больше текущей.';
    }
}

if (!isset($new_capacity))
{
    if ($capacity = f_igosja_request_get('capacity'))
    {
        $new_capacity = (int) $capacity;
    }
}

if (isset($new_capacity))
{
    if ($count_buildingstadium)
    {
        $stadium_error = 'На стадионе уже идет строительство.';
    }
    elseif ($new_capacity <= $stadium_array[0]['stadium_capacity'])
    {
        $stadium_error = 'Новая вместимость должна быть больше текущей.';
    }
    else
    {
        $buildingstadium_price  = floor((pow($new_capacity, 1.1) - pow($stadium_array[0]['stadium_capacity'], 1.1)) * STADIUM_ONE_SIT_PICE_BUY);
        $buildingstadium_day    = ceil(($new_capacity - $stadium_array[0]['stadium_capacity']) / 1000);

        if ($buildingstadium_price > $stadium_array[0]['team_finance'])
        {
            $base_error = 'Для строительства нужно ' . f_igosja_money($buildingstadium_price) . '.';
        }
        elseif (!f_igosja_request_get('ok'))
        {
            $stadium_accept = 'При уменьшении стадиона до ' . $new_capacity
                            . ' мест будет стоить ' . f_igosja_money($buildingstadium_price)
                            . ' и займет  ' . $buildingstadium_day
                            . ' дней.';
        }
        else
        {
            $constructiontype_id = CONSTRUCTION_BUILD;

            $sql = "INSERT INTO `buildingstadium`
                    SET `buildingstadium_capacity`=$new_capacity,
                        `buildingstadium_constructiontype_id`=$constructiontype_id,
                        `buildingstadium_day`=$buildingstadium_day,
                        `buildingstadium_team_id`=$auth_team_id";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`-$buildingstadium_price
                    WHERE `team_id`=$auth_team_id
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_capacity' => $new_capacity,
                'finance_financetext_id' => FINANCETEXT_OUTCOME_BUILDING_STADIUM,
                'finance_team_id' => $auth_team_id,
                'finance_value' => -$buildingstadium_price,
                'finance_value_after' => $stadium_array[0]['team_finance'] - $buildingstadium_price,
                'finance_value_before' => $stadium_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            $_SESSION['message']['class']   = 'success';
            $_SESSION['message']['text']    = 'Строительство успешно началось.';

            redirect('/stadium_increase.php');
        }
    }
}

include(__DIR__ . '/view/layout/main.php');