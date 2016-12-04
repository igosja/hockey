<?php

$q = array();

$q[] = 'CREATE TABLE `rude`
        (
            `rude_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `rude_name` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `rude` (`rude_name`)
        VALUES ('нормальная'),
               ('грубая');";