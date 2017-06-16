<?php

include(__DIR__ . '/include/include.php');

$sql = "SELECT COUNT(`user_id`) AS `count`
        FROM `user`
        WHERE `user_date_vip`>UNIX_TIMESTAMP()";
$vip_sql = f_igosja_mysqli_query($sql);

$vip_array = $vip_sql->fetch_all(1);

include(__DIR__ . '/view/layout/main.php');