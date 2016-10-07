<?php

if (0 != $num_get) {
    $sql = "DELETE FROM `stadium`
            WHERE `stadium_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);
}

redirect('/admin/' . $route_path);