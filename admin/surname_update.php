<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "UPDATE `surname`
            SET $set_sql
            WHERE `surname_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    $sql = "DELETE FROM `surnamecountry`
            WHERE `surnamecountry_surname_id`='$num_get'";
    igosja_db_query($sql);

    $country = f_igosja_post('array', 'surnamecountry_country_id');

    foreach ($country as $item)
    {
        $country_id = (int)$item;

        $sql = "INSERT INTO `surnamecountry`
                SET `surnamecountry_surname_id`='$num_get',
                    `surnamecountry_country_id`='$country_id'";
        igosja_db_query($sql);
    }

    redirect('/admin/surname_view.php?num=' . $num_get);
}

$sql = "SELECT `surname_id`,
               `surname_name`
        FROM `surname`
        WHERE `surname_id`='$num_get'
        LIMIT 1";
$surname_sql = igosja_db_query($sql);

if (0 == $surname_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$surname_array = $surname_sql->fetch_all(1);

$sql = "SELECT `surnamecountry_country_id`
        FROM `surnamecountry`
        WHERE `surnamecountry_surname_id`='$num_get'";
$surnamecountry_sql = igosja_db_query($sql);

$surnamecountry_array = $surnamecountry_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_name` ASC";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'surname_list.php', 'text' => 'Фамилии');
$breadcrumb_array[] = array(
    'url' => 'surname_view.php?num=' . $surname_array[0]['surname_id'],
    'text' => $surname_array[0]['surname_name']
);
$breadcrumb_array[] = 'Редактирование';

include (__DIR__ . '/view/layout/main.php');