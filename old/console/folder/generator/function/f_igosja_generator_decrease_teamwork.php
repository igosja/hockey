<?php

/**
 * Зменшуємо зігранність і видаляємо те, що <=0
 */
function f_igosja_generator_decrease_teamwork()
{
    $sql = "UPDATE `teamwork`
            SET `teamwork_value`=`teamwork_value`-1";
    f_igosja_mysqli_query($sql);

    $sql = "UPDATE `teamwork`
            SET `teamwork_value`=25
            WHERE `teamwork_value`>25";
    f_igosja_mysqli_query($sql);

    $sql = "DELETE FROM `teamwork`
            WHERE `teamwork_value`<=0";
    f_igosja_mysqli_query($sql);
}