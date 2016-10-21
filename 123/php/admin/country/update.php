<?php

if ($data = f_igosja_post('data')) {
    $set_sql = f_igosja_sql_data($data);

    if (0 == $num_get) {
        $sql = "INSERT INTO `country`
                SET $set_sql";
    } else {
        $sql = "UPDATE `country`
                SET $set_sql
                WHERE `country_id`='$num_get'
                LIMIT 1";
    }

    igosja_db_query($sql);

    if (0 == $num_get) {
        $num_get = $mysqli->insert_id;
    }

    redirect('/admin/' . $route_path . '/view/' . $num_get);
}

if (0 != $num_get) {
    $sql = "SELECT `country_id`,
                   `country_name`
            FROM `country`
            WHERE `country_id`='$num_get'
            LIMIT 1";
    $country_sql = igosja_db_query($sql);

    $country_array = $country_sql->fetch_all(1);
}

$breadcrumb_array[] = array('url' => $route_path, 'text' => 'Страны');

if (isset($country_array)) {
    $breadcrumb_array[] = array(
        'url' => $route_path . '/view/' . $country_array[0]['country_id'],
        'text' => $country_array[0]['country_name']
    );
    $breadcrumb_array[] = 'Редактирование';
} else {
    $breadcrumb_array[] = 'Создание';
}