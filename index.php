<?php

if (isset($_GET['route'])) {
    $file = $_GET['route'];
} else {
    $file = 'index';
}

include(__DIR__ . '/php/include/include.php');
include(__DIR__ . '/php/' . $file . '.php');
include(__DIR__ . '/html/' . $file . '.php');
