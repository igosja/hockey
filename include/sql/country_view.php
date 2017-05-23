<?php

/**
 * @var $num_get integer
 */

$sql = "SELECT `country_finance`,
               `country_name`
        FROM `country`
        WHERE `country_id`=$num_get
        LIMIT 1";
$country_sql = f_igosja_mysqli_query($sql);

if (0 == $country_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$country_array = $country_sql->fetch_all(1);