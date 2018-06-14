<?php

/**
 * @var $auth_country_id integer
 * @var $auth_user_id integer
 * @var $country_array array
 */

include(__DIR__ . '/include/include.php');

if (!isset($auth_user_id))
{
    redirect('/wrong_page.php');
}

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

include(__DIR__ . '/include/sql/country_view.php');

if (!in_array($auth_user_id, array($country_array[0]['president_id'], $country_array[0]['vice_id'])))
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    if ((!isset($data['team_id']) || 0 == $data['team_id']) && (!isset($data['country_id']) || 0 == $data['country_id']))
    {
        f_igosja_session_front_flash_set('error', 'Выберите команду или федерацию.');

        refresh();
    }

    if (!isset($data['sum']) || 0 == $data['sum'] || 0 > $data['sum'])
    {
        f_igosja_session_front_flash_set('error', 'Введите сумму.');

        refresh();
    }

    if (!isset($data['comment']) || !$data['comment'])
    {
        f_igosja_session_front_flash_set('error', 'Введите комментарий.');

        refresh();
    }

    $sum = (int) $data['sum'];

    if ($sum > $country_array[0]['country_finance'])
    {
        f_igosja_session_front_flash_set('error', 'Недостаточно денег на счету.');

        refresh();
    }

    if (isset($data['team_id']) && $data['team_id'])
    {
        $team_id = (int) $data['team_id'];

        $sql = "SELECT `team_finance`
                FROM `team`
                WHERE `team_id`=$team_id
                LIMIT 1";
        $team_sql = f_igosja_mysqli_query($sql);

        if (0 == $team_sql->num_rows)
        {
            f_igosja_session_front_flash_set('error', 'Команда выбрана неправильно.');

            refresh();
        }

        $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

        $sql = "UPDATE `team`
                SET `team_finance`=`team_finance`+$sum
                WHERE `team_id`=$team_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $data = [
            'finance_comment' => $data['comment'],
            'finance_financetext_id' => FINANCETEXT_COUNTRY_TRANSFER,
            'finance_team_id' => $team_id,
            'finance_value' => $sum,
            'finance_value_after' => $team_array[0]['team_finance'] + $data['sum'],
            'finance_value_before' => $team_array[0]['team_finance'],
        ];
        f_igosja_finance($data);
    }
    elseif (isset($data['country_id']) && $data['country_id'])
    {
        $federation_id = (int) $data['country_id'];

        $sql = "SELECT `country_finance`
                FROM `country`
                WHERE `country_id`=$federation_id
                LIMIT 1";
        $federation_sql = f_igosja_mysqli_query($sql);

        if (0 == $country_sql->num_rows)
        {
            f_igosja_session_front_flash_set('error', 'Федерация выбрана неправильно.');

            refresh();
        }

        $federation_array = $federation_sql->fetch_all(MYSQLI_ASSOC);

        $sql = "UPDATE `country`
                SET `country_finance`=`country_finance`+$sum
                WHERE `country_id`=$federation_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);

        $data = [
            'finance_comment' => $data['comment'],
            'finance_country_id' => $federation_id,
            'finance_financetext_id' => FINANCETEXT_COUNTRY_TRANSFER,
            'finance_value' => $sum,
            'finance_value_after' => $federation_array[0]['country_finance'] + $data['sum'],
            'finance_value_before' => $federation_array[0]['country_finance'],
        ];
        f_igosja_finance($data);
    }

    $sql = "UPDATE `country`
            SET `country_finance`=`country_finance`-$sum
            WHERE `country_id`=$auth_country_id
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $data = [
        'finance_financetext_id' => FINANCETEXT_COUNTRY_TRANSFER,
        'finance_country_id' => $auth_country_id,
        'finance_value' => -$sum,
        'finance_value_after' => $country_array[0]['country_finance'] - $sum,
        'finance_value_before' => $country_array[0]['country_finance'],
    ];
    f_igosja_finance($data);

    f_igosja_session_front_flash_set('success', 'Деньги успешно переведены.');

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

$team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        LEFT JOIN `city`
        ON `country_id`=`city_country_id`
        WHERE `country_id`!=0
        AND `city_id` IS NOT NULL
        AND `country_id`!=$auth_country_id
        GROUP BY `country_id`
        ORDER BY `country_name` ASC";
$federation_sql = f_igosja_mysqli_query($sql);

$federation_array = $federation_sql->fetch_all(MYSQLI_ASSOC);

$seo_title          = $country_array[0]['country_name'] . '. Перевод денег со счета фередарации';
$seo_description    = $country_array[0]['country_name'] . '. Перевод денег со счета фередарации на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = $country_array[0]['country_name'] . ' перевод денег со счета фередарации';

include(__DIR__ . '/view/layout/main.php');