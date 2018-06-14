<?php

$q = array();

$q[] = 'CREATE TABLE `position`
        (
            `position_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `position_name` VARCHAR(255),
            `position_short` VARCHAR(255)
        );';
$q[] = "INSERT INTO `position` (`position_name`, `position_short`)
        VALUES ('Вратарь', 'GK'),
               ('Левый защитник', 'LD'),
               ('Правый защитник', 'RD'),
               ('Левый нападающий', 'LW'),
               ('Центральный нападающий', 'C'),
               ('Правый нападающий', 'RW');";