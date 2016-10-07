<?php

if ($data = f_igosja_post('data')) {
    $set_sql = f_igosja_sql_data($data);

    if (0 == $num_get) {
        $sql = "INSERT INTO `name`
                SET $set_sql";
    } else {
        $sql = "UPDATE `name`
                SET $set_sql
                WHERE `name_id`='$num_get'
                LIMIT 1";
    }

    igosja_db_query($sql);

    if (0 == $num_get) {
        $num_get = $mysqli->insert_id;
    }

    $sql = "DELETE FROM `namecountry`
            WHERE `namecountry_name_id`='$num_get'";
    igosja_db_query($sql);

    $country = f_igosja_post('array', 'namecountry_country_id');

    foreach ($country as $item) {
        $country_id = (int)$item;

        $sql = "INSERT INTO `namecountry`
                SET `namecountry_name_id`='$num_get',
                    `namecountry_country_id`='$country_id'";
        igosja_db_query($sql);
    }

    redirect('/admin/' . $route_path . '/view/' . $num_get);
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_name` ASC";
$country_sql = igosja_db_query($sql);

$country_array = $country_sql->fetch_all(1);

if (0 != $num_get) {
    $sql = "SELECT `name_id`,
                   `name_name`
            FROM `name`
            WHERE `name_id`='$num_get'
            LIMIT 1";
    $name_sql = igosja_db_query($sql);
    $name_array = $name_sql->fetch_all(1);

    $sql = "SELECT `namecountry_country_id`
            FROM `namecountry`
            WHERE `namecountry_name_id`='$num_get'";
    $namecountry_sql = igosja_db_query($sql);
    $namecountry_array = $namecountry_sql->fetch_all(1);
}

$breadcrumb_array[] = array('url' => $route_path, 'text' => 'Имена');

if (isset($name_array)) {
    $breadcrumb_array[] = array(
        'url' => $route_path . '/view/' . $name_array[0]['name_id'],
        'text' => $name_array[0]['name_name']
    );
    $breadcrumb_array[] = 'Редактирование';
} else {
    $breadcrumb_array[] = 'Создание';
}