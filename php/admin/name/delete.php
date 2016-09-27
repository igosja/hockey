<?php

if (0 != $num_get) {
    $sql = "DELETE FROM `name`
            WHERE `name_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);
    $sql = "DELETE FROM `namecountry`
            WHERE `namecountry_name_id`='$num_get'";
    igosja_db_query($sql);
}
redirect('/admin/' . $route_path);