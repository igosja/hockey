<?php

if ($data = f_igosja_post('data')) {
    $set_sql = f_igosja_sql_data($data);

    if (0 == $num_get) {
        $sql = "INSERT INTO `city`
                SET $set_sql";
    } else {
        $sql = "UPDATE `city`
                SET $set_sql
                WHERE `city_id`='$num_get'
                LIMIT 1";
    }

    igosja_db_query($sql);

    if (0 == $num_get) {
        $num_get = $mysqli->insert_id;
    }

    redirect('/admin/' . $route_path . '/view/' . $num_get);
}
$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_name` ASC";
$country_sql = igosja_db_query($sql);

if (0 != $num_get) {
    $sql = "SELECT `city_country_id`,
                   `city_id`,
                   `city_name`
            FROM `city`
            WHERE `city_id`='$num_get'
            LIMIT 1";
    $city_sql = igosja_db_query($sql);

    $city_array = $city_sql->fetch_all(1);
}

$breadcrumb_array[] = array('url' => $route_path, 'text' => 'Города');

if (isset($city_array)) {
    $breadcrumb_array[] = array(
        'url' => $route_path . '/view/' . $city_array[0]['city_id'],
        'text' => $city_array[0]['city_name']
    );
    $breadcrumb_array[] = 'Редактирование';
} else {
    $breadcrumb_array[] = 'Создание';
}

$country_array = $country_sql->fetch_all(1);