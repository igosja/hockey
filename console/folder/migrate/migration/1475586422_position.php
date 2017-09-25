<?php

$q = array();

$q[] = 'CREATE TABLE `position`
        (
            `position_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `position_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `position` (`position_name`)
        VALUES ('GK'), ('LD'), ('RD'), ('LW'), ('C'), ('RW');";