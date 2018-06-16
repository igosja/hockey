<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        WHERE `country_id`=$num_get
        LIMIT 1";
$country_sql = f_igosja_mysqli_query($sql);

if (0 == $country_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'country_name'
    ));

    $sql = "UPDATE `country`
            SET $set_sql
            WHERE `country_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    redirect('/admin/country_view.php?num=' . $num_get);
}

$breadcrumb_array[] = array('url' => 'country_list.php', 'text' => 'Страны');
$breadcrumb_array[] = array(
    'url' => 'country_view.php?num=' . $country_array[0]['country_id'],
    'text' => $country_array[0]['country_name']
);
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');