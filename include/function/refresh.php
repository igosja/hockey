<?php

/**
 * Оновлення поточного url
 */
function refresh()
{
    f_igosja_get_count_query();

    header('Refresh:0');
    exit;
}