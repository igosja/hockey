<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    if (1 == $num_get)
    {
        $sql = "UPDATE `shedule`
                SET `shedule_date`=`shedule_date`+86400";
        f_igosja_mysqli_query($sql, false);

        redirect('/admin/shedule_change.php');
    }
    elseif (-1 == $num_get)
    {
        $sql = "UPDATE `shedule`
                SET `shedule_date`=`shedule_date`-86400";
        f_igosja_mysqli_query($sql, false);

        redirect('/admin/shedule_change.php');
    }
}

$sql = "SELECT `stage_name`,
               `tournamenttype_name`
        FROM `shedule`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
        WHERE FROM_UNIXTIME(`shedule_date`, '%Y-%m-%d')=CURDATE()
        LIMIT 1";
$shedule_sql = f_igosja_mysqli_query($sql, false);

$shedule_array = $shedule_sql->fetch_all(1);

$breadcrumb_array[] = 'Перевод даты';

include(__DIR__ . '/view/layout/main.php');