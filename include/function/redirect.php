<?php

/**
 * Перенаправлення на url
 * @param $location string url, куда слід перекинути людину
 */
function redirect($location)
{
    header('Location: ' . $location);
    exit;
}