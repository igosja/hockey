<?php

$q = array();

$q[] = 'CREATE TABLE `nationaltype`
        (
            `nationaltype_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `nationaltype_name` VARCHAR(255) NOT NULL
        );';

$q[] = "INSERT INTO `nationaltype` (`nationaltype_name`)
        VALUES ('Национальная'),
               ('U-21'),
               ('U-19');";