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

if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
{
    $redirect = $_SERVER['HTTP_REFERER'];
}
else
{
    $redirect = '/stadium_increase.php';
}

$sql = "SELECT `buildingstadium_id`
        FROM `buildingstadium`
        WHERE `buildingstadium_team_id`=$num_get
        AND `buildingstadium_ready`=0
        LIMIT 1";
$buildingstadium_sql = f_igosja_mysqli_query($sql);

if (0 == $buildingstadium_sql->num_rows)
{
    f_igosja_session_front_flash_set('error', 'Строительство выбрано неправильно.');

    redirect($redirect);
}

$buildingstadium_array = $buildingstadium_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `finance_value`
        FROM `finance`
        WHERE `finance_team_id`=$num_get
        AND `finance_financetext_id` IN (" . FINANCETEXT_INCOME_BUILDING_STADIUM . ", " . FINANCETEXT_OUTCOME_BUILDING_STADIUM . ")
        ORDER BY `finance_id` DESC
        LIMIT 1";
$finance_sql = f_igosja_mysqli_query($sql);

if (0 == $finance_sql->num_rows)
{
    f_igosja_session_front_flash_set('error', 'Строительство выбрано неправильно.');

    redirect($redirect);
}

$finance_array = $finance_sql->fetch_all(MYSQLI_ASSOC);

$price = -$finance_array[0]['finance_value'];

if (1 == f_igosja_request_get('ok'))
{
    $sql = "DELETE FROM `buildingstadium`
            WHERE `buildingstadium_ready`=0
            AND `buildingstadium_team_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            SET `team_finance`=`team_finance`+$price
            WHERE `team_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    if ($price > 0)
    {
        $financetext_id = FINANCETEXT_INCOME_BUILDING_STADIUM;
    }
    else
    {
        $financetext_id = FINANCETEXT_OUTCOME_BUILDING_STADIUM;
    }

    $finance = array(
        'finance_capacity' => $stadium_array[0]['stadium_capacity'],
        'finance_financetext_id' => $financetext_id,
        'finance_team_id' => $num_get,
        'finance_value' => $price,
        'finance_value_after' => $stadium_array[0]['team_finance'] + $price,
        'finance_value_before' => $stadium_array[0]['team_finance'],
    );
    f_igosja_finance($finance);

    f_igosja_session_front_flash_set('success', 'Строительство успешно отменено.');

    redirect('/stadium_increase.php');
}

$seo_title          = $team_array[0]['stadium_name'] . '. Отмена строительства стадиона';
$seo_description    = $team_array[0]['stadium_name'] . '. Отмена строительства стадиона на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $team_array[0]['stadium_name'] . ' Отмена строительства стадиона';

include(__DIR__ . '/view/layout/main.php');