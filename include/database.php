<?php

$count_query    = 0;
$db_host        = 'localhost';
$db_user        = 'igosja_hockey';
$db_password    = 'zuI2QbJJ';
$db_database    = 'igosja_hockey';

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database);

$sql = "SET NAMES 'utf8'";
$mysqli->query($sql);