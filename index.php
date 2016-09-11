<?php

if (isset($_GET['route'])) {
    $route_file = $_GET['route'];
} else {
    $route_file = 'index';
}

if ('/' == substr($route_file, -1)) {
    $route_file = substr($route_file, 0, -1);
}

include(__DIR__ . '/php/include/include.php');

if (file_exists(__DIR__ . '/php/' . $route_file . '.php')) {
    include(__DIR__ . '/php/' . $route_file . '.php');
    if ('ajax' != substr($route_file, 0, 4)) {
        include(__DIR__ . '/html/include/layout.php');
    }
} else {
    redirect('/');
}
