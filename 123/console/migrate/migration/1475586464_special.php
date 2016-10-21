<?php

$q = array();

$q[] = 'CREATE TABLE `special`
        (
            `special_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `special_name` VARCHAR(255) NOT NULL
        );';