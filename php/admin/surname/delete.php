<?php

if (0 != $num_get) {
    $sql = "DELETE FROM `surname`
            WHERE `surname_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);

    $sql = "DELETE FROM `surnamecountry`
            WHERE `surnamecountry_surname_id`='$num_get'";
    igosja_db_query($sql);
}

redirect('/admin/' . $route_path);