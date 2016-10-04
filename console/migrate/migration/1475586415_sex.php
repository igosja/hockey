<?php

$q = array();

$q[] = 'CREATE TABLE `sex`
        (
            `sex_id` INT(11) PRIMARY KEY AUTO_INCREMENT,
            `sex_name` VARCHAR(255) NOT NULL
        );';