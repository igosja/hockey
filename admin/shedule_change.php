<?php

include (__DIR__ . '/../include/include.php');

$num_get = (int) f_igosja_request_get('num');

if (1 == $num_get)
{
    $sql = "UPDATE `shedule`
            SET `shedule_date`=`shedule_date`+86400";
    f_igosja_mysqli_query($sql);

    redirect('/admin/shedule_change.php');
}
elseif (-1 == $num_get)
{
    $sql = "UPDATE `shedule`
            SET `shedule_date`=`shedule_date`-86400";
    f_igosja_mysqli_query($sql);

    redirect('/admin/shedule_change.php');
}

$breadcrumb_array[] = 'Перевод даты';

include (__DIR__ . '/view/layout/main.php');