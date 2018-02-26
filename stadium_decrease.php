<?php

/**
 * @var $auth_team_id integer
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

$sql = "SELECT `stadium_capacity`,
               `team_finance`
        FROM `team`
        LEFT JOIN `stadium`
        ON `team_stadium_id`=`stadium_id`
        WHERE `team_id`=$num_get
        LIMIT 1";
$stadium_sql = f_igosja_mysqli_query($sql);

if (0 == $stadium_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `buildingstadium_day`
        FROM `buildingstadium`
        WHERE `buildingstadium_team_id`=$num_get
        AND `buildingstadium_ready`=0
        LIMIT 1";
$buildingstadium_sql = f_igosja_mysqli_query($sql);

if ($count_buildingstadium = $buildingstadium_sql->num_rows)
{
    $buildingstadium_array = $buildingstadium_sql->fetch_all(MYSQLI_ASSOC);

    $buildingstadium_day = $buildingstadium_array[0]['buildingstadium_day'];

    if (strtotime(date('Y-m-d 12:00:00')) > time())
    {
        $buildingstadium_day = $buildingstadium_day - 1;
    }

    $buildingstadium_day = f_igosja_ufu_date(strtotime('+' . $buildingstadium_day . 'days'));
}

if ($data = f_igosja_request_post('data'))
{
    if (isset($data['new_capacity']))
    {
        $new_capacity = (int) $data['new_capacity'];
    }
    else
    {
        $stadium_error = 'Новая вместимость должна быть меньше текущей.';
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
    elseif ($new_capacity >= $stadium_array[0]['stadium_capacity'])
    {
        $stadium_error = 'Новая вместимость должна быть меньше текущей.';
    }
    else
    {
        $buildingstadium_price = floor((pow($stadium_array[0]['stadium_capacity'], 1.1) - pow($new_capacity, 1.1)) * STADIUM_ONE_SIT_PICE_SELL);

        if (!f_igosja_request_get('ok'))
        {
            $stadium_accept = 'При уменьшении стадиона до <span class="strong">' . $new_capacity
                            . '</span> мест вы получите компенсацию <span class="strong">' . f_igosja_money_format($buildingstadium_price)
                            . '</span>. Это займет <span class="strong">1</span> день.';
        }
        else
        {
            $buildingstadium_day = 1;
            $constructiontype_id = CONSTRUCTION_DESTROY;

            $sql = "INSERT INTO `buildingstadium`
                    SET `buildingstadium_capacity`=$new_capacity,
                        `buildingstadium_constructiontype_id`=$constructiontype_id,
                        `buildingstadium_day`=$buildingstadium_day,
                        `buildingstadium_team_id`=$num_get";
            f_igosja_mysqli_query($sql);

            $sql = "UPDATE `team`
                    SET `team_finance`=`team_finance`+$buildingstadium_price
                    WHERE `team_id`=$num_get
                    LIMIT 1";
            f_igosja_mysqli_query($sql);

            $finance = array(
                'finance_capacity' => $new_capacity,
                'finance_financetext_id' => FINANCETEXT_INCOME_BUILDING_STADIUM,
                'finance_team_id' => $num_get,
                'finance_value' => $buildingstadium_price,
                'finance_value_after' => $stadium_array[0]['team_finance'] + $buildingstadium_price,
                'finance_value_before' => $stadium_array[0]['team_finance'],
            );
            f_igosja_finance($finance);

            f_igosja_session_front_flash_set('success', 'Строительство успешно началось.');

            redirect('/stadium_decrease.php');
        }
    }
}

$seo_title          = $team_array[0]['stadium_name'] . '. Уменьшения стадиона';
$seo_description    = $team_array[0]['stadium_name'] . '. Уменьшения стадиона на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['stadium_name'] . ' уменьшения стадиона';

include(__DIR__ . '/view/layout/main.php');