<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_get('num');

if (0 != $num_get)
{
    $sql = "DELETE FROM `name`
            WHERE `name_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    $sql = "DELETE FROM `namecountry`
            WHERE `namecountry_name_id`='$num_get'";
    igosja_db_query($sql);
}

redirect('/admin/name_list.php');