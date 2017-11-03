<?php

include(__DIR__ . '/../include/include.php');

if ($num_get = (int) f_igosja_request_get('num'))
{
    if (1 == $num_get)
    {
        $sql = "UPDATE `schedule`
                SET `schedule_date`=`schedule_date`+86400";
        f_igosja_mysqli_query($sql);

        redirect('/admin/schedule_change.php');
    }
    elseif (-1 == $num_get)
    {
        $sql = "UPDATE `schedule`
                SET `schedule_date`=`schedule_date`-86400";
        f_igosja_mysqli_query($sql);

        redirect('/admin/schedule_change.php');
    }
}

$sql = "SELECT `stage_name`,
               `tournamenttype_name`
        FROM `schedule`
        LEFT JOIN `tournamenttype`
        ON `schedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
        LIMIT 1";
$schedule_sql = f_igosja_mysqli_query($sql);

$schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

$breadcrumb_array[] = 'Перевод даты';

include(__DIR__ . '/view/layout/main.php');