<?php

$q = array();

$q[] = 'CREATE TABLE `position`
        (
            `position_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `position_name` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `position` (`position_name`)
        VALUES ('GK'), ('LD'), ('RD'), ('LW'), ('C'), ('RW');";