<?php

/**
 * Додаємо новий сезон в базу
 */
function f_igosja_newseason_insert_season()
{
    $sql = "INSERT INTO `season`
            SET `season_id`=NULL";
    f_igosja_mysqli_query($sql);
}