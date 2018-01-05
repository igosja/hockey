<?php

/**
 * Очищуємо зміни фіз форми хокеїстів
 */
function f_igosja_newseason_phisicalchange()
{
    $sql = "TRUNCATE `phisicalchange`";
    f_igosja_mysqli_query($sql);
}