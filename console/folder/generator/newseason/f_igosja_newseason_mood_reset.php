<?php

/**
 * Виводимо супери і відпочинки команд на рівень 2
 */
function f_igosja_newseason_mood_reset()
{
    $sql = "UPDATE `team`
            SET `team_mood_rest`=2,
                `team_mood_super`=2
            WHERE `team_id`!=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `national`
            SET `national_mood_rest`=2,
                `national_mood_super`=2
            WHERE `national_id`!=0";
    f_igosja_mysqli_query($sql);
}