<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT `country_id`,
               `country_name`
        FROM `championship`
        LEFT JOIN `country`
        ON `championship_country_id`=`country_id`
        WHERE `championship_season_id`=$igosja_season_id
        GROUP BY `country_id`
        ORDER BY `country_id` ASC";
$country_sql = f_igosja_mysqli_query($sql);

$count_country = $country_sql->num_rows;
$country_array = $country_sql->fetch_all(1);

for ($i=0; $i<$count_country; $i++)
{
    $country_id = $country_array[$i]['country_id'];

    $country_division_array = array();

    for ($j=1; $j<=4; $j++)
    {
        $sql = "SELECT `division_name`
                FROM `championship`
                LEFT JOIN `division`
                ON `championship_division_id`=`division_id`
                WHERE `championship_season_id`=$igosja_season_id
                AND `championship_division_id`=$j
                AND `championship_country_id`=$country_id
                LIMIT 1";
        $division_sql = f_igosja_mysqli_query($sql);

        if ($division_sql->num_rows)
        {
            $division_array = $division_sql->fetch_all(1);

            $country_division_array[$division_array[0]['division_name']] = $j;
        }
        else
        {
            $country_division_array[] = '-';
        }
    }

    $country_array[$i]['division'] = $country_division_array;
}

include(__DIR__ . '/view/layout/main.php');