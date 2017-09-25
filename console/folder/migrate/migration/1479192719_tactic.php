<?php

$q = array();

$q[] = 'CREATE TABLE `tactic`
        (
            `tactic_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `tactic_name` VARCHAR(255)
        );';
$q[] = "INSERT INTO `tactic` (`tactic_name`)
        VALUES ('все в защиту'),
               ('защитная'),
               ('нормальная'),
               ('атакующая'),
               ('все в атаку');";