<?php

/**
 * Перевозимо збірні на найкращі стадіони країн
 */
function f_igosja_generator_national_stadium()
{
    $sql = "SELECT `national_id`
            FROM `national`
            WHERE `national_nationaltype_id`=" . NATIONALTYPE_MAIN . "
            ORDER BY `national_id` ASC";
    $national_sql = f_igosja_mysqli_query($sql);

    $national_array = $national_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($national_array as $item)
    {
        $national_id = $item['national_id'];

        $sql = "SELECT `stadium_id`
                FROM `stadium`
                LEFT JOIN `city`
                ON `stadium_city_id`=`city_id`
                LEFT JOIN `national`
                ON `city_country_id`=`national_country_id`
                WHERE `national_id`=$national_id
                ORDER BY `stadium_capacity` DESC, `stadium_id` ASC
                LIMIT 1";
        $stadium_sql = f_igosja_mysqli_query($sql);

        if (0 == $stadium_sql->num_rows)
        {
            $stadium_id = 0;
        }
        else
        {
            $stadium_array = $stadium_sql->fetch_all(MYSQLI_ASSOC);

            $stadium_id = $stadium_array[0]['stadium_id'];
        }

        $sql = "UPDATE `national`
                SET `national_stadium_id`=$stadium_id
                WHERE `national_id`=$national_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}