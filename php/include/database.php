<?php

$count_query = 0;
$db_host = 'localhost';
$db_user = 'igosja_hockey';
$db_password = 'zuI2QbJJ';
$db_database = 'igosja_hockey';

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database);

function igosja_db_query($sql)
{
    global $mysqli;
    global $count_query;

    $count_query++;

    return $mysqli->query($sql);
}

$sql = "SET NAMES 'utf8'";
igosja_db_query($sql);

$sql = "SET `lc_time_names`='ru_RU'";
igosja_db_query($sql);
