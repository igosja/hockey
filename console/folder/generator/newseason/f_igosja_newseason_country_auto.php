<?php

/**
 * Скидуємо кількість авто за сезон по країнам
 */
function f_igosja_newseason_country_auto()
{
    $sql = "UPDATE `country`
            SET `country_auto`=0
            WHERE `country_auto`!=0";
    f_igosja_mysqli_query($sql);
}