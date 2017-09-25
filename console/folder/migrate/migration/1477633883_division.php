<?php

$q = array();

$q[] = 'CREATE TABLE `division`
        (
            `division_id` INT(2) PRIMARY KEY AUTO_INCREMENT,
            `division_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `division` (`division_name`)
        VALUES ('D1'),
               ('D2'),
               ('D3'),
               ('D4');";