<?php

$q = array();

$q[] = 'CREATE TABLE `division`
        (
            `division_id` TINYINT(2) PRIMARY KEY AUTO_INCREMENT,
            `division_name` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `division` (`division_name`)
        VALUES ('D1'),
               ('D2'),
               ('D3'),
               ('D4');";