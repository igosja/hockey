<?php

$q = array();

$q[] = 'CREATE TABLE `rude`
        (
            `rude_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `rude_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `rude` (`rude_name`)
        VALUES ('нормальная'),
               ('грубая');";