<?php

$q = array();

$q[] = 'CREATE TABLE `votestatus`
        (
            `votestatus_id` INT(11) DEFAULT 0,
            `votestatus_name` VARCHAR(255) NOT NULL
        );';
$q[] = "INSERT INTO `votestatus` (`votestatus_name`)
        VALUES ('Ожидает проверки'),
               ('Открыто'),
               ('Закрыто');";