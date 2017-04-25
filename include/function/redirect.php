<?php

/**
 * Перенаправление на url
 * @param $location string url, куда нужно перебросить человека
 */
function redirect($location)
{
    header('Location: ' . $location);
    exit;
}