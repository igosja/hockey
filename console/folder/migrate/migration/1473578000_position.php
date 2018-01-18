<?php

$q = array();

$q[] = 'CREATE TABLE `position`
        (
            `position_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `position_name` VARCHAR(255),
            `position_short` VARCHAR(255)
        );';
$q[] = "INSERT INTO `position` (`position_short`, `position_short`)
        VALUES ('GK', 'Вратарь'),
               ('LD', 'Левый защитник'),
               ('RD', 'Правый защитник'),
               ('LW', 'Левый нападающий'),
               ('C', 'Центральный нападающий'),
               ('RW', 'Правый нападающий');";