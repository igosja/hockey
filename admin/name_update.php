<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if ($data = f_igosja_post('data'))
{
    $set_sql = f_igosja_sql_data($data);

    $sql = "UPDATE `name`
            SET $set_sql
            WHERE `name_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    $sql = "DELETE FROM `namecountry`
            WHERE `namecountry_name_id`='$num_get'";
    igosja_db_query($sql);

    $country = f_igosja_post('array', 'namecountry_country_id');

    foreach ($country as $item)
    {
        $country_id = (int)$item;

        $sql = "INSERT INTO `namecountry`
                SET `namecountry_name_id`='$num_get',
                    `namecountry_country_id`='$country_id'";
        igosja_db_query($sql);
    }

    redirect('/admin/name_view.php?num=' . $num_get);
}

$sql = "SELECT `name_id`,
               `name_name`
        FROM `name`
        WHERE `name_id`='$num_get'
        LIMIT 1";
$name_sql = igosja_db_query($sql);

if (0 == $name_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$name_array = $name_sql->fetch_all(1);

$sql = "SELECT `namecountry_country_id`
        FROM `namecountry`
        WHERE `namecountry_name_id`='$num_get'";
$namecountry_sql = igosja_db_query($sql);
$namecountry_array = $namecountry_sql->fetch_all(1);

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_name` ASC";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

$breadcrumb_array[] = array('url' => 'name_list.php', 'text' => 'Имена');
$breadcrumb_array[] = array(
    'url' => 'name_view.php?num=' . $name_array[0]['name_id'],
    'text' => $name_array[0]['name_name']
);
$breadcrumb_array[] = 'Редактирование';

include (__DIR__ . '/view/layout/main.php');