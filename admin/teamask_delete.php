<?php

include(__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_request_get('num');

if (0 != $num_get)
{
    $sql = "DELETE FROM `teamask`
            WHERE `teamask_id`=$num_get
            LIMIT 1";
    f_igosja_mysqli_query($sql);
}

redirect('/admin/teamask_list.php');