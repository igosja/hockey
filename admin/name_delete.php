<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "DELETE FROM `name`
            WHERE `name_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql, false);

    $sql = "DELETE FROM `namecountry`
            WHERE `namecountry_name_id`=$num_get";
    f_igosja_mysqli_query($sql, false);
}

redirect('/admin/name_list.php');