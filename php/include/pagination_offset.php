<?php

$limit = 10;
$page = f_igosja_get('page');
if (!$page) {
    $page = 1;
}
$offset = ($page - 1) * $limit;
