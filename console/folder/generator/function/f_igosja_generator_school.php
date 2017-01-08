<?php

function f_igosja_generator_school()
//Готовим молодежь в спортшколе
{
    $sql = "UPDATE `school`
            SET `school_day`=`school_day`-'1'
            WHERE `school_ready`='0'";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `school`
            SET `school_ready`='1'
            WHERE `school_day`='0'
            AND `school_ready`='0'";
    f_igosja_mysqli_query($sql);

    print '.';
    flush();
}