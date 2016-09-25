<?php

if ($data = f_igosja_post('data')) {
    $set_sql = f_igosja_sql_data($data);
    if (0 == $num_get) {
        $sql = "INSERT INTO `stadium`
                SET $set_sql";
    } else {
        $sql = "UPDATE `stadium`
                SET $set_sql
                WHERE `stadium_id`='$num_get'
                LIMIT 1";
    }
    igosja_db_query($sql);
    if (0 == $num_get) {
        $num_get = $mysqli->insert_id;
    }
    redirect('/admin/' . $route_path . '/view/' . $num_get);
}
if (0 != $num_get) {
    $sql = "SELECT `stadium_city_id`,
                   `stadium_id`,
                   `stadium_name`
            FROM `stadium`
            WHERE `stadium_id`='$num_get'
            LIMIT 1";
    $stadium_sql = igosja_db_query($sql);
    $stadium_array = $stadium_sql->fetch_all(1);
}
$sql = "SELECT `city_id`,
               `city_name`
        FROM `city`
        ORDER BY `city_name` ASC";
$city_sql = igosja_db_query($sql);
$city_array = $city_sql->fetch_all(1);