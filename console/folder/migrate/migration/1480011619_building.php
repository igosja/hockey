<?php

$q = array();

$q[] = 'CREATE TABLE `building`
        (
            `building_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `building_name` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `building` (`building_name`)
        VALUES ('base'),
               ('basemedical'),
               ('basephisical'),
               ('baseschool'),
               ('basescout'),
               ('basetraining');";