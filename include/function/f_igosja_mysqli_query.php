<?php

function f_igosja_mysqli_query($sql)
{
    global $count_query;
    global $mysqli;
    global $query_array;

    $count_query++;

    $start_time = microtime(true);
    $result     = $mysqli->query($sql) or die($mysqli->error);
    $time       = round(microtime(true) - $start_time, 5);

    $query_array[] = array(
        'sql' => $sql,
        'time' => $time,
    );

    return $result;
}