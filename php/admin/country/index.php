<?php

include(__DIR__ . '/../../include/pagination_offset.php');

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `country_id`,
               `country_name`
        FROM `country`
        ORDER BY `country_id`
        LIMIT $offset, $limit";
$country_sql = db_query($sql);
$country_array = $country_sql->fetch_all(1);

include(__DIR__ . '/../../include/pagination_count.php');