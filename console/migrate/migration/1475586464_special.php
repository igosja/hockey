<?php

$q = array();

$q[] = 'CREATE TABLE `special`
        (
            `special_id` TINYINT(2) PRIMARY KEY AUTO_INCREMENT,
            `special_name` VARCHAR(255) NOT NULL
        );';