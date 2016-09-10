<?php

function redirect($location)
//Перенаправление
{
    header('Location: ' . $location);
    exit;
}