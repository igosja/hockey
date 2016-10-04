<?php

$q = array();

$q[] = 'CREATE TABLE `position`
        (
            `position_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `position_name` VARCHAR(255) NOT NULL
        );';