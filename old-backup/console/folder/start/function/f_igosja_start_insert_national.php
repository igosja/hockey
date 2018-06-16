<?php

/**
 * Додаємо збірні
 */
function f_igosja_start_insert_national()
{
    $sql = "SELECT `nationaltype_id`
            FROM `nationaltype`
            ORDER BY `nationaltype_id` ASC";
    $nationaltype_sql = f_igosja_mysqli_query($sql);

    $nationaltype_array = $nationaltype_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `city_country_id`
            FROM `city`
            WHERE `city_country_id`!=0
            GROUP BY `city_country_id`
            ORDER BY `city_country_id` ASC";
    $country_sql = f_igosja_mysqli_query($sql);

    $country_array = $country_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($country_array as $item)
    {
        $country_id = $item['city_country_id'];

        foreach ($nationaltype_array as $nationaltype)
        {
            $nationaltype_id = $nationaltype['nationaltype_id'];

            $sql = "INSERT INTO `national`
                    SET `national_country_id`=$country_id,
                        `national_nationaltype_id`=$nationaltype_id";
            f_igosja_mysqli_query($sql);
        }
    }
}