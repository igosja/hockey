<?php

$sql = "SELECT FOUND_ROWS() AS `count`";
$count_page = db_query($sql);
$count_page = $count_page->fetch_all(1);
$count_page = $count_page[0]['count'];
$count_page = ceil($count_page / $limit);

$pages_in_pagination = 5;

$page_array = array();

if ($pages_in_pagination < $count_page) {
    $first_page = $page - 2;
    $last_page = $page + 2;
} else {
    $first_page = 1;
    $last_page = $count_page;
}

if (1 > $first_page) {
    $first_page = 1;
    if ($pages_in_pagination < $count_page) {
        $last_page = $pages_in_pagination;
    } else {
        $last_page = $count_page;
    }
}

if ($count_page < $last_page) {
    $last_page = $count_page;
    if (1 > $count_page - $pages_in_pagination) {
        $first_page = 1;
    } else {
        $first_page = $count_page - $pages_in_pagination;
    }
}

for ($i = $first_page; $i <= $last_page; $i++) {
    $page_array[] = array('class' => ($page == $i ? 'active' : ''), 'page' => $i);
}

$page_prev = array('class' => '', 'page' => $page - 1);
$page_next = array('class' => '', 'page' => $page + 1);

if ($page <= $first_page) {
    $page_prev = array('class' => 'disabled', 'page' => $first_page);
}

if ($page >= $last_page) {

    $page_next = array('class' => 'disabled', 'page' => $last_page);
}