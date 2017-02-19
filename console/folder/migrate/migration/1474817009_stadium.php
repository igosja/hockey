<?php

$q = array();

$q[] = 'CREATE TABLE `stadium`
        (
            `stadium_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `stadium_capacity` SMALLINT(5) DEFAULT 100,
            `stadium_city_id` INT(11) DEFAULT 0,
            `stadium_maintenance` MEDIUMINT(6) DEFAULT 398,
            `stadium_name` VARCHAR(255) NOT NULL
        );';