<?php

$sql        = "SELECT FOUND_ROWS() AS `count`";
$count_item = f_igosja_mysqli_query($sql);
$count_item = $count_item->fetch_all(MYSQLI_ASSOC);
$count_item = $count_item[0]['count'];
$count_page = ceil($count_item / $limit);

$pages_in_pagination    = ADMIN_PAGES_IN_PAGINATION;
$pages_minus            = round(($pages_in_pagination - 1) / 2);
$pages_plus             = $pages_in_pagination - $pages_minus - 1;

$page_array = array();

if ($pages_in_pagination < $count_page)
{
    $first_page = $page - $pages_minus;
    $last_page  = $page + $pages_plus;
}
else
{
    $first_page = 1;
    $last_page  = $count_page;
}

if (1 > $first_page)
{
    $first_page = 1;

    if ($pages_in_pagination < $count_page)
    {
        $last_page = $pages_in_pagination;
    }
    else
    {
        $last_page = $count_page;
    }
}

if ($count_page < $last_page) {
    $last_page = $count_page;

    if (1 > $count_page - $pages_in_pagination)
    {
        $first_page = 1;
    }
    else
    {
        $first_page = $count_page - $pages_in_pagination;
    }
}

for ($i=$first_page; $i<=$last_page; $i++)
{
    if ($page == $i)
    {
        $active = 'active';
    }
    else
    {
        $active = '';
    }

    $page_array[] = array('class' => $active, 'page' => $i);
}

$page_prev = array('class' => '', 'page' => $page - 1);
$page_next = array('class' => '', 'page' => $page + 1);

if ($page <= $first_page)
{
    $page_prev = array('class' => 'disabled', 'page' => $first_page);
}

if ($page >= $last_page)
{
    $page_next = array('class' => 'disabled', 'page' => $last_page);
}

$page_filter = $filter;

if (is_array($page_filter))
{
    foreach ($page_filter as $key => $value)
    {
        if (!$value)
        {
            unset($page_filter[$key]);
        }
    }

    $page_filter = array('filter' => $page_filter);
    $page_filter = '&' . http_build_query($page_filter);
}

if (($page - 1) * $limit + 1 < $count_item)
{
    $summary_from = ($page - 1) * $limit + 1;
}
else
{
    $summary_from = $count_item;
}

if ($count_item < $page * $limit)
{
    $summary_to = $count_item;
}
else
{
    $summary_to = $page * $limit;
}