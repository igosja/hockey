<?php

$q = array();

$q[] = 'CREATE TABLE `votestatus`
        (
            `votestatus_id` TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
            `votestatus_name` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `votestatus` (`votestatus_name`)
        VALUES ('Ожидает проверки'),
               ('Открыто'),
               ('Закрыто');";