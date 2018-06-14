<?php

/**
 * Перерахунок 10 кращих стадіонів в кожній країні
 */
function f_igosja_generator_country_stadium()
{
    $sql = "SELECT `country_id`
            FROM `team`
            LEFT JOIN `stadium`
            ON `team_stadium_id`=`stadium_id`
            LEFT JOIN `city`
            ON `stadium_city_id`=`city_id`
            LEFT JOIN `country`
            ON `city_country_id`=`country_id`
            WHERE `team_id`!=0
            GROUP BY `country_id`
            ORDER BY `country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($country_array as $item)
    {
        $country_id = $item['country_id'];

        $sql = "SELECT ROUND(AVG(`stadium_capacity`)) AS `capacity`
                FROM `stadium`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                WHERE `city_country_id`=$country_id
                ORDER BY `stadium_capacity` DESC
                LIMIT 10";
        $capacity_sql = f_igosja_mysqli_query($sql);

        $capacity_array = $capacity_sql->fetch_all(1);

        $capacity = $capacity_array[0]['capacity'];

        $sql = "UPDATE `country`
                SET `country_stadium`=$capacity
                WHERE `country_id`=$country_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}