<?php

/**
 * Перенаправлення на url
 * @param $location string url, куда слід перекинути людину
 */
function redirect($location)
{
    if ('/wrong_page.php' == $location)
    {
        $_SESSION['wrong_page_referrer'] = $_SERVER['REQUEST_URI'];
    }

    f_igosja_get_count_query();

    header('Location: ' . $location);
    exit;
}