<?php

$q = array();

$q[] = 'CREATE TABLE `sex`
        (
            `sex_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `sex_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `sex` (`sex_name`)
        VALUES ('мужской'), ('женский');";