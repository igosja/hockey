<?php

include(__DIR__ . '/../include/include.php');

$sql = "TRUNCATE TABLE `debug`";
f_igosja_mysqli_query($sql, false);

redirect('/admin/debug_list.php');