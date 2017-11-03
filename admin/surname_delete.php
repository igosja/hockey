<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    $sql = "DELETE FROM `surname`
            WHERE `surname_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `surnamecountry`
            WHERE `surnamecountry_surname_id`=$num_get";
    f_igosja_mysqli_query($sql);
}

redirect('/admin/surname_list.php');