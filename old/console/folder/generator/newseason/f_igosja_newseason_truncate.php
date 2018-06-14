<?php

/**
 * Чистимо сезонні таблиці
 */
function f_igosja_newseason_truncate()
{
    $sql = "TRUNCATE TABLE `teamvisitor`";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE TABLE `phisicalchange`";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE TABLE `nationalplayerday`";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE TABLE `nationaluserday`";
    f_igosja_mysqli_query($sql);

    $sql = "TRUNCATE TABLE `teamwork`";
    f_igosja_mysqli_query($sql);
}