<?php

include(__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_request_get('num');

if (0 != $num_get)
{
    $sql = "DELETE FROM `city`
            WHERE `city_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}

redirect('/admin/city_list.php');