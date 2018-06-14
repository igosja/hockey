<?php

/**
 * Виводимо супери і відпочинки команд на рівень 3
 */
function f_igosja_generator_mood_reset()
{
    $sql = "SELECT COUNT(`schedule_id`) AS `check`
            FROM `schedule`
            WHERE FROM_UNIXTIME(`schedule_date`-86400, '%Y-%m-%d')=CURDATE()
            AND `schedule_stage_id`=" . STAGE_1_TOUR . "
            AND `schedule_tournamenttype_id`=" . TOURNAMENTTYPE_CHAMPIONSHIP;
    f_igosja_mysqli_query($sql);

    $check_sql = f_igosja_mysqli_query($sql);

    $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

    if (0 != $check_array[0]['check'])
    {
        $sql = "UPDATE `team`
                SET `team_mood_rest`=3,
                    `team_mood_super`=3
                WHERE `team_id`!=0";
        f_igosja_mysqli_query($sql);
    }
}