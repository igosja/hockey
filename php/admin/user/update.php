<?php

if ($data = f_igosja_post('data')) {
    $set_sql = f_igosja_sql_data($data);
    $sql = "UPDATE `user`
            SET $set_sql
            WHERE `user_id`='$num_get'
            LIMIT 1";
    igosja_db_query($sql);
    redirect('/admin/' . $route_path . '/view/' . $num_get);
}
$sql = "SELECT `user_id`,
               `user_login`
        FROM `user`
        WHERE `user_id`='$num_get'
        LIMIT 1";
$user_sql = igosja_db_query($sql);
$user_array = $user_sql->fetch_all(1);