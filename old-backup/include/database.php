<?php

$count_query    = 0;
$query_array    = array();
$db_host        = 'localhost';
$db_user        = 'igosja_hockey';
$db_password    = 'zuI2QbJJ';
$db_database    = 'igosja_hockey';

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_database) or die('No MySQL connection');

$sql = "SET NAMES 'utf8'";
$mysqli->query($sql);