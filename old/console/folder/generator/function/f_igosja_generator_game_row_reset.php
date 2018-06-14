<?php

/**
 * Виводимо ИП/ОП хокеїстів на рівень -1
 */
function f_igosja_generator_game_row_reset()
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
        $sql = "UPDATE `player`
                SET `player_game_row`=-1
                WHERE `player_age`<40";
        f_igosja_mysqli_query($sql);

        $sql = "UPDATE `player`
                SET `player_game_row_old`=`player_game_row`
                WHERE `player_game_row_old`!=`player_game_row`
                AND `player_age`<40";
        f_igosja_mysqli_query($sql);
    }
}