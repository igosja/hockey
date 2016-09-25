<?php

$route = f_igosja_get('route');
$a_route = explode('/', $route);
if (isset($a_route[0]) && !empty($a_route[0])) {
    $route_path = $a_route[0];
} else {
    $route_path = 'index';
}
if ('admin' == $route_path) {
    if (isset($a_route[1]) && !empty($a_route[1])) {
        $route_path = $a_route[1];
    } else {
        $route_path = 'index';
    }
    if (isset($a_route[2]) && !empty($a_route[2])) {
        $route_file = $a_route[2];
    } else {
        $route_file = 'index';
    }
    if (isset($a_route[3]) && !empty($a_route[3])) {
        $num_get = (int)$a_route[3];
    } else {
        $num_get = 0;
    }
    if ('login' != $route_path && !$auth_user_login) {
        redirect('/admin/login');
    } elseif ('login' != $route_path && 10 != $auth_userrole_id) {
        redirect('/');
    }
    if (file_exists(__DIR__ . '/../admin/' . $route_path . '/' . $route_file . '.php')) {
        include(__DIR__ . '/../include/filter.php');
        include(__DIR__ . '/../admin/' . $route_path . '/' . $route_file . '.php');
        if ('login' != $route_path) {
            include(__DIR__ . '/../../html/include/layout/admin.php');
        } else {
            include(__DIR__ . '/../../html/include/layout/login.php');
        }
    } else {
        redirect('/admin');
    }
} else {
    if (isset($a_route[1]) && !empty($a_route[1])) {
        $route_file = $a_route[1];
    } else {
        $route_file = 'index';
    }
    if (isset($a_route[2]) && !empty($a_route[2])) {
        $num_get = $a_route[2];
    } else {
        $num_get = 'index';
    }
    if (file_exists(__DIR__ . '/../' . $route_path . '/' . $route_file . '.php')) {
        include(__DIR__ . '/../' . $route_path . '/' . $route_file . '.php');
        if ('ajax' != $route_path) {
            include(__DIR__ . '/../../html/include/layout/index.php');
        }
    } else {
        redirect('/');
    }
}