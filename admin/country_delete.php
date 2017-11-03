<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "DELETE FROM `country`
            WHERE `country_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}

redirect('/admin/country_list.php');