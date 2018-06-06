<?php

/**
 * Зменшуємо автосклади до дозволеного рівня для тих, хто у відпустці
 */
function f_igosja_generator_user_decrement_auto_for_vocation()
{
    $sql = "UPDATE `team`
            LEFT JOIN `user`
            ON `team_user_id`=`user_id`
            SET `team_auto`=4
            WHERE `team_auto`>=5
            AND `user_id`!=0
            AND `user_holiday`!=0";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `team`
            SET `team_auto`=0
            WHERE `team_auto`!=0
            AND `team_user_id`=0";
    f_igosja_mysqli_query($sql);
}