<?php

/**
 * Видаляємо просрочені запрошення на товариські матчі
 */
function f_igosja_generator_friendlyinvite_delete()
{
    $sql = "SELECT `schedule_id`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`, '%Y-%m-%d')=CURDATE()
            ORDER BY `schedule_id` DESC
            LIMIT 1";
    $schedule_sql = f_igosja_mysqli_query($sql);

    $schedule_array = $schedule_sql->fetch_all(MYSQLI_ASSOC);

    $schedule_id = $schedule_array[0]['schedule_id'];

    $sql = "DELETE FROM `friendlyinvite`
            WHERE `friendlyinvite_schedule_id`<=$schedule_id";
    f_igosja_mysqli_query($sql);
}