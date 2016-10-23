<?php

$limit  = ADMIN_ITEMS_ON_PAGE;
$page   = f_igosja_get('page');

if (!$page)
{
    $page = 1;
}

$offset = ($page - 1) * $limit;