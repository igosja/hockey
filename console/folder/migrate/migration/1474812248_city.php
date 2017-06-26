<?php

$q = array();

$q[] = 'CREATE TABLE `city`
        (
            `city_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `city_country_id` INT(3) DEFAULT 0,
            `city_name` VARCHAR(255) NOT NULL
        );';