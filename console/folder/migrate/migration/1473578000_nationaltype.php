<?php

$q = array();

$q[] = 'CREATE TABLE `nationaltype`
        (
            `nationaltype_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `nationaltype_name` VARCHAR(255)
        );';

$q[] = "INSERT INTO `nationaltype` (`nationaltype_name`)
        VALUES ('Национальная');";