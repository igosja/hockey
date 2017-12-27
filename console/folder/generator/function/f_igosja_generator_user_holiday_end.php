<?php

/**
 * Збільшуємо відпустки на 1 день і завершуємо відпустки довші за 30 днів
 */
function f_igosja_generator_user_holiday_end()
{
    $sql = "UPDATE `user`
            SET `user_holiday_day`=`user_holiday_day`+1
            WHERE `user_holiday`=1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `user`
            SET `user_holiday`=0
            WHERE `user_holiday_day`>=30
            AND `user_holiday`=1
            AND `user_date_vip`<UNIX_TIMESTAMP()";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `user`
            SET `user_holiday`=0
            WHERE `user_holiday_day`>=60
            AND `user_holiday`=1
            AND `user_date_vip`>=UNIX_TIMESTAMP()";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `user`
            SET `user_holiday_day`=0
            WHERE `user_holiday`=0";
    f_igosja_mysqli_query($sql);
}