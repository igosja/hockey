<?php

/**
 * Авто новини після генерації ігрового дня
 */
function f_igosja_generator_achievement()
{
    $sql = "SELECT `stage_name`,
                   `schedule_tournamenttype_id`
            FROM `schedule`
            LEFT JOIN `stage`
            ON `schedule_stage_id`=`stage_id`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()";
    $today_sql = f_igosja_mysqli_query($sql);

    $today_array = $today_sql->fetch_all(MYSQLI_ASSOC);

    $sql = "SELECT `stage_name`,
                   `schedule_tournamenttype_id`
            FROM `schedule`
            LEFT JOIN `stage`
            ON `schedule_stage_id`=`stage_id`
            WHERE FROM_UNIXTIME(`schedule_date`+86400, '%Y-%m-%d')=CURDATE()";
    $tomorrow_sql = f_igosja_mysqli_query($sql);

    $tomorrow_array = $tomorrow_sql->fetch_all(MYSQLI_ASSOC);

    $title = 'Вести с арен';
    $text = 'Завтра';
}