<?php

$q = array();

$q[] = 'CREATE TABLE `mood`
        (
            `mood_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `mood_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `mood` (`mood_name`)
        VALUES ('супер'),
               ('нормальный'),
               ('отдых');";