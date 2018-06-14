<?php

include(__DIR__ . '/../include/include.php');

if ($data = f_igosja_request_post('data'))
{
    $set_sql = f_igosja_sql_data($data, array(
        'name_name'
    ));

    $sql = "INSERT INTO `name`
            SET $set_sql";
    f_igosja_mysqli_query($sql);

    $num_get = $mysqli->insert_id;

    $country = f_igosja_request_post('array', 'namecountry_country_id');

    foreach ($country as $item)
    {
        $country_id = (int) $item;

        $sql = "INSERT INTO `namecountry`
                SET `namecountry_name_id`=$num_get,
                    `namecountry_country_id`=$country_id";
        f_igosja_mysqli_query($sql);
    }

    redirect('/admin/name_view.php?num=' . $num_get);
}

$sql = "SELECT `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_name` ASC, `country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = array('url' => 'name_list.php', 'text' => 'Имена');
$breadcrumb_array[] = 'Создание';

$tpl = 'name_update';

include(__DIR__ . '/view/layout/main.php');