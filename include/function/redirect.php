<?php

/**
 * Перенаправлення на url
 * @param $location string url, куда слід перекинути людину
 */
function redirect($location)
{
    f_igosja_get_count_query();

    header('Location: ' . $location);
    exit;
}