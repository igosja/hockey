<?php

$route = f_igosja_get('route');
$a_route = explode('/', $route);
if (isset($a_route[0]) && !empty($a_route[0])) {
    $route_path = $a_route[0];
} else {
    $route_path = 'index';
}
if (isset($a_route[1]) && !empty($a_route[1])) {
    $route_file = $a_route[1];
} else {
    $route_file = 'index';
}
if (file_exists(__DIR__ . '/../' . $route_path . '/' . $route_file . '.php')) {
    include(__DIR__ . '/../' . $route_path . '/' . $route_file . '.php');
    if ('ajax' != $route_path) {
        include(__DIR__ . '/../../html/include/layout.php');
    }
} else {
    redirect('/');
}