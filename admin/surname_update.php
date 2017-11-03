<?php

include(__DIR__ . '/../include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `surname_id`,
               `surname_name`
        FROM `surname`
        WHERE `surname_id`=$num_get
        LIMIT 1";
$surname_sql = f_igosja_mysqli_query($sql);

if (0 == $surname_sql->num_rows)
{
    redirect('/wrong_page.php');
}

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'surname_name'
    ));

    $sql = "UPDATE `surname`
            SET $set_sql
            WHERE `surname_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `surnamecountry`
            WHERE `surnamecountry_surname_id`=$num_get";
    f_igosja_mysqli_query($sql);

    $country = f_igosja_request_post('array', 'surnamecountry_country_id');

    foreach ($country as $item)
    {
        $country_id = (int) $item;

        $sql = "INSERT INTO `surnamecountry`
                SET `surnamecountry_surname_id`=$num_get,
                    `surnamecountry_country_id`=$country_id";
        f_igosja_mysqli_query($sql);
    }

    redirect('/admin/surname_view.php?num=' . $num_get);
}

$surname_array = $surname_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `surnamecountry_country_id`
        FROM `surnamecountry`
        WHERE `surnamecountry_surname_id`=$num_get
        ORDER BY `surnamecountry_country_id` ASC";
$surnamecountry_sql = f_igosja_mysqli_query($sql);

$surnamecountry_array = $surnamecountry_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_name` ASC, `country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'surname_list.php', 'text' => 'Фамилии');
$breadcrumb_array[] = array(
    'url' => 'surname_view.php?num=' . $surname_array[0]['surname_id'],
    'text' => $surname_array[0]['surname_name']
);
$breadcrumb_array[] = 'Редактирование';

include(__DIR__ . '/view/layout/main.php');