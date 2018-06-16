<?php

include(__DIR__ . '/../include/include.php');

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'stadium_city_id',
        'stadium_name'
    ));

    $sql = "INSERT INTO `stadium`
            SET $set_sql";
    f_igosja_mysqli_query($sql);

    redirect('/admin/stadium_view.php?num=' . $mysqli->insert_id);
}

$sql = "SELECT `city_id`,
               `city_name`
        FROM `city`
        ORDER BY `city_name` ASC, `city_id` ASC";
$city_sql = f_igosja_mysqli_query($sql);

$city_array = $city_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'stadium_list.php', 'text' => 'Стадионы');
$breadcrumb_array[] = 'Создание';

$tpl = 'stadium_update';

include(__DIR__ . '/view/layout/main.php');