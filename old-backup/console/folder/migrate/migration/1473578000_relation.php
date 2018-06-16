<?php

$q = array();

$q[] = 'CREATE TABLE `relation`
        (
            `relation_id` INT(1) PRIMARY KEY AUTO_INCREMENT,
            `relation_name` VARCHAR(255),
            `relation_order` INT(1) DEFAULT 0
        );';
$q[] = "INSERT INTO `relation` (`relation_name`, `relation_order`)
        VALUES ('Отрицательное', 2),
               ('Нейтральное', 1),
               ('Положительное', 0);";